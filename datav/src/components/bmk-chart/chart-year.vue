<!--
 * @Author: Joy wang
 * @Date: 2021-05-18 13:43:43
 * @LastEditTime: 2021-05-31 01:58:06
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div :id="chartId" :style="{ height: height + 'px' }"></div>
</template>

<script>
var optMode = {
  gross: {
    xAxis: { type: "category" },
    yAxis: [
      {
        type: "value",
        axisLabel: {
          formatter: "{value}" + "亿",
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
        encode: {
          x: 0,
          y: 1,
        },
      },
      {
        type: "bar",
        showBackground: true,
        encode: {
          x: 0,
          y: 3,
        },
      },
    ],
  },
  rise: {
    xAxis: { type: "category" },
    yAxis: [
      {
        type: "value",
        axisLabel: {
          formatter: "{value}" + "%",
        },
      },
    ],
    series: [
      {
        type: "line",
        encode: {
          x: 0,
          y: 2,
        },
        markPoint: {
          data: [
            { type: "max", name: "最大值" },
            { type: "min", name: "最小值" },
          ],
        },
        areaStyle: {},
      },
      {
        type: "line",

        markPoint: {
          data: [
            { type: "max", name: "最大值" },
            { type: "min", name: "最小值" },
          ],
        },
        encode: {
          x: 0,
          y: 4,
        },
      },
    ],
  },
};
export default {
  props: {
    chartId: {
      type: String,
      default: "chart-timelineyear",
    },
    height: {
      type: Number,
      default: 0,
    },
    isOpen: {
      type: Boolean,
      default: false,
    },
    mode: {
      type: String,
      default: "gross",
    },
    title: {
      type: Object,
      default: function () {
        return {};
      },
    },

    chartData: {
      type: Array,
      default: function () {
        return [];
      },
    },
  },
  data() {
    return {
      chartInstance: null,
    };
  },
  methods: {
    reDraw() {
      var openOpt,
        modeSeries = optMode[this.mode].series,
        opt = {
          dataset: { source: this.chartData },
          title: this.title,
          tooltip: { trigger: "axis" },
          legend: {
            show: true,
            left: "right",
            top: "top",
          },
        };
      if (this.isOpen) {
        // 展开
        openOpt = {
          grid: [{ bottom: "60%" }, { top: "55%" }],
          xAxis: [
            {
              type: "category",
              gridIndex: 0,
            },
            {
              type: "category",
              gridIndex: 1,
            },
          ],
          yAxis: [
            {
              name: "总额(亿)",
              nameTextStyle: {
                color: "#fff",
              },
              axisLabel: {
                formatter: "{value}",
              },
              splitLine: {
                show: true,
              },
              gridIndex: 0,
            },
            {
              name: "增长率(%)",
              nameTextStyle: {
                color: "#fff",
              },
              splitLine: {
                show: true,
              },
              axisLabel: {
                formatter: "{value}",
              },
              gridIndex: 1,
            },
          ],
          series: [
            {
              name: this.chartData[0][1],
              type: "bar",
              showBackground: true,
              encode: {
                x: 0,
                y: 1,
              },
            },
            {
              name: this.chartData[0][3],
              type: "bar",
              showBackground: true,
              encode: {
                x: 0,
                y: 3,
              },
            },
            {
              name: this.chartData[0][2],
              type: "line",
              xAxisIndex: 1,
              yAxisIndex: 1,
              encode: {
                x: 0,
                y: 2,
              },
              markPoint: {
                data: [
                  { type: "max", name: "最大值" },
                  { type: "min", name: "最小值" },
                ],
              },

              areaStyle: {},
            },
            {
              name: this.chartData[0][4],
              type: "line",
              xAxisIndex: 1,
              yAxisIndex: 1,
              encode: {
                x: 0,
                y: 4,
              },
              markPoint: {
                data: [
                  { type: "max", name: "最大值" },
                  { type: "min", name: "最小值" },
                ],
              },
            },
          ],
        };
        opt = Object.assign(opt, openOpt);
      } else {
        if (this.mode === "gross") {
          modeSeries[0].name = this.chartData[0][1];
          modeSeries[1].name = this.chartData[0][3];
        } else {
          modeSeries[0].name = this.chartData[0][2];
          modeSeries[1].name = this.chartData[0][4];
        }
        opt = Object.assign(opt, {
          xAxis: { type: "category" },
          yAxis: optMode[this.mode].yAxis,
          series: modeSeries,
        });
      }

      this.chartInstance.clear();
      this.chartInstance.setOption(opt);
    },
  },
  watch: {
    mode(newValue, oldValue) {
      if (newValue) {
        this.reDraw();
      }
    },
    chartData(newValue, oldValue) {
      if (newValue) {
        this.reDraw();
      }
    },
  },
  mounted() {
    this.chartInstance = this.$echarts.init(
      document.getElementById(this.chartId)
    );
  },
};
</script>

<style lang="less" scoped>
</style>
