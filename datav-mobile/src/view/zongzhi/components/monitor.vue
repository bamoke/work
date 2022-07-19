<!--
 * @Author: Joy wang
 * @Date: 2021-05-31 05:00:41
 * @LastEditTime: 2021-06-01 02:36:16
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <PageCard :title="title" class="m-monitor-wrap">
      <template v-slot:extra>
        <van-button
          size="mini"
          style="width: 80px"
          type="info"
          @click="goBack()"
          ><van-icon name="arrow-left" />返回</van-button
        >
      </template>

      <div ref="ref-table-wrap" class="table-wrap">
        <Scroll
          :height="scrollHeihgt"
          :on-reach-bottom="handleReachBottom"
          :distance-to-edge="-24"
          :loading-text="loadingText"
        >
          <div class="total-bar">
            <div class="item" @click="handleShowDynamic('town')">
              {{ curTown }}<van-icon name="play" class="icon" />
            </div>
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
                class="dynamic-content dynamic-town"
                v-show="dynamicContentActive == 'town'"
              >
                <div
                  class="cate-item"
                  :class="[{ active: item.text == curTown }]"
                  v-for="(item, index) of townList"
                  :key="index"
                  @click="handleSelectVal('curTown', item.text)"
                >
                  {{ item.text }}
                </div>
              </div>

              <div
                class="dynamic-content"
                v-show="dynamicContentActive == 'filter'"
              >
                <div class="filter-bar">
                  <div class="filter-item">
                    <select v-model="curGrossFilterType" class="section select-box">
                      <option
                        :value="item.key"
                        v-for="(item, index) of filterTypeList"
                        :key="index"
                      >
                        {{ item.title }}{{ grossName }}
                      </option>
                    </select>
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
                  <div class="filter-item">
                    <div class="section">累计增速:</div>
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
                  <div class="filter-item">
                    <div class="section">用电量:</div>
                    <div class="params">
                      <van-radio-group
                        direction="horizontal"
                        v-model="electricType"
                      >
                        <van-radio name="egt" icon-size="14px"
                          >大于等于</van-radio
                        >
                        <van-radio name="elt" icon-size="14px"
                          >小于等于</van-radio
                        >
                      </van-radio-group>
                      <input
                        v-model="electricVal"
                        type="number"
                        size="small"
                        placeholder="请输入"
                        style="width: 100px"
                      />
                    </div>
                    <div class="measure">万千瓦时</div>
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
          <div class="summary-box">
            <div class="summary-title">
              总计<span class="measure">({{ measure }})</span>：
            </div>
            <div class="summary-item">
              <span class="section">当月：</span>
              <span class="val">{{ summaryInfo.cur_gross || "--" }}</span>
            </div>
            <div class="summary-item">
              <span class="section">本年累计:</span>
              <span class="val">{{ summaryInfo.lj_gross || "--" }}</span>
            </div>
            <div class="summary-item">
              <span class="section">去年止累计:</span>
              <span class="val">{{ summaryInfo.prev_year_gross || "--" }}</span>
            </div>
            <div class="summary-item">
              <span class="section">名义累计增速:</span>
              <span class="val"
                >{{ summaryInfo.lj_rise || "--"
                }}<span class="measure">(%)</span></span
              >
            </div>
            <div class="summary-item">
              <span class="section">用电量:</span>
              <span class="val"
                >{{ summaryInfo.electric_gross || "--"
                }}<span class="measure">(万千瓦时)</span></span
              >
            </div>
          </div>
          <Table
            size="small"
            stripe
            :columns="tableColumn"
            :data="tableData"
            border
            :loading="tableLoading"
          />
        </Scroll>
      </div>
    </PageCard>
  </div>
</template>

