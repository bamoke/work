<!--
 * @Author: Joy wang
 * @Date: 2021-06-01 06:40:42
 * @LastEditTime: 2021-06-02 04:33:37
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="wrap">
    <Spin fix v-if="showLoading">
      <Icon type="ios-loading" size="48" class="demo-spin-icon-load"></Icon>
      <div>Loading</div>
    </Spin>

    <div class="map-side left-side" :class="{ active: !showLoading }">
      <div class="side-bar">
        <div class="section">重点企业目录</div>
      </div>

      <div class="comlist-side">
        <div class="search-box">
          <Icon type="ios-search" :size="18" color="rgba(255,255,255,.8)" />
          <input
            class="input"
            maxlength="24"
            v-model="keyword"
            placeholder="搜素过滤"
            type="text"
          />
        </div>
        <div class="com-list">
          <div
            class="com-item"
            :class="{ active: curCompanyIndex == index }"
            v-for="(item, index) in comList"
            :key="index"
            @click="handleSelect(index)"
          >
            <!-- <span>{{ index + 1 }}</span> -->
            <span class="com-name">{{ item.comname }}</span>
          </div>
        </div>
      </div>
    </div>
    <div id="map"></div>
    <div class="map-side right-side" :class="{ active: !showLoading }">
      <div class="side-bar">
        <div class="section">企业经营情况</div>
      </div>
      <div class="side-content">
        <div class="company-info">
          <div class="title">
            <Icon
              type="md-speedometer"
              :size="24"
              color="rgba(255,255,255,1)"
            />{{ curCompany.comname }}
          </div>
          <div class="company-item company-item-first">
            <div class="item-section">所属行业</div>
            <div class="item-value">{{ curCompany.industry }}</div>
          </div>
          <div class="company-item">
            <div class="item-section">{{ grossName }}({{ measure }})</div>
            <div class="item-value">{{ curCompany.gross }}</div>
            <div class="item-section">同比增长</div>
            <div class="item-value">{{ curCompany.rise }}</div>
          </div>
          <div class="company-item">
            <div class="item-section">用电量(万千瓦时)</div>
            <div class="item-value">{{ curCompany.electric_gross }}</div>
            <div class="item-section">同比增长</div>
            <div class="item-value">{{ curCompany.electric_rise }}</div>
          </div>
          <div class="company-item">
            <div class="item-section">{{ otherName }}</div>
            <div class="item-value">{{ curCompany.other }}</div>
          </div>
          <div class="description">经营情况说明:{{ curCompany.description }}</div>
        </div>
      </div>
    </div>
    <div class="control-box" :class="{ active: !showLoading }">
      <div class="back-btn" @click="handleGoback">返回</div>
    </div>
  </div>
</template>


<script>
import { loadBaiDuMap } from "@/libs/baidumap_gl";
import * as enterprisesApi from "@/api/enterprises";

export default {
  components: {},

  data() {
    return {
      keyword: "",
      grossName: "",
      measure: "",
      otherName: "",
      curCompanyIndex: null,
      curCompany: {},
      comList: [],
      originData: [],
      myBMapGl: null,
      myMap: null,
      showLoading: true,
    };
  },

  watch: {
    keyword(newValue) {
      if (newValue === "") {
        this.comList = this.originData;
        return;
      }
      var regex = new RegExp(newValue);
      var data = this.originData.filter(function (item) {
        return regex.test(item.comname);
      });
      this.comList = data;
    },
  },
  methods: {
    initMap() {
      loadBaiDuMap().then((BMapGL) => {
        setTimeout(() => {
          this.showLoading = false;
        }, 2000);

        let mapOptions = {
          minZoom: 11,
          maxZoom: 17,
        };
        let map = new BMapGL.Map("map", mapOptions);
        //
        this.myBMapGl = BMapGL;
        this.myMap = map;

        map.centerAndZoom(new BMapGL.Point(113.279208, 21.999191), 13); // 初始化地图,设置中心点坐标和地图级别
        map.enableScrollWheelZoom(true); //开启鼠标滚轮缩放
        // map.setHeading(64.5);
        map.setTilt(60);
        // map.setMinZoom(12);
        // map.setMaxZoom(15);
        map.setMapType(BMAP_EARTH_MAP); // 设置地图类型为地球模式

        // 边界
        var bd = new BMapGL.Boundary();
        bd.get("金湾区", function (rs) {
          // console.log('外轮廓：', rs.boundaries[0]);
          // console.log("内镂空：", rs.boundaries[1]);
          var hole = new BMapGL.Polygon(rs.boundaries, {
            strokeColor: "#04d1fd",
            strokeStyle: "dashed",
            // strokeWeight: "1",
            // fillColor: "blue",
            fillOpacity: 0,
          });
          map.addOverlay(hole);
        });

        // 路网
        map.setDisplayOptions({
          street: false, //是否显示路网（只对卫星图和地球模式有效）
        });
        //
        map.setDisplayOptions({
          poi: false, //是否显示POI信息
        });
        map.setDisplayOptions({
          poiText: false,
        });
        map.setDisplayOptions({
          poiIcon: false,
        });

        // 数据获取
        enterprisesApi.get_list_by_map().then((res) => {
          this.originData = this.comList = res.data.list;
          this.transformGeo(res.data.list);
          // this.originData = this.transformGeo(res.data);
          // this.originData = this.comList = this.transformGeo(res.data);
        });
      });
    },

    // 数据地址解析
    transformGeo(comlist) {
      var BMapGL = this.myBMapGl;
      var map = this.myMap;
      var newList = comlist.slice();
      var showDetail = this.handleShowDetail;

      newList.forEach((element, index) => {
        var marker, label;

        // 生成点
        marker = new BMapGL.Marker(new BMapGL.Point(element.lng, element.lat));
        map.addOverlay(marker);

        //添加点事件
        marker.addEventListener("click", function (e) {
          showDetail(index);
        });

        //
        // label = new BMapGL.Label(element.title);
        // marker.setLabel(label);
      });
    },

    handleGoback() {
      this.$router.back();
    },
    handleSelect(index) {
      const item = this.comList[index];
      var BMapGL = this.myBMapGl;

      var point = new BMapGL.Point(item.lng, item.lat);
      this.myMap.setCenter(point);
      this.myMap.setZoom(17);
      this.handleShowDetail(index);
      this.curCompanyIndex = index;
    },
    handleShowDetail(index) {
      const item = this.comList[index];
      var point = new BMapGL.Point(item.lng, item.lat);
      enterprisesApi.get_detail(item.id).then((res) => {
        this.curCompany = res.data.info;
        this.grossName = res.data.grossName;
        this.otherName = res.data.otherName;
        this.measure = res.data.measure;
        var opts = {
          width: 200, // 信息窗口宽度
          height: 40, // 信息窗口高度
          title: res.data.info.comname, // 信息窗口标题
          message: "",
        };
        var infoWindow = new BMapGL.InfoWindow('',opts); // 创建信息窗口对象
        this.myMap.openInfoWindow(infoWindow, point); //开启信息窗口
      });
    },
  },
  mounted() {
    this.initMap();

    // 获取数据
  },
  created() {},
};
</script>

