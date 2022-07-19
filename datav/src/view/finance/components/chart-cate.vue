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
    chartId: {
      type: String,
      default: "chart-finace-cate",
    },
    height: {
      type: Number,
      default: 240,
    },

    chartData: {
      type: Array.type,
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
    drawChart() {
      var optMode = {
        title: this.title,
        dataset: [
          { source: this.chartData },
          {
            transform: {
              type: "sort",
              // 按分数排序
              config: { dimension: 1, order: "desc" },
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
              show: true,
            },
          },
        ],
        series: [
          {
            type: "bar",
            datasetIndex: 1,
            name: this.chartData[0][1],
            showBackground: true,
            encode: {
              x: 0,
              y: 1,
            },
          },
          {
            type: "line",
            datasetIndex: 1,
            name: this.chartData[0][2],
            yAxisIndex: 1,
            lineStyle: {
              color: "#59fedd",
            },
            itemStyle: {
              color: "#59fedd",
            },
            encode: {
              x: 0,
              y: 2,
            },
          },
        ],
      };
      this.chartInstance.setOption(optMode);
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
