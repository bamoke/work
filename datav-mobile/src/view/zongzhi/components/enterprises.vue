<!--
 * @Author: Joy wang
 * @Date: 2021-05-31 05:00:41
 * @LastEditTime: 2021-06-01 02:36:16
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <PageCard
      :title="'重点企业经营情况(企业数:' + pageInfo.total + ')'"
      class="m-monitor-wrap"
    >
      <template v-slot:extra>
        <van-button
          type="info"
          size="mini"
          block
          :to="{ name: 'gdp_company_map' }"
          >在地图中查看</van-button
        >
      </template>
      <div class="com-description" :class="[{ descactive: showDesc }]">
        <div class="com-name">{{ comDetail.comname }}</div>
        <div class="desc">{{ comDetail.description }}</div>
        <div class="close-btn">
          <van-button
            type="default"
            size="small"
            block
            @click="showDesc = false"
            >关闭</van-button
          >
        </div>
      </div>

      <div ref="ref-table-wrap" class="table-wrap">
        <Scroll
          :height="scrollHeihgt"
          :on-reach-bottom="handleReachBottom"
          :distance-to-edge="-24"
          :loading-text="loadingText"
        >
          <div class="total-bar">
            <div class="item" @click="handleShowDynamic('cate')">
              {{ curCate }}<van-icon name="play" class="icon" />
            </div>
            <div class="item" @click="handleShowDynamic('filter')">
              筛选<van-icon name="play" class="icon" />
            </div>
            <div class="item search-item">
              <van-search
                v-model="keyword"
                background="rgba(255,255,255,0)"
                style="width: 100%"
                @search="handleConfirmSearch"
                placeholder="请输入搜索关键词"
              />
            </div>
            <div class="danymic-wrap" v-show="showDynamic">
              <div
                class="dynamic-content dynamic-cate"
                v-show="dynamicContentActive == 'filter'"
              >
                <div class="filter-bar">
                  <div class="item">
                    <div class="section">{{ grossName }}:</div>
                    <div class="params">
                      <van-radio-group
                        size="small"
                        direction="horizontal"
                        v-model="grossType"
                      >
                        <van-radio name="egt" icon-size="14px"
                          >大于等于</van-radio
                        >
                        <van-radio name="elt" icon-size="14px"
                          >小于等于</van-radio
                        >
                      </van-radio-group>
                      <input
                        v-model="grossVal"
                        size="small"
                        type="number"
                        placeholder="请输入"
                        style="width: 100px"
                      />
                    </div>
                    <div class="measure">{{ measure }}</div>
                  </div>
                  <div class="item">
                    <div class="section">同比增长:</div>
                    <div class="params">
                      <van-radio-group
                        direction="horizontal"
                        v-model="riseType"
                      >
                        <van-radio name="egt" icon-size="14px"
                          >大于等于</van-radio
                        >
                        <van-radio name="elt" icon-size="14px"
                          >小于等于</van-radio
                        >
                      </van-radio-group>
                      <input
                        v-model="riseVal"
                        type="number"
                        size="small"
                        placeholder="请输入"
                        style="width: 100px"
                      />
                    </div>
                    <div class="measure">%</div>
                  </div>
                  <div style="padding-left: 0.625rem">
                    <van-button
                      type="info"
                      size="mini"
                      @click="handleComfirmFilter"
                      style="width: 120px"
                      >确认筛选</van-button
                    >
                    <van-button
                      type="default"
                      size="mini"
                      @click="handleResetFilter"
                      style="width: 80px"
                      >重置</van-button
                    >
                  </div>
                </div>
              </div>

              <div
                class="dynamic-content dynamic-cate"
                v-show="dynamicContentActive == 'cate'"
              >
                <div
                  class="cate-item"
                  :class="[{ active: item.text == curCate }]"
                  v-for="(item, index) of cateList"
                  :key="index"
                  @click="handleSelectVal('curCate', item.text)"
                >
                  {{ item.text }}
                </div>
              </div>
            </div>
          </div>
          <Table
            size="small"
            stripe
            :columns="tableColumn"
            :data="tableData"
            :loading="tableLoading"
            border
            @on-row-click="handleShowDesc"
          >
            <template slot-scope="{ row }" slot="view">
              查看<strong><van-icon name="arrow" /></strong>
            </template>
          </Table>
        </Scroll>
      </div>
    </PageCard>
  </div>
</template>

