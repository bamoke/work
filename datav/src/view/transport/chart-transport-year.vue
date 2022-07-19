<!--
 * @Author: Joy wang
 * @Date: 2021-05-18 13:43:43
 * @LastEditTime: 2021-06-02 07:52:48
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div
    class="chart-box"
    :style="{ height: height + 'px', width: '100%' }"
    :id="chartId"
  ></div>
</template>

<script>
import { formatStringWrap } from "@/libs/tools.js";

export default {
  props: {
    cate: {
      type: String,
      default: "",
    },
    vmode: {
      type: String,
      default: "chart",
    },
    cmode: {
      type: String,
      default: "gross",
    },
    height: {
      type: Number,
      default: 200,
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
    chartId: {
      type: String,
      default: "chart-transportyear",
    },
  },
  data() {
    return {
      chartInstance: null,
    };
  },
  methods: {
    drawChart() {
      var options = {
        title: {
          text: "",
        },
        dataset: { source: this.chartData },
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
              return formatStringWrap(value, 4);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: function (value) {
                return value;
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
          },
        ],
      };
      this.chartInstance.setOption(options);
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
