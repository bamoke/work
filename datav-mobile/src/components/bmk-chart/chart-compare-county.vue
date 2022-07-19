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
var optMode = {
  proportion: {
    title: {
      text: "",
    },
    dataset: {
      source: [],
    },
    legend: {
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
        radius: ["40%", "60%"],
        center: ["50%", "60%"],
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
    dataset: {
      source: [],
    },
    tooltip: { trigger: "axis" },
    legend: {
      show: true,
      left: "right",
      top: "top",
      // data: [{ name: "总量" }, { name: "同比增长" }],
    },
    grid: {
      right: 40,
      bottom: 30,
    },

    xAxis: {
      type: "category",
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
        showBackground: true,
      },
      {
        type: "line",
        yAxisIndex: 1,
      },
    ],
  },
};
import tableChartMixin from "@/libs/table-chart-mixin.js";
export default {
  mixins: [tableChartMixin],
  props: {
    chartId: {
      type: String,
      default: "chart-compare-county",
    },
  },
  data() {
    return {
      chartInstance: null,
    };
  },
  methods: {
    drawChart() {
      let option, openOpt;

      if (this.isOpen) {
        option = {
          title: {
            text: "",
          },
          dataset: {
            source: this.chartData,
          },
          grid: [{ top: "55%", right: 20 }],
          legend: {
            left: "right",
            top: "top",
            //   orient: "vertical",
          },
          tooltip: {
            trigger: "item",
          },
          xAxis: { type: "value" },
          yAxis: { type: "category" },
          series: [
            {
              type: "pie",
              // roseType: 'area',
              radius: ["0", "35%"],
              center: ["50%", "35%"],
              label: {
                show: true,
                formatter: "{b}\n占比:{d}%",
              },
              labelLine: {
                show: true,
              },
            },
            {
              type: "bar",
              // barWidth: 12,
              showBackground: true,
              // roseType: 'area',
              label: {
                show: true,
                formatter: "{@[2]}%",
              },
              // encode: {
              //   x: 2, // 表示维度 2 映射到 x 轴。
              //   y: 0,
              // },
            },
          ],
        };
      } else {
        
        option = optMode[this.cmode];
        option.dataset.source = this.chartData;
        option.title = this.title
      }
      this.chartInstance.clear();
      this.chartInstance.setOption(option);
    },
  },
  watch: {},
  mounted() {},
};
</script>

<style lang="less" scoped>
</style>
