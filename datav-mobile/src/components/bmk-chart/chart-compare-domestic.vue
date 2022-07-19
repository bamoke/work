<!--
 * @Author: Joy wang
 * @Date: 2021-05-18 13:43:43
 * @LastEditTime: 2021-05-31 04:50:31
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
      default: "chart-compare-domestic",
    },
  },
  data() {
    return {
      chartInstance: null,
    };
  },
  methods: {
    drawChart() {
      this.chartInstance.setOption({
          dataset: { source: this.chartData },
          title:this.title,
          grid: {
            right: 40,
            bottom: 30,
          },
          tooltip: { trigger: "axis" },
          legend: {
            show: true,
            left: "right",
            top: "top",
            // data: [{ name: "总量" }, { name: "同比增长" }],
          },
          xAxis: {
            type: "category",
            axisLabel: {
              // rotate: -45,
              formatter: function (value) {
                return formatStringWrap(value, 4);
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

  watch: {


  },
  mounted() {

  },
};
</script>

<style lang="less" scoped>
</style>
