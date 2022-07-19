<!--
 * @Author: Joy wang
 * @Date: 2021-05-18 13:43:43
 * @LastEditTime: 2021-06-01 02:40:00
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
        <BmkTable :columns="tableColumn" :data="this.tableData" />
      </div>
    </div>
  </div>
</template>

<script>
import BmkTable from "@/components/common/bmk-table.vue";
export default {
  components: {
    BmkTable,
  },
  props: {
    chartId: {
      type: String,
      default: "chart-leijizengzhang",
    },
    mode: {
      type: String,
      default: "rise",
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
      tableColumn:["时间","总量(亿元)","同比(%)"],
      tableData: [],
      activeClass: "show-gross",
    };
  },
  methods: {
    drawEchart() {
      this.chartInstance.setOption({
        dataset: { source: this.chartData },
        title: this.title,
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
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
        series: [
          {
            type: "line",
            areaStyle: {},
            label: {
              show: true,
              // position: "top",
              // distance: 10,
              fontWeight: "100",
            },
            encode: {
              x: 0,
              y: 2,
              tooltip: [2],
            },
          },
        ],
      });
    },
  },
  watch: {
    mode(newValue) {
      if (newValue) {
        if (newValue == "table") {
          this.activeClass = "show-table";
        } else {
          this.activeClass = "show-chart";
        }
      }
    },
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
        this.drawEchart();
        // table data
        this.tableData = newValue.map((item, index) => {
          return {
            date: item[0],
            jwq_gross: item[1],
            jwq_rise: item[2],
            // jwzs_gross: item[3],
            // jwzs_rise: item[4],
            // kfq_gross: item[5],
            // kfq_rise: item[6],
          };
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
.m-timeline-month {
  overflow: hidden;
}
.timeline-slider-wrap {
  display: flex;
  transition: all 0.3s;
  width: 200%;
  height: 100%;
}
.gross-box {
  flex: 0 0 auto;
  width: 50%;
  height: 100%;
  overflow-y: auto;
}
.rise-box {
  flex: 0 0 auto;
  width: 50%;
  height: 100%;
}
.show-gross {
  transform: translateX(0);
}
.show-rise {
  transform: translateX(-50%);
}
</style>
