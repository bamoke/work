<!--
 * @Author: Joy wang
 * @Date: 2021-05-18 13:43:43
 * @LastEditTime: 2021-06-02 07:52:48
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div
    class="module-slider-wrap"
    :style="{ height: height + 'px', width: '100%' }"
  >
    <div :class="[activeClass, 'module-slider-content']">
      <div class="chart-box" :id="chartId"></div>
      <div class="table-box">
        <Table
          size="small"
          :height="height"
          stripe
          :columns="tableColumn"
          :data="tableData"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { formatStringWrap } from "@/libs/tools.js";
import tableChartMixin from "@/libs/table-chart-mixin.js";

export default {
  mixins: [tableChartMixin],
  props: {
    chartId: {
      type: String,
      default: "chart-mingying",
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
              show: true,
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
            encode: {
              x: 0,
              y: 3,
            },
          },
        ],
      };
      this.chartInstance.setOption(optMode);
    },
  },
};
</script>

<style lang="less" scoped>
</style>
