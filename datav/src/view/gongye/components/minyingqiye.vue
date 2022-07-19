<!--
 * @Author: Joy wang
 * @Date: 2021-06-02 05:45:35
 * @LastEditTime: 2021-06-02 06:11:52
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="wrap">
    <div class="item">
      <div class="section">工业增加值</div>
      <div id="chart-child-zjz" class="chart-box"></div>
    </div>
    <div class="item">
      <div class="section">工业总产值</div>
      <div id="chart-child-zcz" class="chart-box"></div>
    </div>
  </div>
</template>

<script>
import { formatStringWrap } from "@/libs/tools.js";
import * as Api from "@/api/index";
export default {
  mounted() {
    let zjzChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zjz"),
      this.$config.chartTheme
    );

    let zczChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zcz"),
      this.$config.chartTheme
    );

    let options = {
      legend: {
        left: "center",
        top: "top",
        //   orient: "vertical",
      },
      tooltip: { trigger: "axis" },
      dataset: {
        // 提供一份数据。
        source: [],
      },
      xAxis: [
        {
          type: "category",
          axisLabel: {
            inside: false,
            // rotate: -45,
            formatter: function (value) {
              return formatStringWrap(value, 4);
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
              return v;
            },
          },
        },
        {
          type: "value",
          axisLabel: {
            inside: false,
            formatter: function (v) {
              return v + "%";
            },
          },
        },
      ],
      series: [],
    };

    Api.base.get_industry_xdmy({ params: { cate: "all" } }).then((res) => {
      let zjzChartData = this.$formatTableToChart(
        res.data.zjz.list,
        res.data.zjz.columns
      );
      let zczChartData = this.$formatTableToChart(
        res.data.zcz.list,
        res.data.zcz.columns
      );
      let zjzOpt = {
        legend: {
          left: "center",
          top: "top",
          //   orient: "vertical",
        },
        tooltip: { trigger: "axis" },
        dataset: {
          // 提供一份数据。
          source: zjzChartData,
        },
        xAxis: [
          {
            type: "category",
            axisLabel: {
              inside: false,
              // rotate: -45,
              formatter: function (value) {
                return formatStringWrap(value, 4);
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
                return v;
              },
            },
          },
          {
            type: "value",
            axisLabel: {
              inside: false,
              formatter: function (v) {
                return v + "%";
              },
            },
          },
        ],
        series: [
          {
            type: "bar",
            name: zjzChartData[0][2],
            showBackground: true,
            encode: {
              x: 0,
              y: 2,
            },
          },
          {
            type: "line",
            name: zjzChartData[0][3],
            yAxisIndex: 1,
            encode: {
              x: 0,
              y: 3,
            },
          },
        ],
      };

      let zczOpt = {
        legend: {
          left: "center",
          top: "top",
          //   orient: "vertical",
        },
        tooltip: { trigger: "axis" },
        dataset: {
          // 提供一份数据。
          source: zczChartData,
        },
        xAxis: [
          {
            type: "category",
            axisLabel: {
              inside: false,
              // rotate: -45,
              formatter: function (value) {
                return formatStringWrap(value, 4);
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
                return v;
              },
            },
          },
          {
            type: "value",
            axisLabel: {
              inside: false,
              formatter: function (v) {
                return v + "%";
              },
            },
          },
        ],
        series: [
          {
            type: "bar",
            name: zczChartData[0][2],
            showBackground: true,
            encode: {
              x: 0,
              y: 2,
            },
          },
          {
            type: "line",
            name: zczChartData[0][3],
            yAxisIndex: 1,
            encode: {
              x: 0,
              y: 3,
            },
          },
        ],
      };
      zjzChartInstance.setOption(zjzOpt);
      zczChartInstance.setOption(zczOpt);
    });
  },
};
</script>

<style lang="less" scoped>
.wrap {
  width: 1200px;
  display: flex;
  justify-content: space-between;
  color: #fff;
  .item {
    margin-bottom: 24px;
    width: 45%;
    height: 320px;
    .section {
      font-size: 18px;
    }
  }
}
.chart-box {
  height: 320px;
}
</style>