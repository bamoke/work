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
        >

        </Table>
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
    cate: {
      type: String,
      default: "工业增加值",
    },
    chartId: {
      type: String,
      default: "chart-zdzzcy",
    },
  },
  data() {
    return {
      chartInstance: null,
    };
  },
  methods: {
    toInvestCom(row,index){
      var cate = row.title.slice(0,-2)
      console.log(cate)
      this.$router.push({name:'investment_fixed_com',query:{cate}})
    },
    drawChart() {
      var optMode = {
        gross: {
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
                  return value
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
            },
          ],
        },
      };
      this.chartInstance.setOption(optMode[this.cmode]);
    },
  },
};
</script>

<style lang="less" scoped>
</style>
