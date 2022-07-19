<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:45:06
 * @LastEditTime: 2021-06-01 02:59:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="m-base-total item-wrap">
      <div class="item item-gross">
        <van-icon name="points" size="48" class="icon" />
        <div class="info">
          <div class="section">
            {{ totalInfo.title }}({{ totalInfo.measure }})
          </div>
          <div class="val">{{ totalInfo.num }}</div>
        </div>
      </div>
      <div class="item item-rise">
        <van-icon name="chart-trending-o" size="48" class="icon" />
        <div class="info">
          <div class="section">同比增长</div>
          <div class="val">{{ totalInfo.rise }}%</div>
        </div>
      </div>
    </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="各镇规上工业增加值情况">
          <template v-slot:extra>
            <van-button
              @click="handleChangeTown('gross')"
              :type="townData.mode == 'gross' ? 'info' : 'default'"
              size="mini"
              >总量及增长率</van-button
            >
            <van-button
              :type="townData.mode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeTown('table')"
              >表格模式</van-button
            >
          </template>
          <ChartTown
            :height="240"
            :mode="townData.mode"
            :title="townData.title"
            :chart-data="townData.data"
          ></ChartTown>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="各区规上工业增加值比较">
          <template v-slot:extra>
            <van-button
              @click="handleChangeCompareCounty('rise')"
              :type="compareCountyData.mode == 'rise' ? 'info' : 'default'"
              size="mini"
              >总量及增长率</van-button
            >
            <van-button
              :type="compareCountyData.mode == 'gross' ? 'info' : 'default'"
              size="mini"
              @click="handleChangeCompareCounty('gross')"
              >占全市比重</van-button
            >
            <van-button
              :type="compareCountyData.mode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeCompareCounty('table')"
              >表格模式</van-button
            >
          </template>
          <ChartCompareCounty
            :height="240"
            :mode="compareCountyData.mode"
            :title="compareCountyData.title"
            :chart-data="compareCountyData.data"
          ></ChartCompareCounty>
        </ModuleCard>
      </div>
    </div>
    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="重点支柱产业工业增加值" style="margin-bottom: 12px">
          <template v-slot:extra>
            <van-button
              @click="handleChangeZhizhuchanye('gross')"
              :type="zhizhuchanyeData.mode == 'gross' ? 'info' : 'default'"
              size="mini"
              >总量及增长率</van-button
            >
            <van-button
              :type="zhizhuchanyeData.mode == 'proportion' ? 'info' : 'default'"
              size="mini"
              @click="handleChangeZhizhuchanye('proportion')"
              >比重</van-button
            >
            <van-button
              :type="zhizhuchanyeData.mode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeZhizhuchanye('table')"
              >表格模式</van-button
            >
          </template>
          <ChartZdzzcy
            :height="240"
            :mode="zhizhuchanyeData.mode"
            :title="zhizhuchanyeData.title"
            :chart-data="zhizhuchanyeData.data"
          ></ChartZdzzcy>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="国内部分区域规上工业增加值比较">
          <template v-slot:extra>
            <van-button
              @click="handleChangeCompareDomestic('gross')"
              :type="compareDomesticData.mode == 'gross' ? 'info' : 'default'"
              size="mini"
              >总量及增长率</van-button
            >
            <van-button
              :type="compareDomesticData.mode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeCompareDomestic('table')"
              >表格模式</van-button
            >
          </template>
          <ChartCompareDomestic
            :height="240"
            :mode="compareDomesticData.mode"
            :title="compareDomesticData.title"
            :chart-data="compareDomesticData.data"
          ></ChartCompareDomestic>
        </ModuleCard>
      </div>
    </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="近一年工业增加值情况">
          <template v-slot:extra>
            <van-button
              @click="handleChangeTimelineMonth('gross')"
              :type="timelineMonthData.mode == 'gross' ? 'info' : 'default'"
              size="mini"
              >总量</van-button
            >
            <van-button
              :type="timelineMonthData.mode == 'rise' ? 'info' : 'default'"
              size="mini"
              @click="handleChangeTimelineMonth('rise')"
              >累计增长速度</van-button
            >
          </template>

          <ChartMonth
            :title="timelineMonthData.title"
            :chart-data="timelineMonthData.data"
            :height="200"
            :mode="timelineMonthData.mode"
          ></ChartMonth>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="近五年工业增加值情况">
          <template v-slot:extra>
            <van-button
              type="info"
              size="mini"
              @click="handleChangeYearMode('gross')"
              >总量</van-button
            >
            <van-button size="mini" @click="handleChangeYearMode('rise')"
              >增长率</van-button
            >
          </template>
          <ChartYear
            :height="200"
            :mode="timelineYearData.mode"
            :title="timelineYearData.title"
            :chart-data="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
      </div>
    </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="现代产业和规上民营企业">
          <div id="chart-minying" style="height: 220px"></div>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="规模以上分行业情况">
          <BmkTable
            :columns="tableColumn"
            :data="tableData"
            style="height: 220px; overflow-y: auto"
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
export default {
  mixins: [chartMixin],
  components: { BmkTable, ChartZdzzcy },
  data() {
    return {
      totalInfo: {
        title: "规模以上工业增加值",
        num: 114.49,
        measure: "亿元",
        rise: 27.8,
      },
      tableColumn: [],
      tableData: [],
      zhizhuchanyeData:{}
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
    var chartName = ["minying"];
    this.chartInit({ chartName });

    /***各镇指标 */
    Api.jjzb.get_town().then((res) => {
      this.townData = {
        mode: "gross",
        title: {},
        data: res.data,
      };
    });

    /***指标对比 */
    Api.jjzb.get_county().then((res) => {
      this.compareCountyData = {
        mode: "rise",
        title: {},
        data: res.data,
      };
    });

    /*** 国内部分区域指标 */
    Api.jjzb.get_domestic().then((res) => {
      this.compareDomesticData = {
        title: {
          text: res.title,
        },
        mode: "gross",
        data: res.data,
      };
    });

    /***按月 累计增长率 */
    Api.timeline.get_monthdata().then((res) => {
      this.timelineMonthData = {
        title: {
          text: "",
        },
        mode: "gross",
        data: res.data,
      };
    });

    /*** 年度数据 */
    Api.timeline.get_yeardata().then((res) => {
      this.timelineYearData = {
        title: {
          text: res.title,
        },
        mode: "gross",
        data: res.data,
        origin: res.data,
      };
    });



    /*** 重点支柱产业 */
    Api.base.get_gyzjz_zdzz().then((res) => {
      this.zhizhuchanyeData = {
        title: {
          text: res.title,
        },
        mode: "gross",
        data: res.data,
      };
    });



    /*** 现代产业及民营企业 */
    Api.base.get_gyzb_xdmy({ params: { type: "zjz" } }).then((res) => {
      let minyingOption = {
        legend: {
          show: false,
          left: "center",
          top: "top",
          //   orient: "vertical",
        },
        grid: {
          bottom: 60,
        },
        tooltip: { trigger: "axis" },
        dataset: {
          // 提供一份数据。
          source: res.data,
        },
        xAxis: [
          {
            type: "category",
            axisLabel: {
              inside: false,
              // rotate: -45,
              formatter: function (value) {
                return formatStringWrap(value, 2);
              },
            },
          },
        ],
        yAxis: [
          {
            type: "value",
            axisLabel: {
              inside: false,
              formatter: function (v) {
                return v / 10000 + "亿";
              },
            },
          },
        ],

        series: [
          {
            name: "增加值",
            type: "bar",
            stack: "",
            showBackground: true,
            emphasis: {
              focus: "series",
            },
          },
        ],
      };
      this.echartInstance["minying"].setOption(minyingOption);
    });

    // 按行业
    Api.base.get_gyzb_hy({ params: { type: "zjz" } }).then((res) => {
      this.tableColumn = ["指标名称", "公司数量", "总量", "同比增长"];
      this.tableData = res.data;
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
