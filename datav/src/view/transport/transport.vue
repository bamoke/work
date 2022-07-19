<!--
 * @Author: Joy wang
 * @Date: 2021-05-19 04:41:13
 * @LastEditTime: 2021-05-31 09:38:11
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
<<<<<<< HEAD
    <div class="row-side">
=======
    <div class="row-side side-left">
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
      <div class="transform-box">
        <ModuleCard title="高栏港近一年港口吞吐量累计增速" class="item-wrap">
          <ChartMonth
            :height="320"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard title="高栏港近五年港口吞吐量情况" class="item-wrap">
          <ChartTransportYear
            :height="320"
            :title="timelineYearData.title"
            :chart-data="timelineYearData.data"
          ></ChartTransportYear>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>
    <div class="row-big">
      <div style="height: 24px"></div>
      <ModuleCard title="高栏港" class="item-wrap">
        <div class="m-jcgk-wrap">
          <div class="item">
            <img
              src="/bi/assets/icon/icon-gangkou.png"
              class="icon"
              alt=""
              srcset=""
            />
            <div class="info">
              <div class="title">
                货物吞吐量<span class="measure">(万吨)</span>
              </div>
              <div class="num">{{ totalInfo.gk.gross }}</div>
              <div class="l-row">同比<Trend :rate="totalInfo.gk.rise" /></div>
            </div>
          </div>
          <div class="item">
            <img
              src="/bi/assets/icon/icon-gangkou-jzx.png"
              class="icon"
              alt=""
              srcset=""
            />
            <div class="info">
              <div class="title">
                集装箱吞吐量<span class="measure">(万TEU)</span>
              </div>
              <div class="num">{{ totalInfo.jzx.gross }}</div>
              <div class="l-row">同比<Trend :rate="totalInfo.jzx.rise" /></div>
            </div>
          </div>
        </div>
      </ModuleCard>
      <ModuleCard title="珠海机场" class="item-wrap">
        <div class="m-jcgk-wrap">
          <div class="item">
            <img src="/bi/assets/icon/icon-jichang-lvke.png" alt="" />
            <div class="info">
              <div class="title">
                旅客吞吐量<span class="measure">(万人次)</span>
              </div>
              <div class="num">{{ totalInfo.jclk.gross }}</div>
              <div class="l-row">同比<Trend :rate="totalInfo.jclk.rise" /></div>
            </div>
          </div>
          <div class="item">
            <img src="/bi/assets/icon/icon-jichang-huoyou.png" alt="" />
            <div class="info">
              <div class="title">
                货邮吞吐量<span class="measure">(万吨)</span>
              </div>
              <div class="num">{{ totalInfo.jchy.gross }}</div>
              <div class="l-row">同比<Trend :rate="totalInfo.jchy.rise" /></div>
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
<<<<<<< HEAD
    <div class="row-side">
=======
    <div class="row-side side-right">
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
      <div class="transform-box">
        <ModuleCard title="珠海机场近一年旅客吞吐量累计增速" class="item-wrap">
          <ChartMonth
            chart-id="chart-leijizengzhangairport"
            :height="320"
            :title="leijizengzhangDataAirport.title"
            :chart-data="leijizengzhangDataAirport.data"
          ></ChartMonth>
        </ModuleCard>

        <ModuleCard title="珠海机场近五年旅客吞吐量" class="item-wrap">
          <ChartTransportYear
            chart-id="chart-timelineyearairport"
            :height="320"
            :title="timelineYearDataAirport.title"
            :chart-data="timelineYearDataAirport.data"
          ></ChartTransportYear>
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
import ChartTransportYear from "./chart-transport-year.vue";
export default {
  mixins: [chartMixin],
  components: {
    ChartTransportYear,
  },
  data() {
    return {
      totalInfo: {
        jclk: {
          gross: 0,
          measure: "",
          rise: "0",
        },
        jchy: {
          gross: 0,
          measure: "",
          rise: "0",
        },
        gk: {
          gross: 0,
          measure: "",
          rise: "0",
        },
        jzx: {
          gross: 0,
          measure: "",
          rise: "0",
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

    Api.base
      .get_data_for_transport({ params: { cate: "transport" } })
      .then((res) => {
        this.totalInfo = res.data;
      });

    Api.base.get_gk_goods().then((res) => {
      var goodsData = this.$formatTableToChart(res.data.list, res.data.columns);
      this.echartInstance.cateportvalue.setOption({
        dataset: { source: goodsData },
        title: {
          text: "货物分类总量及增速",
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
            lineStyle: {
              color: "#59fedd",
            },
            itemStyle: {
              color: "#59fedd",
            },
            // showBackground: true,
          },
        ],
      });

      //比重
      this.echartInstance.cateportproportion.setOption({
        dataset: { source: goodsData },
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
        let harbourChartData = res.data.gk;
        let airportChartData = res.data.jclk;
        this.leijizengzhangData = {
          title: {
            text: harbourChartData.title,
          },
          data: this.$formatTableToChart(
            harbourChartData.list,
            harbourChartData.columns
          ),
        };

        // 机场数据月度数据
        this.leijizengzhangDataAirport = {
          title: {
            text: airportChartData.title,
          },
          data: this.$formatTableToChart(
            airportChartData.list,
            airportChartData.columns
          ),
        };
      });

    /*** 年度数据 */
    Api.timeline
      .get_yeardata_transport({ params: { cate: "transport" } })
      .then((res) => {
        let harbourChartData = res.data.gk;
        let airportChartData = res.data.jclk;
        this.timelineYearData = {
          mode: "gross",
          title: {
            text: "",
          },
          data: this.$formatTableToChart(
            harbourChartData.list,
            harbourChartData.columns
          ),
        };

        // 机场
        this.timelineYearDataAirport = {
          mode: "gross",
          title: {
            text: "",
          },
          data: this.$formatTableToChart(
            airportChartData.list,
            airportChartData.columns
          ),
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
  display: block !important;
}
.row-side {
}

/** */
.m-jcgk-wrap {
  display: flex;
  justify-content: space-between;
  // padding: 24px 12px;
  // background-color: rgba(30, 40, 70, 0.3);
  // margin-bottom: 0.0625rem;
  .item {
    display: flex;
    padding-left: 0.0625rem;
    width: 48%;
    // margin-bottom: 0.125rem;
    // border-bottom: 1px solid rgba(180, 180, 180, 0.2);
    .icon {
      flex: 0 0 auto;
      width: 0.4rem;
      height: 0.4rem;
      font-size: 0.4rem;
      color: #fff;
    }
    .info {
      flex-grow: 1;
      padding-left: 0.0625rem;
      text-align: left;
      color: #fff;
      .title {
        font-weight: bold;
        font-size: 18px;
        .measure {
          font-size: 12px;
          font-weight: normal;
        }
      }
      .num {
        font-size: 0.125rem;
        color: #fff;
        font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
      }
    }
  }
  .item:first-child {
    border-right: 1px solid rgba(180, 180, 180, 0.2);
    margin-right: 0;
  }
}
.cate-port {
  height: 260px;
}
</style>
