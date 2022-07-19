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
          @on-row-click="toPillarCom"
        >
          <template slot-scope="{ row }" slot="view">
            <strong><van-icon name="arrow" /></strong>
          </template>
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
    toPillarCom(row,index){
      var cate = row.title
      this.$router.push({name:'gongye_zdzzcy',query:{cate}})
    },
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
                return formatStringWrap(value, 2);
              },
            },
          },
          yAxis: [
            {
              type: "value",
              name: "",
              axisLabel: {
                formatter: function (value) {
                  return value ;
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
              showBackground: true,
              encode: {
                x: 0,
                y: 2,
              },
            },
            {
              type: "line",
              name: this.chartData[0][3],
              yAxisIndex: 1,
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
};
</script>

<style lang="less" scoped>
</style>
