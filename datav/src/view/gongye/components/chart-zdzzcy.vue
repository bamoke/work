<!--
 * @Author: Joy wang
 * @Date: 2021-05-18 13:43:43
 * @LastEditTime: 2021-06-02 07:52:48
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="chart-box" :id="chartId" :style="{ height: height + 'px' }"></div>
</template>

<script>
import { formatStringWrap } from "@/libs/tools.js";

export default {
  props: {
    cate: {
      type: String,
      default: "工业增加值",
    },
    height: {
      type: Number,
      default: 240,
    },
    chartId: {
      type: String,
      default: "chart-zdzzcy",
    },
    chartData: {
      type: Array.type,
      default: function () {
        return [];
      },
    },
    cmode: {
      type: String,
      default: "gross",
    },
  },
  data() {
    return {
      chartInstance: null,
    };
  },
  methods: {
    drawChart() {
      var optMode = {
        proportion: {
          title: {
            text: "",
          },
          dataset: { source: this.chartData },
          legend: {
            show: false,
            left: "right",
            top: "top",
            // orient: "vertical",
          },
          tooltip: {
            trigger: "item",
          },
          series: [
            {
              type: "pie",
              // roseType: 'area',
              radius: ["35%", "50%"],
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
        },
        gross: {
          title: {
            text: "",
          },
          dataset: [
            { source: this.chartData },
            {
              transform: {
                type: "sort",
                // 按分数排序
                config: { dimension: 2, order: "desc" },
              },
            },
          ],
          tooltip: { trigger: "axis" },
          legend: {
            show: true,
            left: "right",
            top: "top",
          },
          grid: {
            left: 60,
            right: 40,
            bottom: 60,
          },

          xAxis: {
            type: "category",
            axisLabel: {
              formatter: function (value) {
                return formatStringWrap(value, 2);
              },
            },
          },
          yAxis: [
            {
              type: "value",
              name: "百万",
              axisLabel: {
                formatter: function (value) {
                  return value / 100;
                },
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
                show: false,
              },
            },
          ],
          series: [
            {
              type: "bar",
              name: this.chartData[0][2],
              datasetIndex: 1,
              showBackground: true,
              encode: {
                x: 0,
                y: 2,
              },
            },
            {
              type: "line",
              name: this.chartData[0][3],
              datasetIndex: 1,
              yAxisIndex: 1,
              lineStyle: {
                color: "#59fedd",
              },
              itemStyle: {
                color: "#59fedd",
              },
              encode: {
                x: 0,
                y: 3,
              },
            },
          ],
        },
      };
      this.chartInstance.clear();
      this.chartInstance.setOption(optMode[this.cmode]);
    },
  },
  watch: {
    chartData(newValue, oldValue) {
      if (newValue) {
        this.drawChart();
      }
    },
  },
  mounted() {
    const appTheme = this.$store.state.theme;
    this.chartInstance = this.$echarts.init(
      document.getElementById(this.chartId),
      appTheme.echartTheme
    );
  },
};
</script>

<style lang="less" scoped>
</style>
