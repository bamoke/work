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
      <div class="table-wrap" ref="ref-table-wrap" style="height: 100%">
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
            <div class="item" @click="handleShowDynamic('town')">
              {{ curTown }}<van-icon name="play" class="icon" />
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
                  @click="handleSelectVal('curTown', item.value)"
                >
                  {{ item.text }}
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
                  @click="handleSelectVal('curCate', item.value)"
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
                    <div class="filter-type">
                      <select v-model="curFilterType">
                        <option
                          :value="item.key"
                          v-for="item of filterTypeList"
                          :key="item.key"
                        >
                          {{ item.title }}
                        </option>
                      </select>
                    </div>
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
                        style="width: 80px"
                      />(万元)
                    </div>
                  </div>
                  <div>
                    <van-button
                      type="info"
                      size="mini"
                      @click="handleComfirmFilter"
                      >确认筛选</van-button
                    >
                    <van-button
                      type="default"
                      size="mini"
                      @click="handleResetFilter"
                      >重置</van-button
                    >
                  </div>
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
          />
        </Scroll>
      </div>
    </PageCard>
  </div>
</template>

<script>
import * as comMonitorApi from "@/api/monitor.js";
import PageCard from "@/components/main/page-card.vue";
export default {
  components: { PageCard },
  data() {
    return {
      scrollHeihgt: 0,
      filterTypeList: [],
      curFilterType: "gross",
      grossVal: "",
      grossType: "egt",
      keyword: "",
      curCate: "全部类别",
      curTown: "所有街镇",

      title: "",

      showDynamic: false,
      dynamicContentActive: "",

      cateList: [],
      townList: [],

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
    handleSelectVal(name, val) {
      this[name] = val;
      this.getData();
      this.showDynamic = false;
    },
    handleResetFilter() {
      this.curFilterType = "gross";
      this.grossVal = "";
      this.grossType = "";
      this.showDynamic = false;
      this.getData();
    },
    handleComfirmFilter() {
      if (this.grossVal == "") {
        this.$dialog.alert({
          message: "筛选数值不能为空",
        });
        return;
      }

      this.getData();
      this.showDynamic = false;
    },
    handleConfirmSearch(val) {
      this.getData();
    },
    handleSelectCate(name, val) {
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
        comMonitorApi
          .get_investment_com({
            params: {
              ...this.queryData,
              page: this.pageInfo.page + 1,
            },
          })
          .then((res) => {
            this.title = res.data.title;
            this.pageInfo = res.data.pageInfo;
            this.tableColumn = res.data.columns;
            this.tableData = this.tableData.concat(res.data.list);
            resolve();
          });
      });
    },
    getData(queryData = this.queryData) {
      this.tableLoading = true;
      comMonitorApi
        .get_investment_com({ params: queryData})
        .then((res) => {
          (this.filterTypeList = res.data.filterTypeList),
            (this.title = res.data.title);
          this.pageInfo = res.data.pageInfo;
          this.tableColumn = res.data.columns;
          this.tableData = res.data.list;

          this.curCate = res.data.curCate
          this.curTown = res.data.curTown
          this.tableLoading = false;
        },reject=>{
          console.log(reject)
        });
    },
  },
  watch: {},
  computed: {
    queryData() {
      return {
        town: this.curTown,
        cate: this.curCate,
        keyword: this.keyword,
        filter_type: this.curFilterType,
        gross_val: this.grossVal,
        gross_type: this.grossType,
      };
    },
  },
  mounted() {
    ///
    let queryData = this.$route.query;

    if (queryData.cate) {
      this.curCate = queryData.cate;
    }
    if (queryData.keyword) {
      this.keyword = queryData.keyword;
    }
    if (queryData.gross_val) {
      this.grossVal = queryData.gross_val;
    }
    if (queryData.gross_type) {
      this.grossType = queryData.gross_type;
    }

    comMonitorApi.get_investment_cate({ params: { cate: "2" } }).then((res) => {
      this.cateList = res.data.cateList;
      this.townList = res.data.townList;
    });
    this.getData();
    var height = this.$refs["ref-table-wrap"].scrollHeight;
    this.scrollHeihgt = height - 42;
  },
};
</script>

<style lang="less" scoped>
// .m-module-card-wrap .content {
//   flex-grow:1;
// }
.m-monitor-wrap {
  width: 100%;
  min-height: 100%;
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
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
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
    width: 40%;
  }
  .danymic-wrap {
    position: absolute;
    left: 0;
    top: 0.245rem;
    z-index: 99;
    background-color: rgba(255, 255, 255, 1);
    width: 100%;

    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    .dynamic-content {
      display: flex;
      flex-wrap: wrap;
      padding: 0.0625rem;
      .cate-item {
        padding: 4px 0;
        width: 20%;
        margin-right: 0.125rem;
        white-space: nowrap;
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
.filter-bar {
  display: flex;
  justify-content: space-between;
  width: 100%;
  .filter-item {
    width: 80%;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding-bottom: 12px;
    font-size: 12px;
    .section {
      text-align: right;
    }
    .params {
      display: flex;
      padding-left: 12px;
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
