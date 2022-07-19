<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:45:06
 * @LastEditTime: 2021-06-01 02:59:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <BmkTitleTotal :total="totalInfo.jw"></BmkTitleTotal>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="各镇规上工业总产值情况">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'townData')"
              :type="chartModeBtnType('gross', 'townData')"
              size="mini"
              >总量及增速</van-button
            >
            <van-button
              :type="townData.vmode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeViewMode('table', 'townData')"
              >表格模式</van-button
            >
          </template>
          <ChartTown
            :height="240"
            :vmode="townData.vmode"
            :cmode="townData.cmode"
            :title="townData.title"
            :mdata="townData.data"
          ></ChartTown>
        </ModuleCard>
      </div>
       <div class="item-wrap">
        <ModuleCard title="国内部分区域规上工业总产值比较">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'compareDomesticData')"
              :type="chartModeBtnType('gross', 'compareDomesticData')"
              size="mini"
              >总量及增速</van-button
            >
            <van-button
              :type="compareDomesticData.vmode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeViewMode('table', 'compareDomesticData')"
              >表格模式</van-button
            >
          </template>
          <ChartCompareDomestic
            :height="240"
            :vmode="compareDomesticData.vmode"
            :cmode="compareDomesticData.cmode"
            :title="compareDomesticData.title"
            :mdata="compareDomesticData.data"
          ></ChartCompareDomestic>
        </ModuleCard>
      </div>
    </div>
     <div class="item-wrap">
        <ModuleCard title="重点支柱产业工业总产值">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'zhizhuchanyeData')"
              :type="chartModeBtnType('gross', 'zhizhuchanyeData')"
              size="mini"
              >总量及增速</van-button
            >
            <van-button
              :type="chartModeBtnType('proportion', 'zhizhuchanyeData')"
              size="mini"
              @click="handleChangeChartMode('proportion', 'zhizhuchanyeData')"
              >比重</van-button
            >
            <van-button
              :type="zhizhuchanyeData.vmode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeViewMode('table', 'zhizhuchanyeData')"
              >表格模式</van-button
            >
          </template>
          <ChartZdzzcy
            :height="240"
            :vmode="zhizhuchanyeData.vmode"
            :cmode="zhizhuchanyeData.cmode"
            :title="zhizhuchanyeData.title"
            :mdata="zhizhuchanyeData.data"
          ></ChartZdzzcy>
        </ModuleCard>
      </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="近一年工业总产值情况">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('rise', 'timelineMonthData')"
              :type="chartModeBtnType('rise', 'timelineMonthData')"
              size="mini"
              >累计增度</van-button
            >
            <van-button
              :type="timelineMonthData.vmode == 'table' ? 'info' : 'default'"
              size="mini"
              icon="notes-o"
              @click="handleChangeViewMode('table', 'timelineMonthData')"
              >表格模式</van-button
            >
          </template>

          <ChartMonth
            :height="260"
            :vmode="timelineMonthData.vmode"
            :cmode="timelineMonthData.cmode"
            :title="timelineMonthData.title"
            :mdata="timelineMonthData.data"
          ></ChartMonth>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="近五年工业总产值情况">
          <template v-slot:extra>
            <van-button
              size="mini"
              :type="chartModeBtnType('gross', 'timelineYearData')"
              @click="handleChangeChartMode('gross', 'timelineYearData')"
              >总量</van-button
            >
            <van-button
              size="mini"
              :type="chartModeBtnType('rise', 'timelineYearData')"
              @click="handleChangeChartMode('rise', 'timelineYearData')"
              >增速</van-button
            >
            <van-button
              :type="timelineYearData.vmode == 'table' ? 'info' : 'default'"
              size="mini"
              icon="notes-o"
              @click="handleChangeViewMode('table', 'timelineYearData')"
              >表格模式</van-button
            >
          </template>
          <ChartYear
            :height="260"
            :vmode="timelineYearData.vmode"
            :cmode="timelineYearData.cmode"
            :title="timelineYearData.title"
            :mdata="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
      </div>
    </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="现代产业和规上民营企业">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'mingyingData')"
              :type="chartModeBtnType('gross', 'mingyingData')"
              size="mini"
              >总量及增速</van-button
            >
            <van-button
              :type="mingyingData.vmode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeViewMode('table', 'mingyingData')"
              >表格模式</van-button
            >
          </template>
          <ChartMingying
            :height="240"
            :vmode="mingyingData.vmode"
            :cmode="mingyingData.cmode"
            :title="mingyingData.title"
            :mdata="mingyingData.data"
          ></ChartMingying>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="规模以上工业总产值分行业情况">
          <Table
            size="small"
            height="240"
            stripe
            :columns="hangyeTableColumn"
            :data="hangyeTableData"
          />
        </ModuleCard>
      </div>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import { formatStringWrap } from "@/libs/tools.js";
