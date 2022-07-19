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
import BmkTable from "@/components/common/bmk-table.vue";
import tableChartMixin from "@/libs/table-chart-mixin.js";
export default {
  mixins: [tableChartMixin],
  props: {
    chartId: {
      type: String,
      default: "chart-leijizengzhang",
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
        title: this.title,
        tooltip: { trigger: "axis" },
        grid: {
          top: 20,
        },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            formatter: function (value) {
              return value
              // return value.substring(5);
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

</style>