<script>
import * as keApi from "@/api/enterprises.js";
import PageCard from "@/components/main/page-card.vue";
export default {
  components: { PageCard },
  data() {
    return {
      scrollHeihgt: 0,


      grossVal: "",
      grossType: "egt",
      riseVal: "",
      riseType: "egt",
      keyword: "",
      curCate: "工业",

      title: "",
      grossName: "",
      measure: "",
      tips: "",

      showDynamic: false,
      dynamicContentActive: "",

      cateList: [],

      showDesc: false,
      comDetail: {},

      loadingText: "加载中",
      tableLoading: true,
      tableColumn: [],
      tableData: [],
      pageInfo: {
        page: 1,
        total: 0,
      },
    };
  },
  methods: {
    touchPage() {
      this.showDesc = false;
    },
    handleShowDesc(row) {
      this.showDesc = true;
      keApi.get_detail(row.id).then((res) => {
        this.comDetail = res.data.info;
      });
    },
    handleResetFilter() {
      this.grossVal = "";
      this.grossType = "";
      this.riseVal = "";
      this.riseType = "";
      this.getData();
      this.showDynamic = false;
    },
    handleComfirmFilter() {
      if (this.grossVal == "" && this.riseVal == "") {
        this.$dialog.alert({
          message: "筛选数值不能为空",
        });
        return;
      }
      if (this.grossType == "" && this.riseType == "") {
        this.$dialog.alert({
          message: "请选择筛选条件",
        });
        return;
      }
      this.getData();
      this.showDynamic = false;
    },
    handleConfirmSearch(val) {
      this.getData();
    },
    handleSelectVal(name, val) {
      this[name] = val;
      this.getData();
      this.showDynamic = false;
    },
    handleShowDynamic(type) {
      if (this.dynamicContentActive == type) {
        this.showDynamic = !this.showDynamic;
      } else {
        this.showDynamic = true;
      }
      this.dynamicContentActive = type;
    },
    handleReachBottom() {
      return new Promise((resolve) => {
        if (
          this.pageInfo.total <=
          this.pageInfo.page * this.pageInfo.pageSize
        ) {
          this.loadingText = "没有更多";
          return resolve();
        }
        keApi
          .get_list({
            params: { ...this.queryData, page: this.pageInfo.page + 1 },
          })
          .then((res) => {
            this.title = res.data.title;
            this.tips = res.data.tips;
            this.grossName = res.data.grossName;
            this.pageInfo = res.data.pageInfo;
            this.tableColumn = res.data.tableColumn;
            this.tableData = this.tableData.concat(res.data.tableData);
            resolve();
          });
      });
    },
    getData(queryData = this.queryData) {
      this.tableLoading = true;
      keApi.get_list({ params: queryData }).then((res) => {
        this.tips = res.data.tips;
        this.grossName = res.data.grossName;
        this.pageInfo = res.data.pageInfo;
        this.tableColumn = res.data.tableColumn;
        this.tableData = res.data.tableData;
        this.measure = res.data.measure;
        this.tableLoading = false;
      });
    },
  },
  watch: {},
  computed: {
    queryData() {
      return {
        cate: this.curCate,
        keyword: this.keyword,
        gross_val: this.grossVal,
        gross_type: this.grossType,
        rise_val: this.riseVal,
        rise_type: this.riseType,
      };
    },
  },
  mounted() {
    ///
    let queryData = this.$route.query;
    if (queryData.keyword) {
      this.keyword = queryData.keyword;
    }
    if (queryData.gross_val) {
      this.grossVal = queryData.gross_val;
    }
    if (queryData.gross_type) {
      this.grossType = queryData.gross_type;
    }
    if (queryData.rise_val) {
      this.riseVal = queryData.rise_val;
    }
    this.getData();
    keApi.get_cate().then((res) => {
      this.cateList = res.data.cateList;
    });

    var height = this.$refs["ref-table-wrap"].scrollHeight;
    this.scrollHeihgt = height;
  },
};
</script>

<style lang="less" scoped>
// .m-module-card-wrap .content {
//   flex-grow:1;
// }
.table-wrap {
  // background-color: #ff0000;
  height: 100%;
}
.total-bar {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 0.0625rem;
  height: 0.25rem;
  border: 1px solid #e8e8e8;
  .item {
    flex: 0 0 auto;
    width: 20%;
  }
  .search-item {
    flex-shrink: 1;
    width: 40%;
  }
  .danymic-wrap {
    position: absolute;
    left: 0;
    top: 0.25rem;
    z-index: 99;
    background-color: rgba(255, 255, 255, 1);
    width: 100%;
    // height: 0.25rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    .dynamic-content {
      display: flex;
      padding: 0.0625rem;
      .cate-item {
        margin-right: 0.125rem;
      }
      .active {
        font-weight: bold;
        color: #ff0000;
      }
    }
  }
  .icon {
    transform: rotate(90deg);
  }
}
.filter-bar {
  width: 100%;
  .item {
    width: 100%;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding-bottom: 12px;
    font-size: 12px;
    .section {
      flex: 0 0 auto;
      width: 0.625rem;
      text-align: left;
    }
    .params {
      display: flex;
      padding-right: 0.0625rem;
    }
    .unit {
      margin-right: 12px;
      line-height: 1;
      padding: 4px 12px;
      display: inline-block;
    }
    .active {
      background-color: #3399ff;
      color: #fff;
    }
  }
  .search-box {
    display: flex;
    align-items: center;
    padding: 0 18px 0 6px;
    width: 320px;
    height: 36px;
    border-radius: 18px;
    border: 1px solid rgba(0, 0, 0, 0.2);
    .input {
      border: none;
      background-color: transparent;
      outline: none;
      // color: #fff;
    }
    .input::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }
  }
}
.com-description {
  position: absolute;
  right: -0.0625rem;
  top: 0;
  z-index: 991;
  padding: 0.0625rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  width: 30%;
  height: 100%;
  background-color: #fff;
  box-shadow: -4px 0 4px rgba(0, 0, 0, 0.1);
  overflow-y: auto;
  transform: translateX(100%);
  transition: all 0.2s;
  .com-name {
    margin-bottom: 6px;
    padding-bottom: 6px;
    border-bottom: 1px solid #e8e8e8;
    font-weight: bold;
    font-size: 12px;
    line-height: 1;
  }
  .desc {
    flex-grow: 1;
    color: #696969;
  }
}
.descactive {
  transform: translateX(0);
}
</style>