import chartMixin from "@/libs/chart-mixin.js";
import BmkTable from "@/components/common/bmk-table.vue";
import ChartZdzzcy from "./chart-zdzzcy.vue";
import ChartMingying from "./chart-xdmy.vue";
export default {
  mixins: [chartMixin],
  components: { BmkTable, ChartZdzzcy,ChartMingying },
  data() {
    return {
      totalInfo: {
        jw: {
          gross: 0,
          rise: 0,
        },
      },
      hangyeTableColumn: [],
      hangyeTableData: [],
      zhizhuchanyeData: {},
      mingyingData: {},
    };
  },
  methods: {
    handleChangeZhizhuchanye(e, dataName) {
      var chartDataName;
      if (typeof dataName !== "undefined") {
        chartDataName = dataName;
      } else {
        chartDataName = "zhizhuchanyeData";
      }
      this[chartDataName].mode = e;
    },
  },
  mounted() {

    Api.base.get_total({ cate: "规模以上工业总产值" }).then((res) => {
      this.totalInfo = res.data;
    });

    /***各镇指标 */
    Api.jjzb
      .get_town({ params: { cate: "规模以上工业总产值" } })
      .then((res) => {
        this.townData = {
          cmode: "gross",
          vmode: "chart",
          title: {},
          data: {
            tableColumn: res.data.columns,
            tableData: res.data.list,
          },
        };
      });

    /***各区指标对比 */
    Api.jjzb
      .get_county({ params: { cate: "规模以上工业总产值值" } })
      .then((res) => {
        this.compareCountyData = {
          cmode: "gross",
          vmode: "chart",
          title: {},
          data: {
            tableColumn: res.data.columns,
            tableData: res.data.list,
          },
        };
      });

    /*** 国内部分区域指标 */
    Api.jjzb
      .get_domestic({ params: { cate: "规模以上工业总产值" } })
      .then((res) => {
        this.compareDomesticData = {
          cmode: "gross",
          vmode: "chart",
          title: { text: res.data.title },
          data: {
            tableColumn: res.data.columns,
            tableData: res.data.list,
          },
        };
      });

    /***按月 累计增速 */
    Api.timeline
      .get_monthdata({ params: { cate: "规模以上工业总产值" } })
      .then((res) => {
        this.timelineMonthData = {
          cmode: "rise",
          vmode: "chart",
          title: { text: res.data.title },
          data: {
            tableColumn: res.data.columns,
            tableData: res.data.list,
          },
        };
      });

    /*** 年度数据 */
    Api.timeline
      .get_yeardata({ params: { cate: "规模以上工业总产值" } })
      .then((res) => {
        this.timelineYearData = {
          cmode: "gross",
          vmode: "chart",
          title: { text: res.data.title },
          data: {
            tableColumn: res.data.columns,
            tableData: res.data.list,
          },
        };
      });

    /*** 重点支柱产业 */
    Api.base.get_pillar({ params: { cate: "zcz" } }).then((res) => {
      this.zhizhuchanyeData = {
        title: {
          text: res.data.title,
        },
        cmode: "gross",
        vmode: "chart",
        title: { text: res.data.title },
        data: {
          tableColumn: res.data.columns,
          tableData: res.data.list,
        },
      };
    });

    /*** 现代产业及民营企业 */
    Api.base.get_industry_xdmy({ params: { cate: "zcz" } }).then((res) => {
      this.mingyingData = {
        title: {
          text: res.data.title,
        },
        cmode: "gross",
        vmode: "chart",
        title: { text: res.data.title },
        data: {
          tableColumn: res.data.columns,
          tableData: res.data.list,
        },
      };
    });

    // 按行业
    Api.base.get_industry_hy({ params: { cate: "zcz" } }).then((res) => {
      this.hangyeTableColumn = res.data.columns;
      this.hangyeTableData = res.data.list;
    });
  },
};
</script>

<style lang="less" scoped>
.item-wrap {
  margin-bottom: 0.083333rem;
}

#chart-timelineyear {
  height: 1.666667rem;
}
.chart-cate-height {
  height: 1.666667rem;
}

/** */
.m-shujujiance {
  .item {
    padding: 0 0.125rem;
    height: 0.1875rem;
    line-height: 0.1875rem;
    text-align: left;
    cursor: pointer;
  }
  .item:nth-child(2n + 1) {
    background-color: rgba(180, 180, 180, 0.1);
  }
}

.m-base-total {
  display: flex;
  justify-content: space-between;
  .item {
    box-sizing: border-box;
    flex: 0 0 auto;
    padding: 0.0625rem;
    width: 49.25%;
    display: flex;
    align-items: center;
    background: #fff;
    line-height: 1;
    .icon {
      flex: 0 0 auto;
      margin-right: 12px;
    }
  }
  // .item-gross {
  //   color:#0066ff;
  // }
  //   .item-rise {
  //   color:#dd2416;
  // }
  .val {
    margin-top: 8px;
    font-weight: 500;
    font-size: 24px;
    font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
  }
}
.m-content-row .item-wrap {
  flex: 0 0 auto;
  width: 49.25%;
}
</style>
