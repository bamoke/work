<!--
 * @Author: Joy wang
 * @Date: 2021-05-18 13:43:43
 * @LastEditTime: 2021-05-31 04:50:31
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div id="chart-compare-domestic" :style="{ height: height + 'px' }"></div>
</template>

<script>
import { formatStringWrap } from "@/libs/tools.js";
export default {
  props: {
    height: {
      type: Number,
      default: 0,
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

  watch: {
    chartData(newValue, oldValue) {
      if (newValue) {
        var title = this.title;
        this.chartInstance.setOption({
          dataset: { source: newValue },
          title,
          grid: {
            top: 60,
            right: 40,
            bottom: 30,
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
              fontSize: "12px",
              // rotate: -45,
              formatter: function (value) {
                return formatStringWrap(value, 3);
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
              lineStyle: {
                color: "#59fedd",
              },
              itemStyle: {
                color: "#59fedd",
              },
            },
            // {
            //   type: "pictorialBar",
            //   barCategoryGap: "0%",
            //   symbol:
            //     "path://M0,10 L10,10 C5.5,10 5.5,5 5,0 C4.5,5 4.5,10 0,10 z",
            //   symbolSize: ["80%", "100%"],
            // },
            // {
            //   type: "line",
            //   yAxisIndex: 1,
            // },
          ],
        });
      }
    },
  },
  mounted() {
    this.chartInstance = this.$echarts.init(
      document.getElementById("chart-compare-domestic"),
      this.$config.chartTheme
    );
  },
};
</script>

<style lang="less" scoped>
</style>
