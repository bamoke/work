<!--
 * @Author: Joy wang
 * @Date: 2021-06-02 05:44:49
 * @LastEditTime: 2021-06-02 06:59:23
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="wrap">
    <div class="item">
      <div class="section">工业增加值总量及增速</div>
      <div id="chart-child-zjz-gross" class="chart-box"></div>
    </div>
    <div class="item">
      <div class="section">工业增加值比重情况</div>
      <div id="chart-child-zjz-prop" class="chart-box"></div>
    </div>
    <div class="item">
      <div class="section">工业总产值总量及增速</div>
      <div id="chart-child-zcz-gross" class="chart-box"></div>
    </div>
    <div class="item">
      <div class="section">工业总产值比重情况</div>
      <div id="chart-child-zcz-prop" class="chart-box"></div>
    </div>
  </div>
</template>

<script>
import { formatStringWrap } from "@/libs/tools.js";
import * as Api from "@/api/index";
export default {
  mounted() {
    let zjzgrossChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zjz-gross"),
      this.$config.chartTheme
    );
    let zjzpropChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zjz-prop"),
      this.$config.chartTheme
    );

    let zczgrossChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zcz-gross"),
      this.$config.chartTheme
    );

    let zczpropChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zcz-prop"),
      this.$config.chartTheme
    );

    let options = {
      title: {
        text: "",
      },
      legend: [
        {
          show: true,
          left: "right",
          top: "top",
        },
      ],
      tooltip: { trigger: "axis" },
      dataset: {
        // 提供一份数据。
        source: [],
      },
      xAxis: {
        type: "category",
        axisLabel: {
          inside: false,
          formatter: function (value) {
            return formatStringWrap(value, 2);
          },
        },
      },
      yAxis: [
        {
          axisLabel: {
            formatter: function (value) {
              return value;
            },
          },
          splitLine: {
            show: true,
          },
        },
        {
          type: "value",
          max: 80,
          min: -20,
          axisLabel: {
            formatter: function (value) {
              return value + "%";
            },
          },
        },
      ],
      series: [
        {
          type: "bar",
          name:"总量(万元)",
          encode: {
            x: 0,
            y: 2,
          },
        },
        {
          type: "line",
          name:'增速',
          yAxisIndex: 1,
          encode: {
            x: 0,
            y: 3,
          },
          // itemStyle: {
          //   color: "#ffcf29",
          // },
        },
      ],
    };
    let pieOption = {
      title: {
        text: "",
      },
      dataset: {
        // 提供一份数据。
        source: [],
      },

      tooltip: {
        trigger: "item",
      },
      series: [
        {
          type: "pie",
          // roseType: 'area',
          radius: ["35%", "50%"],
          center: ["50%", "60%"],
          label: {
            show: true,
            formatter: "{@product}\n占比:{d}%",
          },
          labelLine: {
            show: true,
          },
          encode: {
            x: 0,
            y: 1,
          },
        },
      ],
    };

    /*** 重点支柱产业 */
    Api.base.get_pillar({ params: { cate: "all" } }).then((res) => {
      let zjzOpt = Object.assign({}, options);
      let zjzPieOpt = Object.assign({}, pieOption);
      let zjzData = this.$formatTableToChart(
        res.data.zjz.list,
        res.data.zjz.columns
      );
      let zczData = this.$formatTableToChart(
        res.data.zcz.list,
        res.data.zcz.columns
      );
      zjzOpt.dataset.source = zjzData;
      zjzgrossChartInstance.setOption(zjzOpt);
      zjzPieOpt.dataset.source = zjzData;
      zjzpropChartInstance.setOption(zjzPieOpt);

      //////
      let zczOpt = Object.assign({}, options);
      let zczPieOpt = Object.assign({}, pieOption);

      zczOpt.dataset.source = zczData;
      zczgrossChartInstance.setOption(zczOpt);
      zczPieOpt.dataset.source = zczData;
      zczpropChartInstance.setOption(zczPieOpt);
    });
  },
};
</script>

<style lang="less" scoped>
.wrap {
  width: 1600px;
  display: flex;
  justify-content: space-between;
  color: #fff;
  .item {
    margin-bottom: 24px;
    width: 23%;
    height: 320px;
    .section {
      font-size: 18px;
    }
  }
}
.chart-box {
  height: 320px;
}
</style>
