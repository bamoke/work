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
        <BmkTable :columns="tableColumn" :data="this.chartData" />
      </div>
    </div>
  </div>
</template>

<script>
import { formatStringWrap } from "@/libs/tools.js";
export default {
  props: {
    chartId: {
      type: String,
      default: "chart-compare-domestic",
    },
    mode: {
      type: String,
      default: "gross",
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
      activeClass: "show-chart",
      tableColumn: ["区域名称","总量","同比增长"],
      chartInstance: null,
    };
  },

  watch: {
    mode(newValue) {
      if (newValue) {
        if (newValue == "table") {
          this.activeClass = "show-table";
          // this.drawEchart();
        } else {
          this.activeClass = "show-chart";
        }
      }
    },
    chartData(newValue, oldValue) {
      if (newValue) {
        var title = this.title;
        this.chartInstance.setOption({
          dataset: { source: newValue },
          title,
          grid: {
            right: 40,
            bottom: 30,
          },
          tooltip: { trigger: "axis" },
          legend: {
            show: true,
            left: "right",
            top: "top",
            data: [{ name: "总量" }, { name: "同比增长" }],
          },
          xAxis: {
            type: "category",
            axisLabel: {
              // rotate: -45,
              formatter: function (value) {
                return value;
                // return formatStringWrap(value, 4);
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
              name: "总量",
              type: "bar",
            },
            {
              name: "同比增长",
              type: "bar",
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
