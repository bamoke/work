<!--
 * @Author: Joy wang
 * @Date: 2021-05-18 13:43:43
 * @LastEditTime: 2021-05-31 01:58:06
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
import tableChartMixin from "@/libs/table-chart-mixin.js";
export default {
  mixins: [tableChartMixin],
  props: {
    chartId: {
      type: String,
      default: "chart-timelineyear",
    },
  },
  data() {
    return {
      chartInstance: null,
    };
  },
  methods: {
    drawChart() {
      var openOpt,optMode,opt;
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
        optMode = {
          gross: {
            dataset: { source: this.chartData },
            title: this.title,
            tooltip: { trigger: "axis" },
            legend: {
              show: true,
              left: "right",
              top: "top",
            },
            xAxis: { type: "category" },
            yAxis: [
              {
                type: "value",
                splitLine: {
                  show: true,
                },
              },
            ],
            series: [
              {
                type: "bar",
                name:this.chartData[0][1],
                showBackground: true,
                encode: {
                  x: 0,
                  y: 1,
                },
              },
              {
                type: "bar",
                name:this.chartData[0][3],
                showBackground: true,
                encode: {
                  x: 0,
                  y: 3,
                },
              },
            ],
          },
          rise: {
            dataset: { source: this.chartData },
            title: this.title,
            tooltip: { trigger: "axis" },
            legend: {
              show: true,
              left: "right",
              top: "top",
            },
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
                name:this.chartData[0][2],
                encode: {
                  x: 0,
                  y: 2,
                },
              },
              {
                type: "line",
                name:this.chartData[0][4],

                encode: {
                  x: 0,
                  y: 4,
                },
              },
            ],
          },
        };
        opt = optMode[this.cmode]
      }

      this.chartInstance.clear();
      this.chartInstance.setOption(opt);
    },
  },
};
</script>

<style lang="less" scoped>
</style>