<script>
import * as sishangApi from "@/api/sishang.js";
import PageCard from "@/components/main/page-card.vue";
export default {
  components: { PageCard },
  data() {
    return {
      scrollHeihgt: "",
      curGrossFilterType: "cur_gross",
      electricType:'egt',
      electricVal:'',
      grossVal: "",
      grossType: "egt",
      riseVal: "",
      riseType: "egt",
      keyword: "",
      curCate: "",
      curTown: "",

      title: "",
      grossName: "",
      measure: "",
      tips: "",

      showDynamic: false,
      dynamicContentActive: "",

      filterTypeList: [],
      cateList: [],
      townList: [],

      loadingText: "加载中",
      tableLoading: true,
      tableColumn: [],
      tableData: [],
      summaryInfo: [],
      pageInfo: {
        page: 1,
        total: 0,
      },
    };
  },
  methods: {
    goBack() {
      this.$router.back();
    },

    handleResetFilter() {
      this.electricVal = "";
      this.elecricType = "egt";
      this.grossVal = "";
      this.grossType = "egt";
      this.riseVal = "";
      this.riseType = "egt";
      this.getData();
      this.showDynamic = false;
    },
    handleComfirmFilter() {
      if (this.grossVal == "" && this.riseVal == "" && this.electricVal == '') {
        this.$dialog.alert({
          message: "筛选数值不能为空",
        });
        return;
      }
      if (this.grossType == "" && this.riseType == "" && this.electricType == "") {
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
        sishangApi
          .get_list({
            params: { ...this.queryData, page: this.pageInfo.page + 1 },
          })
          .then((res) => {
            this.title = res.data.title;
            this.tips = res.data.tips;
            this.grossName = res.data.grossName;
            this.pageInfo = res.data.pageInfo;
            this.summaryInfo = res.data.summaryInfo;
            this.tableColumn = res.data.tableColumn;
            this.tableData = this.tableData.concat(res.data.tableData);
            resolve();
          });
      });
    },
    getData(queryData = this.queryData) {
      this.tableLoading = true;
      sishangApi.get_list({ params: queryData }).then((res) => {
        this.title = res.data.title;
        this.tips = res.data.tips;
        this.grossName = res.data.grossName;
        this.pageInfo = res.data.pageInfo;
        this.tableColumn = res.data.tableColumn;
        this.tableData = res.data.tableData;
        this.measure = res.data.measure;
        this.tableLoading = false;
        this.summaryInfo = res.data.summaryInfo;
      });
    },
  },
  watch: {},
  computed: {
    queryData() {
      return {
        cate: this.curCate,
        town: this.curTown,
        keyword: this.keyword,
        gross_filter_type:this.curGrossFilterType,
        gross_val: this.grossVal,
        gross_type: this.grossType,
        rise_val: this.riseVal,
        rise_type: this.riseType,
        electric_val: this.electricVal,
        electric_type: this.electricType,
      };
    },
  },
  mounted() {
    ///
    let queryData = this.$route.query;
    this.curTown = queryData.town;
    this.curCate = queryData.cate;
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
    this.getData(queryData);
    sishangApi.get_cate().then((res) => {
      this.cateList = res.data.cateList;
      this.townList = res.data.townList;
      this.filterTypeList = res.data.filterType;
    });

    //
    var height = this.$refs["ref-table-wrap"].scrollHeight;
    this.scrollHeihgt = height - 72;
  },
};
</script>

<style lang="less" scoped>
// .m-module-card-wrap .content {
//   flex-grow:1;
// }
.m-monitor-wrap {
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100%;
  .bar {
    margin-bottom: 0 !important;
  }
  .table-wrap {
    // background-color: #ff0000;
    height: 100%;
  }
  .top-bar {
    display: flex;
    align-items: flex-start;
    align-items: center;
    margin-bottom: 12px;
    padding: 12px 0;
    line-height: 1;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    .title {
      text-align: left;
      font-size: 16px;
    }
    .tips {
      margin-left: 12px;
      text-align: left;
      font-size: 12px;
      opacity: 0.8;
    }
  }
}
.total-bar {
  position: relative;
  display: flex;
  align-items: center;
  margin-bottom: 0.0625rem;
  padding: 0 0.0625rem;
  height: 0.25rem;
  border: 1px solid #e8e8e8;
  .item {
    flex: 0 0 auto;
    width: 20%;
    cursor: pointer;
  }
  .search-item {
    flex-shrink: 1;
    width: 100%;
  }
  .danymic-wrap {
    position: absolute;
    left: 0;
    top: 0.25rem;
    z-index: 99;
    background-color: rgba(255, 255, 255, 1);
    width: 100%;

    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    .dynamic-content {
      display: flex;
      padding: 0.0625rem;
      .cate-item {
        margin-right: 0.125rem;
        cursor: pointer;
      }
      .cate-item:hover {
        text-decoration: underline;
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
.summary-box {
  display: flex;
  padding-bottom: 12px;
  height: 30px;
  line-height: 18px;
  .summary-title {
    font-weight: bold;
    color: #ee3300;
  }
  .summary-item {
    margin-right: 12px;
    .val {
      font-weight: bold;
      .measure {
        font-weight: normal;
        font-size: 11px;
        color: #969696;
      }
    }
  }
}
.filter-bar {
  width: 100%;
  .filter-item {
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
</style>
