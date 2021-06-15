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
    <div :class="[activeClass,'module-slider-content']">
      <div class="chart-box" :id="chartId"></div>
      <div class="table-box">
        <BmkTable :columns="tableColumn" :data="this.chartData" />
      </div>
    </div>
  </div>
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
  rise: {
    title: {
      text: "",
    },

    tooltip: { trigger: "axis" },
    legend: {
      show: true,
      left: "right",
      top: "top",
      data: [{ name: "总量" }, { name: "同比增长" }],
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
          formatter: "{value}亿",
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
        showBackground: true,
      },
      {
        name: "同比增长",
        type: "bar",
        yAxisIndex: 1,
        showBackground: true,
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
      default: "rise",
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
      tableColumn:["区域","总量","同比增长","占全市比重","增速位次"],
      tableData: [],
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
        if (newValue == "table") {
          this.activeClass = "show-table";
          // this.drawEchart();
        } else {
          this.reDraw();
          this.activeClass = "show-chart";
        }
      }
    },
    chartData(newValue, oldValue) {
      if (newValue) {
        this.reDraw();
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