<style lang="less" scoped>
.wrap {
  position: relative;
  width: 100%;
  height: 100%;
  .map-side {
    position: absolute;
    top: 5%;
    z-index: 990;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    width: 360px;
    height: 90%;
    color: #fff;
    .side-bar {
      margin-bottom: 12px;
      padding: 16px;
      background-color: rgba(0, 0, 0, 0.6);
      .section {
        flex: 0 0 auto;
        font-size: 24px;
        text-shadow: 0 2px 2px rgba(0, 0, 0, 0.7);
        line-height: 1;
      }
    }
    .side-content {
      position: relative;
      flex-grow: 1;
      text-align: left;
      padding: 16px;
      background-color: rgba(0, 0, 0, 0.6);
    }
    .comlist-side {
      display: flex;
      flex-direction: column;
      flex-shrink: 1;
      width: 100%;
      padding: 16px;
      text-align: left;
      background-color: rgba(0, 0, 0, 0.6);
      .com-list {
        box-sizing: border-box;
        flex-shrink:1;
        height: 100%;
        overflow-y: auto;
        .com-item {
          padding: 0 12px;
          height: 48px;
          line-height: 48px;
          border-bottom: 1px solid rgba(255, 255, 255, 0.3);
          font-size: 16px;
          cursor: pointer;
          color: rgba(255, 255, 255, 0.8);
        }
        .com-item:hover {
          background: rgba(0, 0, 0, 0.4);
        }
        .active {
          background: #0066ff !important;
          color: #fff;
        }
      }
    }
  }
  .left-side {
    left: 0;
    transform: translatex(-360px);
    opacity: 0;
    transition: all 0.3s;
  }
  .right-side {
    right: 0;
    transform: translatex(360px);
    opacity: 0;
    transition: all 0.3s;
    .company-info {
      color: rgba(255, 255, 255, 0.8);
      .title {
        margin-bottom: 24px;
        color: #fff;
        font-size: 18px;
      }
      .company-item {
        display: flex;
        // justify-content: space-between;
        line-height: 1.2;
        font-size: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        .item-section {
          flex: 0 0 auto;
          padding: 12px 6px;
          width: 22%;
          border-left: 1px solid rgba(255, 255, 255, 0.3);
        }
        .item-value {
          flex: 0 0 auto;
          padding: 12px 6px;
          width: 28%;
          border-left: 1px solid rgba(255, 255, 255, 0.3);
        }
      }
      .company-item-first {
        border-top: 1px solid rgba(255, 255, 255, 0.3);
      }
      .description {
        margin-top: 12px;
        padding: 12px;
        line-height: 1.5;
        background: rgba(0, 0, 0, 0.5);
      }
    }
  }
  .active {
    transform: translate(0px, 0px);
    opacity: 1;
  }
}
#map {
  width: 100%;
  height: 100%;
}
.search-box {
  display: flex;
  align-items: center;
  padding: 0 18px 0 6px;
  width: 100%;
  height: 36px;
  border-radius: 18px;
  border: 1px solid rgba(0, 0, 0, 0.5);
  background-color: rgba(0, 0, 0, 0.7);
  .input {
    padding-left: 6px;
    width: 100%;
    height: 36px;
    line-height: 36px;
    border: none;
    background-color: transparent;
    outline: none;
    color: #fff;
  }
  .input::placeholder {
    color: rgba(255, 255, 255, 0.8);
  }
}

//***/
.ivu-spin-fix {
  background: rgba(0, 0, 0, 0.6);
}
.demo-spin-icon-load {
  animation: ani-demo-spin 1s linear infinite;
}
@keyframes ani-demo-spin {
  from {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(180deg);
  }
  to {
    transform: rotate(360deg);
  }
}

//
.control-box {
  position: absolute;
  left: 50%;
  bottom: 5%;
  z-index: 990;
  margin-left: -160px;
  width: 320px;
  opacity: 0;
  transform: translate(0px, 60px);
  transition: all 0.3s;
}
.back-btn {
  background: rgba(0, 0, 0, 0.6);
  width: 320px;
  height: 48px;
  line-height: 48px;
  border-radius: 24px;
  font-size: 18px;
  text-align: center;
  cursor: pointer;
  color: #fff;
  transition: opacity 0.2s;
}
.back-btn:hover {
  opacity: 0.8;
}
</style>