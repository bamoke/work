<!--
 * @Author: Joy wang
 * @Date: 2021-05-19 04:41:13
 * @LastEditTime: 2021-05-31 09:38:11
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="row-side">
      <div class="transform-box">
        <ModuleCard title="高栏港吞吐量累计增长速度" class="item-wrap">
          <ChartMonth
            :height="300"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard title="高栏港近五年吞吐量及增长率" class="item-wrap">
          <ChartYear
            :is-open="true"
            :height="500"
            :title="timelineYearData.title"
            :chart-data="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>
    <div class="row-big">
      <div class="banner-box"></div>
      <ModuleCard title="" class="item-wrap">
        <div class="m-jcgk-wrap">
          <div class="item">
            <Icon type="md-plane" class="icon" />
            <div class="info">
              <div class="unit">
                <div class="num">189.17</div>
                <div class="">旅客吞吐量(万人次)</div>
                <div class="l-row">同比<Trend :rate="50.7" /></div>
              </div>
              <div class="unit">
                <div class="num">0.99</div>
                <div class="">货邮吞吐量(万吨)</div>
                <div class="l-row">同比<Trend :rate="33.6" /></div>
              </div>
            </div>
          </div>
          <div class="item">
            <Icon type="md-boat" class="icon" />
            <div class="info">
              <div class="unit">
                <div class="num">2823</div>
                <div class="">货物吞吐量(万吨)</div>
                <div class="l-row">同比<Trend :rate="12.7" /></div>
              </div>
              <div class="unit">
                <div class="num">35</div>
                <div class="">集装箱吞吐量(万TEU)</div>
                <div class="l-row">同比<Trend :rate="9.8" /></div>
              </div>
            </div>
          </div>
        </div>
      </ModuleCard>
      <ModuleCard title="高栏港港口吞吐量分类情况" class="item-wrap">
        <div class="l-row l-row-bt">
          <div
            id="chart-cateportvalue"
            style="width: 49.25%"
            class="cate-port"
          ></div>
          <div
            id="chart-cateportproportion"
            style="width: 49.25%"
            class="cate-port"
          ></div>
        </div>
      </ModuleCard>
    </div>
    <div class="row-side">
      <div class="transform-box">
        <ModuleCard title="珠海机场吞吐量累计增长速度" class="item-wrap">
          <ChartMonth
            chart-id="chart-leijizengzhangairport"
            :height="300"
            :title="leijizengzhangDataAirport.title"
            :chart-data="leijizengzhangDataAirport.data"
          ></ChartMonth>
        </ModuleCard>

        <ModuleCard title="珠海机场五年吞吐量及增长率" class="item-wrap">
          <ChartYear
            chart-id="chart-timelineyearairport"
            :is-open="true"
            :height="500"
            :title="timelineYearDataAirport.title"
            :chart-data="timelineYearDataAirport.data"
          ></ChartYear>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import { formatStringWrap } from "@/libs/tools.js";
import chartMixin from "@/libs/chart-mixin.js";
export default {
  mixins: [chartMixin],
  data() {
    return {
      totalInfo: {
        all: {
          num: 12.19,
          measure: "亿元",
          rise: 25.4,
        },
        zhishu: {
          num: 9.9,
          measure: "亿元",
          rise: 33.6,
        },
        kaifaqu: {
          num: 2.29,
          measure: "亿元",
          rise: -0.8,
        },
      },
      leijizengzhangDataAirport: {},
      timelineYearDataAirport: {},
    };
  },
  methods: {
    name() {},
  },
  mounted() {
    var chartName = ["cateportvalue", "cateportproportion"];
    this.chartInit({ chartName });

    Api.base.get_gk_glg().then((res) => {
      this.echartInstance.cateportvalue.setOption({
        dataset: { source: res.data },
        title: {
          text: "货物分类总量及增长率",
        },
        legend: {
          show: true,
          left: "right",
          top: "top",
          //   orient: "vertical",
        },
        grid: {
          top: 60,
          right: 40,
          bottom: 30,
        },

        tooltip: { trigger: "axis" },
        xAxis: {
          type: "category",
          axisLabel: {
            // rotate: -45,
            formatter: function (value) {
              return formatStringWrap(value, 2);
            },
          },
        },
        yAxis: [
          {
            name: "(万吨)",
            type: "value",
            axisLabel: {
              formatter: function (value) {
                return value;
              },
            },
            splitLine: {
              show: false,
            },
          },
          {
            type: "value",

            axisLabel: {
              formatter: function (value) {
                return value + "%";
              },
            },
            splitLine: {
              show: true,
            },
          },
        ],
        series: [
          {
            type: "bar",
            showBackground: true,
          },
          {
            type: "line",
            yAxisIndex: 1,
            // showBackground: true,
          },
        ],
      });

      //比重
      this.echartInstance.cateportproportion.setOption({
        dataset: { source: res.data },
        title: {
          text: "货物分类比重",
        },
        legend: {
          show: false,
          left: "right",
          top: "top",
          //   orient: "vertical",
        },
        tooltip: {
          trigger: "item",
        },
        series: [
          {
            type: "pie",
            radius: ["40%", "60%"],
            center: ["50%", "45%"],
            label: {
              show: true,
              formatter: "{b}\n\n占比:{d}%",
            },
            labelLine: {
              show: true,
            },
          },
        ],
      });
    });

    /***按月 累计增长率 */
    Api.timeline
      .get_monthdata({ params: { cate: "transport" } })
      .then((res) => {
        let harbourChartData = res.harbour;
        let airportChartData = res.airport;
        this.leijizengzhangData = {
          title: {
            text: harbourChartData.title,
          },
          data: harbourChartData.data,
        };

        // 机场数据月度数据
        this.leijizengzhangDataAirport = {
          title: {
            text: airportChartData.title,
          },
          data: airportChartData.data,
        };
      });

    /*** 年度数据 */
    Api.timeline.get_yeardata({ params: { cate: "transport" } }).then((res) => {
      let harbourChartData = res.harbour;
      let airportChartData = res.airport;
      this.timelineYearData = {
        mode: "gross",
        title: {
          text: harbourChartData.title,
        },
        data: harbourChartData.data,
      };

      // 机场
      this.timelineYearDataAirport = {
        mode: "gross",
        title: {
          text: airportChartData.title,
        },
        data: airportChartData.data,
      };
    });
  },
};
</script>

<style lang="less" scoped>
.content-wrap {
  background-image: none;
}
.banner-box {
  height: 400px;
}
.row-big {
}
.row-side {
}

/** */
.m-jcgk-wrap {
  display: flex;
  justify-content: space-between;
  padding-top: 0.0625rem;
  .item {
    display: flex;
    padding-bottom: 0.125rem;
    // margin-bottom: 0.125rem;
    width: 45%;
    // border-bottom: 1px solid rgba(180, 180, 180, 0.2);
    .icon {
      flex: 0 0 auto;
      width: 0.4rem;
      height: 0.4rem;
      font-size: 0.4rem;
      color: #fff;
    }
    .info {
      display: flex;
      justify-content: space-between;
      flex-grow: 1;
      padding-left: 0.0625rem;
      text-align: left;
      color: #fff;
      .unit {
        width: 45%;
        text-align: left;
        .num {
          font-size: 0.125rem;
          color: #fff;
          font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
        }
      }
    }
  }
  .item:first-child {
    border-right: 1px solid rgba(180, 180, 180, 0.2);
    margin-right: 0;
  }
}
.cate-port {
  height: 300px;
}
</style>
