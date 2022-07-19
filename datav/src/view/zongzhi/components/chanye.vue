<!--
 * @Author: Joy wang
 * @Date: 2021-05-31 05:00:41
 * @LastEditTime: 2021-05-31 09:05:17
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
    <div class="wrap">
      <div class="item">
        <div class="section">总量及增长率</div>
        <div id="chart-chanye-gross" style="height: 280px"></div>
      </div>
      <div class="item">
        <div class="section">占总计比重</div>
        <div id="chart-chanye-proportion" style="height: 280px"></div>
      </div>
      <div class="item">
        <div class="section">拉动GDP增长点</div>
        <div id="chart-chanye-gdp" style="height: 280px"></div>
      </div>
    </div>
</template>

<script>
import * as Api from "@/api/index";
export default {
  data() {
    return {
      chartData: false,
      echartInstanceGross: null,
      echartInstanceProportion: null,
      echartInstanceGdp: null,
    };
  },
  methods: {
    nimabi() {
      var newValue = this.chartData;
      this.echartInstanceGross.setOption({
        dataset: { source: newValue.data },
        grid: {
          top: 60,
          left: 60,
          right: 60,
          bottom: 20,
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            fontSize: "12px",
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
            type: "pictorialBar",
            barCategoryGap: "0%",
            symbol:
              "path://M0,10 L10,10 C5.5,10 5.5,5 5,0 C4.5,5 4.5,10 0,10 z",
            symbolSize: ["80%", "100%"],
          },
          {
            type: "line",
            yAxisIndex: 1,
          },
        ],
      });

      // proportion bizhong

      this.echartInstanceProportion.setOption({
        dataset: { source: newValue.data },

        tooltip: {
          trigger: "item",
        },
        legend: {
          show: false,
          left: "right",
          top: "top",
        },

        series: [
          {
            type: "pie",
            radius: ["0", "65%"],
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
      });

      //

      this.echartInstanceGdp.setOption({
        dataset: { source: newValue.data },
        grid: {
          top: 20,
          left: 60,
          right: 60,
          bottom: 20,
        },
        tooltip: { trigger: "axis", formatter: "增长百分点:{d}%" },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            fontSize: "12px",
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
        ],
        series: [
          {
            type: "pictorialBar",
            barCategoryGap: "0%",
            symbol:
              "path://M0,10 L10,10 C5.5,10 5.5,5 5,0 C4.5,5 4.5,10 0,10 z",
            symbolSize: ["80%", "100%"],
            label: {
              show: true,
            },
            encode: {
              x: 0,
              y: 5,
            },
          },
        ],
      });
    },
  },

  mounted() {
    const echart = this.$echarts;
    this.echartInstanceGross = echart.init(
      document.getElementById("chart-chanye-gross"),
      this.$config.chartTheme
    );

    this.echartInstanceProportion = echart.init(
      document.getElementById("chart-chanye-proportion"),
      this.$config.chartTheme
    );

    this.echartInstanceGdp = echart.init(
      document.getElementById("chart-chanye-gdp"),
      this.$config.chartTheme
    );

    ///
    Api.base.get_sczz().then((res) => {
      this.chartData = res.data.cy;
      this.nimabi()
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
    width: 30%;
    .section {
      font-size: 18px;
    }
  }
}
</style>
