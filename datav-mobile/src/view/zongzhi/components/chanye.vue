<!--
 * @Author: Joy wang
 * @Date: 2021-05-31 05:00:41
 * @LastEditTime: 2021-05-31 09:05:17
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="一、二、三产业地区生产总值及同比">
          <div id="chart-chanye-gross" style="height: 220px"></div>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="一、二、三产业拉动GDP增长(百分点)">
          <div id="chart-chanye-gdp" style="height: 220px"></div>
        </ModuleCard>
      </div>
    </div>
    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="一、二、三产业比重">
          <div id="chart-chanye-proportion" style="height: 220px"></div>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="历年一、二、三产业比重">
          <div id="chart-chanye-history" style="height: 220px"></div>
        </ModuleCard>
      </div>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
export default {
  data() {
    return {
      chartData: false,
      echartInstanceGross: null,
      echartInstanceProportion: null,
      echartInstanceGdp: null,
      echartInstanceHistory: null,
      chartHistoryData: [],
    };
  },
  methods: {
    nimabi() {
      this.echartInstanceGross.setOption({
        dataset: { source: this.chartData },
        grid: {
          top: 40,
          left: 60,
          right: 40,
          bottom: 40,
        },

        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            // rotate: -45,
            formatter: function (value) {
              return value;
              // return formatStringWrap(value, 4);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: "{value}",
            },
            splitLine: {
              show: true,
            },
          },
          {
            type: "value",
            axisLabel: {
              formatter: "{value}" + "%",
            },
            splitLine: {
              show: true,
            },
          },
        ],
        series: [
          {
            type: "bar",
          },
          {
            type: "line",
            yAxisIndex: 1,
          },
        ],
      });

      // proportion bizhong

      this.echartInstanceProportion.setOption({
        dataset: { source: this.chartData },

        tooltip: {
          trigger: "item",
        },
        legend: {
          show: false,
          left: "right",
          top: "top",
        },

        series: [
          {
            type: "pie",
            radius: ["0", "65%"],
            center: ["50%", "50%"],
            label: {
              show: true,
              formatter: "{b}\n占比:{d}%",
            },
            labelLine: {
              show: true,
            },
          },
        ],
      });

      //

      this.echartInstanceGdp.setOption({
        dataset: { source: this.chartData },
        grid: {
          top: 40,
          left: 40,
          right: 40,
          bottom: 40,
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },

        xAxis: {
          type: "category",
          axisLabel: {
            // rotate: -45,
            formatter: function (value) {
              return value;
              // return formatStringWrap(value, 4);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: "{value}",
            },
            splitLine: {
              show: true,
            },
          },
        ],
        series: [
          {
            type: "bar",
            // barCategoryGap: "0%",
            // symbol:
            //   "path://M0,10 L10,10 C5.5,10 5.5,5 5,0 C4.5,5 4.5,10 0,10 z",
            // symbolSize: ["80%", "100%"],
            label: {
              show: true,
              position: "top",
            },
            encode: {
              x: 0,
              y: 5,
            },
          },
        ],
      });

      // history
    },
  },

  mounted() {
    const echart = this.$echarts;
    const appTheme = this.$store.state.theme;
    this.echartInstanceGross = echart.init(
      document.getElementById("chart-chanye-gross"),
      appTheme.echartTheme
    );

    this.echartInstanceProportion = echart.init(
      document.getElementById("chart-chanye-proportion"),
      appTheme.echartTheme
    );

    this.echartInstanceGdp = echart.init(
      document.getElementById("chart-chanye-gdp"),
      appTheme.echartTheme
    );

    this.echartInstanceHistory = echart.init(
      document.getElementById("chart-chanye-history"),
      appTheme.echartTheme
    );

    ///
    Api.base.get_gdp_hangye({ cate: "按产业" }).then((res) => {
      this.chartData = res.data.list;
      this.nimabi();
    });

    Api.base.get_gdp_chanye_history().then((res) => {
      this.echartInstanceHistory.setOption({
        dataset: { source: res.data.list },
        grid: {
          top: 40,
          left: 60,
          right: 40,
          bottom: 40,
        },

        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            // rotate: -45,
            formatter: function (value) {
              return value;
              // return formatStringWrap(value, 4);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: "{value}",
            },
            splitLine: {
              show: true,
            },
          },
        ],
        series: [
          {
            type: "line",
          },
          {
            type: "line",
          },
          {
            type: "line",
          },
        ],
      });
    });
  },
};
</script>

<style lang="less" scoped>
.industry-wrap {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  color: #fff;
  .item {
    flex: 0 0 auto;
    margin-bottom: 24px;
    width: 49.75%;
    .section {
      font-size: 18px;
    }
  }
}
</style>
