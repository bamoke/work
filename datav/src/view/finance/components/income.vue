<!--
 * @Author: Joy wang
 * @Date: 2021-06-01 02:42:01
 * @LastEditTime: 2021-06-01 06:15:34
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="wrap">
    <div class="item">
      <div class="section">一般公共预算收入占比情况</div>
      <div id="chart-proportion" class="chart-box"></div>
    </div>
    <div class="item">
      <div class="section">税收收入情况</div>
      <div id="chart-income" class="chart-box"></div>
    </div>
    <div class="item">
      <div class="section">各区税收收入比较</div>
      <ChartCompareCounty
        :height="320"
        :title="compareCountyData.title"
        :chart-data="compareCountyData.data"
      ></ChartCompareCounty>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import { ChartCompareCounty } from "@/components/bmk-chart";
export default {
  components: {
    ChartCompareCounty,
  },
  data() {
    return {
      key: "",
      compareCountyData: {},
    };
  },
  mounted() {
    let taxChartInstance = this.$echarts.init(
      document.getElementById("chart-income"),
      this.$config.chartTheme
    );

    let proportionChartInstance = this.$echarts.init(
      document.getElementById("chart-proportion"),
      this.$config.chartTheme
    );

    Api.base.get_ggys().then((res) => {
      taxChartInstance.setOption({
        dataset: { source: res.income.data },
        title: {
          text: "",
          subtext: "",
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "center",
          //   top: "bottom",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            // rotate: -45,
            formatter: function (value) {
              return value;
            },
          },
        },
        yAxis: [
          {
            type: "value",

            axisLabel: {
              formatter: function (value) {
                return value;
              },
            },
            splitLine: {
              show: false,
            },
          },
          {
            type: "value",

            axisLabel: {
              formatter: function (value) {
                return value + "%";
              },
            },
            splitLine: {
              show: true,
            },
          },
        ],
        series: [
          {
            type: "bar",
            name: "总量",
            showBackground: true,
          },
          {
            type: "line",
            name: "同比增长",
            yAxisIndex: 1,
            // showBackground: true,
          },
        ],
      });

      //
      proportionChartInstance.setOption({
        dataset: { source: res.income.child },
        legend: {
          left: "center",
          top: "top",
          //   orient: "vertical",
        },
        tooltip: {
          trigger: "item",
        },
        series: [
          {
            type: "pie",
            radius: ["35%", "50%"],
            center: ["50%", "60%"],
            label: {
              show: true,
              formatter: "{b}:{@[1]}亿\n占比:{d}%",
            },
            labelLine: {
              show: true,
            },
          },
        ],
      });
    });

    // 税收收入对比
    Api.jjzb.get_county().then((res) => {
      this.compareCountyData = {
        mode: "gross",
        title: { text: "各区税收收入比较" },
        data: res.data,
      };
    });
  },
};
</script>

<style lang="less" scoped>
.wrap {
  width: 1200px;
  display: flex;
  justify-content: space-between;
  color: #fff;
  .item {
    margin-bottom: 24px;
    width: 30%;
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