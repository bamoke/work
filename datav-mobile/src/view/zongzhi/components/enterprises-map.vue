<!--
 * @Author: Joy wang
 * @Date: 2021-06-01 06:40:42
 * @LastEditTime: 2021-06-02 04:33:37
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <van-loading size="24px" vertical v-if="showLoading">加载中...</van-loading>
    <ModuleCard title="重点企业经营情况" style="min-height: 100%">

    <div class="map-wrap">
      <div class="map-search-wrap" :class="{ active: !showLoading }">
        <div class="item content">
          <div class="search-box">
            <van-icon name="search" />
            <!-- <Icon type="ios-search" :size="18" color="rgba(255,255,255,.8)" /> -->
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
              v-for="(item, index) in comList"
              :key="index"
              @click="handleSelect(index)"
            >
              <!-- <span>{{ index + 1 }}</span> -->
              <span class="com-name">{{ item.title }}</span>
            </div>
          </div>
        </div>
      </div>
      <div id="map"></div>
      <div
        class="map-side right-side"
        style="display: none"
        :class="{ active: !showLoading }"
      >
        <div class="item">
          <div class="section">企业经营情况</div>
        </div>
        <div class="item content">
          <div class="company-info">
            <div class="title">
              <van-icon name="home-o" />{{ curCompany.title }}
            </div>
            <div class="company-item company-item-first">
              <div class="item-section">所属行业</div>
              <div class="item-value">{{ curCompany.industry }}</div>
            </div>
            <div class="company-item">
              <div class="item-section">产值(万元)</div>
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
              <div class="item-section">增加值</div>
              <div class="item-value">{{ curCompany.zjz_gross }}</div>
              <div class="item-section">同比增长</div>
              <div class="item-value">{{ curCompany.zjz_rise }}</div>
            </div>
            <div class="description">{{ curCompany.description }}</div>
          </div>
        </div>
      </div>
    </div>
    </ModuleCard>
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
        this.comList = [];
        return;
      }
      var regex = new RegExp(newValue);
      var data = this.originData.filter(function (item) {
        return regex.test(item.title);
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

        map.centerAndZoom(new BMapGL.Point(113.279208, 21.999191), 12); // 初始化地图,设置中心点坐标和地图级别
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
          console.log("内镂空：", rs.boundaries[1]);
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
        enterprisesApi.get_list().then((res) => {
          this.originData = this.transformGeo(res.data);
          // this.originData = this.comList = this.transformGeo(res.data);
        });
      });
    },

    // 数据地址解析
    transformGeo(comlist) {
      var BMapGL = this.myBMapGl;
      var map = this.myMap;
      var myGeo = new BMapGL.Geocoder();
      var newList = comlist.slice();
      var showDetail = this.handleShowDetail;

      newList.forEach((element, index) => {
        myGeo.getPoint(
          element.addr,
          function (point) {
            var marker, label;
            element.point = point;

            // 生成点
            marker = new BMapGL.Marker(new BMapGL.Point(point.lng, point.lat));
            map.addOverlay(marker);

            //添加点事件
            marker.addEventListener("click", function (e) {
              showDetail(index);
            });

            //
            label = new BMapGL.Label(element.title);
            marker.setLabel(label);
          },
          "珠海市"
        );
      });
      return newList;
    },

    handleGoback() {
      this.$router.back();
    },
    handleSelect(index) {
      const item = this.comList[index];
      var BMapGL = this.myBMapGl;
      var point = new BMapGL.Point(item.point.lng, item.point.lat);
      this.myMap.setCenter(point);
      this.myMap.setZoom(17);
      this.handleShowDetail(index);
    },
    handleShowDetail(index) {
      const item = this.comList[index];
      enterprisesApi.get_detail({ params: { id: item.id } }).then((res) => {
        var companyInfo = res;
        var zjzArr = companyInfo.zjzl.split("/");
        // 临时
        companyInfo.title = item.title;
        companyInfo.zjz_gross = zjzArr[0];
        companyInfo.zjz_rise = zjzArr[1];
        this.curCompany = companyInfo;
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

.map-wrap {
  position: relative;
  width: 100%;
  height: 100%;
  .map-search-wrap {
    position: absolute;
    top: 0;
    left:25%;
    z-index: 990;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    width: 50%;
    color: #fff;
    .item {
      margin-bottom: 12px;
      padding: 12px;
      // background-color: rgba(0, 0, 0, 0.6);
    }
    .com-list {
      box-sizing: border-box;
      height: 100%;
      overflow-y: auto;
      background-color: rgba(0, 0, 0, 0.6);
      .com-item {
        height: 36px;
        line-height: 36px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        font-size: 12px;
        cursor: pointer;
        color: rgba(255, 255, 255, 0.8);
      }
      .com-item:hover {
        background: rgba(0, 0, 0, 0.4);
      }
    }
  }
  .map-side {
    position: absolute;
    top: 5%;
    z-index: 990;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    width: 1.041667rem;
    height: 90%;
    color: #fff;
    .item {
      margin-bottom: 12px;
      padding: 12px;
      background-color: rgba(0, 0, 0, 0.6);
    }
    .content {
      position: relative;
      flex-grow: 1;
      text-align: left;
    }
    .section {
      flex: 0 0 auto;
      font-size: 16px;
      text-shadow: 0 2px 2px rgba(0, 0, 0, 0.7);
      line-height: 1;
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
  height: 3.125rem;
}
.search-box {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 18px 0 6px;
  width: 100%;
  height: 32px;
  border-radius: 16px;
  border: 1px solid rgba(0, 0, 0, 0.5);
  background-color: rgba(0, 0, 0, 0.7);
  .input {
    padding-left: 6px;
    width: 100%;
    height: 32px;
    line-height: 32px;
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