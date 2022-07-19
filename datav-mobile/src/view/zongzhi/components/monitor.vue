<!--
 * @Author: Joy wang
 * @Date: 2021-05-31 05:00:41
 * @LastEditTime: 2021-06-01 02:36:16
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap m-monitor-wrap">
    <ModuleCard :title="title">
      <template v-slot:extra>
        <div class="tips" v-if="tips"><van-icon name="info-o" />{{ tips }}</div>
      </template>
      <div class="filter-bar">
        <div class="l-row l-row-bt">
          <div>
            <div class="item">
              <div class="section">所属街镇:</div>
              <div class="params">
                <div class="unit active">全部</div>
                <div class="unit">红旗</div>
                <div class="unit">三灶</div>
                <div class="unit">平沙</div>
                <div class="unit">南水</div>
              </div>
            </div>
            <div class="item">
              <div class="section">名称关键词:</div>
              <div class="params">
                <Input size="small" placeholder="请输入企业名称关键字" />
              </div>
            </div>
          </div>
          <div>
            <div class="item">
              <div class="section">{{ tableColumn.gross }}:</div>
              <div class="params">
                <van-radio-group
                  size="small"
                  direction="horizontal"
                  v-model="grossType"
                >
                  <van-radio label="gt" icon-size="16px">大于</van-radio>
                  <van-radio label="lt" icon-size="16px">小于</van-radio>
                </van-radio-group>
                <Input size="small" placeholder="请输入" style="width: 100px" />
              </div>
            </div>
            <div class="item">
              <div class="section">同比增长:</div>
              <div class="params">
                <van-radio-group direction="horizontal" v-model="riseType">
                  <van-radio label="gt" icon-size="16px">大于</van-radio>
                  <van-radio label="lt" icon-size="16px">小于</van-radio>
                </van-radio-group>
                <Input size="small" placeholder="请输入" style="width: 100px" />
              </div>
            </div>
          </div>
        </div>
        <div class="filter-ft" style="text-align: center">
          <van-button type="info" style="width: 200px" size="small"
            >提交搜索过滤</van-button
          >
        </div>
      </div>
      <div class="total-bar">
        总计:<strong>{{ pageInfo.total }}</strong>
      </div>
      <div class="table-wrap">
        <BmkTable :columns="tableColumn" :data="tableData" />
      </div>
    </ModuleCard>
  </div>
</template>

<script>
import * as MonitorApi from "@/api/monitor";
import BmkTable from "@/components/common/bmk-table.vue";
export default {
  components: {
    BmkTable,
  },
  data() {
    return {
      grossType: "",
      riseType: "",
      title: "",
      tips: "",
      tableColumn: {},
      tableData: [],
      originTableData: [],
      pageInfo:{},
      keyword: "",
    };
  },
  methods: {},
  watch: {
    keyword(newValue) {
      var regex = new RegExp(newValue);
      var data = this.originTableData.filter(function (item) {
        return regex.test(item.title);
      });
      this.tableData = data;
    },
  },

  mounted() {
    ///
    let queryData = this.$route.query;

    MonitorApi.get_data({ params: { table: "default" } }).then((res) => {
      var tableColumn = [];
      this.title = res.title;
      this.tips = res.tips;
      this.tableData = this.originTableData = res.data;
      this.pageInfo = res.pageInfo
      this.tableColumn = res.column;
    });
  },
};
</script>

<style lang="less" scoped>
.m-monitor-wrap {
  width: 100%;
  .table-wrap {
    // height: 440px;
    overflow-y: auto;
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
  .filter-bar {
    width: 100%;
    margin-bottom: 0.125rem;
    .item {
      width: 100%;
      display: flex;
      padding-bottom: 12px;
      font-size: 12px;
      .section {
        width: 0.416667rem;
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
}
.total-bar {
  padding-bottom:6px;
}
</style>
