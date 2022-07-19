<!--
 * @Author: Joy wang
 * @Date: 2021-05-18 13:43:43
 * @LastEditTime: 2021-06-02 07:52:48
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div :id="chartId" :style="{ height: height + 'px' }"></div>
</template>

<script>
var optMode = {
  gross: {
    title: {
      text: "",
    },
    legend: {
      left: "right",
      top: "top",
      //   orient: "vertical",
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
  rise: {
    title: {
      text: "同比增长值",
    },
    legend: {
      // left: "center",
      // top: "top",
      //   orient: "vertical",
    },
    tooltip: {
      trigger: "item",
    },
    xAxis: {
      type: "value",
      axisLabel: {
        formatter: "{value}%",
      },
    },
    yAxis: [
      {
        type: "category",
        axisLabel: {
          formatter: function (value) {
            return value.substring(0, 2);
          },
        },
      },
    ],
    series: [
      {
        type: "bar",
        barWidth: 12,
        showBackground: true,
        // roseType: 'area',
        label: {
          show: true,
          formatter: "{@[2]}%",
        },
        encode: {
          x: 2, // 表示维度 2 映射到 x 轴。
          y: 0,
        },
      },
    ],
  },
};

export default {
  props: {
    chartId: {
      type: String,
      default: "chart-compare-county",
    },
    height: {
      type: Number,
      default: 0,
    },
    isOpen: {
      type: Boolean,
      default: false,
    },
    mode: {
      type: String,
      default: "gross",
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
    reDraw() {
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
        option = optMode[this.mode];
        option.dataset = {
          source: this.chartData,
        };
      }
      this.chartInstance.clear();
      this.chartInstance.setOption(option);
    },
  },
  watch: {
    mode(newValue, oldValue) {
      if (newValue) {
        this.reDraw();
      }
    },
    chartData(newValue, oldValue) {
      if (newValue) {
        this.reDraw();
      }
    },
  },
  mounted() {
    this.chartInstance = this.$echarts.init(
      document.getElementById(this.chartId),this.$config.chartTheme
    );
  },
};
</script>

<style lang="less" scoped>
</style>
