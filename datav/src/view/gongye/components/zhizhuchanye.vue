<!--
 * @Author: Joy wang
 * @Date: 2021-06-02 05:44:49
 * @LastEditTime: 2021-06-02 06:59:23
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="wrap">
    <div class="item">
      <div class="section">工业增加值及增长率</div>
      <div id="chart-child-zjz-gross" class="chart-box"></div>
    </div>
    <div class="item">
      <div class="section">工业增加值比重情况</div>
      <div id="chart-child-zjz-prop" class="chart-box"></div>
    </div>
    <div class="item">
      <div class="section">工业总产值及增长率</div>
      <div id="chart-child-zcz-gross" class="chart-box"></div>
    </div>
    <div class="item">
      <div class="section">工业总产值比重情况</div>
      <div id="chart-child-zcz-prop" class="chart-box"></div>
    </div>
  </div>
</template>

<script>
import { formatStringWrap } from "@/libs/tools.js";
export default {
  mounted() {
    let zjzgrossChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zjz-gross"),
      this.$config.chartTheme
    );
    let zjzpropChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zjz-prop"),
      this.$config.chartTheme
    );

    let zczgrossChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zcz-gross"),
      this.$config.chartTheme
    );

    let zczpropChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zcz-prop"),
      this.$config.chartTheme
    );
    const zjzData = [
      ["生物医药", 167370, 17.7],
      ["高端打印设备", 22691, 40.5],
      ["高端精细化工", 154617, 19.0],
      ["新能源", 25864, 57.7],
      ["清洁能源", 248184, 23.9],
      ["智能家电", 87608, 40.6],
      ["船舶与海洋装备制造", 43542, 45.1],

      ["钢铁制造", 70111, 42.3],
      ["电力生产", 29889, 34.4],
      ["传统优势", 308754, 31.9],
    ];

    const zczData = [
      ["生物医药", 433386, 18.7],
      ["高端打印设备", 92548, 36.9],
      ["高端精细化工", 1035924, 19.0],
      ["新能源", 129491, 62.3],
      ["清洁能源", 606460, 28.2],
      ["智能家电", 388992, 40.6],
      ["船舶与海洋装备制造", 216328, 42.3],

      ["钢铁制造", 409847, 42.3],
      ["电力生产", 101283, 34.2],
      ["传统优势", 1434033, 34.3],
    ];

    let options = {
      title: {
        text: "",
      },
      legend: [
        {
          show: true,
          left: "right",
          top: "top",
        },
      ],
      tooltip: {},
      dataset: {
        // 提供一份数据。
        source: [],
      },
      xAxis: {
        type: "category",
        axisLabel: {
          inside: false,
          formatter: function (value) {
            return formatStringWrap(value, 2);
          },
        },
      },
      yAxis: [
        {
          axisLabel: {
            formatter: function (value) {
              return value / 10000 + "亿";
            },
          },
          splitLine: {
            show: true,
          },
        },
        {
          type: "value",
          max: 80,
          min: -20,
          axisLabel: {
            formatter: function (value) {
              return value + "%";
            },
          },
        },
      ],
      series: [
        {
          type: "bar",
          // barWidth: 16,
          // itemStyle: {
          //   color: new this.$echarts.graphic.LinearGradient(0, 0, 0, 1, [
          //     { offset: 0, color: "#f57fc5" },
          //     { offset: 0.5, color: "#f1209f" },
          //     { offset: 1, color: "#f0189b" },
          //   ]),
          // },
        },
        {
          type: "line",
          yAxisIndex: 1,
          // itemStyle: {
          //   color: "#ffcf29",
          // },
        },
      ],
    };
    let pieOption = {
      title: {
        text: "",
      },
      dataset: {
        // 提供一份数据。
        source: [],
      },

      tooltip: {
        trigger: "item",
      },
      series: [
        {
          type: "pie",
          // roseType: 'area',
          radius: ["35%", "50%"],
          center: ["50%", "60%"],
          label: {
            show: true,
            formatter: "{b}\n占比:{d}%",
          },
          labelLine: {
            show: true,
          },
        },
      ],
    };
    let zjzOpt = Object.assign({}, options);
    let zjzPieOpt = Object.assign({}, pieOption);

    zjzOpt.dataset.source = zjzData;
    zjzgrossChartInstance.setOption(zjzOpt);
    zjzPieOpt.dataset.source = zjzData;
    zjzpropChartInstance.setOption(zjzPieOpt);

    //////
    let zczOpt = Object.assign({}, options);
    let zczPieOpt = Object.assign({}, pieOption);

    zczOpt.dataset.source = zczData;
    zczgrossChartInstance.setOption(zczOpt);
    zczPieOpt.dataset.source = zczData;
    zczpropChartInstance.setOption(zczPieOpt);
  },
};
</script>

<style lang="less" scoped>
.wrap {
  width: 1600px;
  display: flex;
  justify-content: space-between;
  color: #fff;
  .item {
    margin-bottom: 24px;
    width: 23%;
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
