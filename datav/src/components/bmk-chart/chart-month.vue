<!--
 * @Author: Joy wang
 * @Date: 2021-05-18 13:43:43
 * @LastEditTime: 2021-06-01 02:40:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div :id="chartId" :style="{ height: height + 'px' }"></div>
</template>

<script>
export default {
  props: {
    chartId: {
      type: String,
      default: "chart-leijizengzhang",
    },
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
  methods: {
    name() {},
  },
  watch: {
    chartData(newValue, oldValue) {
      var title = this.title;
      var series = [];
      var legendData = newValue[0].slice(1);
      series = legendData.map((item, index) => {
        if (index === 0) {
          return {
            type: "line",
            areaStyle: {},
          };
        } else {
          return {
            type: "line",
          };
        }
      });
      if (newValue) {
        this.chartInstance.setOption({
          dataset: { source: newValue },
          title,
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
              rotate: -45,
              formatter: function (value) {
                return value.substring(5);
              },
            },
          },
          yAxis: [
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
          series,
        });
      }
    },
  },
  mounted() {
    this.chartInstance = this.$echarts.init(
      document.getElementById(this.chartId),
      this.$config.chartTheme
    );
  },
};
</script>

<style lang="less" scoped>
</style>
