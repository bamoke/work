<!--
 * @Author: Joy wang
 * @Date: 2021-05-31 05:00:41
 * @LastEditTime: 2021-05-31 09:05:17
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <ModuleCard title="地区生产总值按产业情况" style="min-height: 100%">
      <div class="industry-wrap">
        <div class="item">

          <div id="chart-chanye-gross" style="height: 280px"></div>
        </div>
        <div class="item">

          <div id="chart-chanye-proportion" style="height: 280px"></div>
        </div>
        <div class="item">

          <div id="chart-chanye-gdp" style="height: 280px"></div>
        </div>
      </div>
    </ModuleCard>
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
        title:{
          text:"产业总量及同比"
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
            type: "bar",
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
        title:{
          text:"各产业比重"
        },
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
          top: 60,
          left: 40,
          right: 60,
          bottom: 20,
        },
        tooltip: { trigger: "axis",  },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        title:{
          text:"拉动GDP增长(百分点)"
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
        ],
        series: [
          {
            type: "bar",
            // barCategoryGap: "0%",
            // symbol:
            //   "path://M0,10 L10,10 C5.5,10 5.5,5 5,0 C4.5,5 4.5,10 0,10 z",
            // symbolSize: ["80%", "100%"],
            label: {
              show: true,
              position: "top",

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
    const appTheme = this.$store.state.theme;
    this.echartInstanceGross = echart.init(
      document.getElementById("chart-chanye-gross"),
      appTheme.echartTheme
    );

    this.echartInstanceProportion = echart.init(
      document.getElementById("chart-chanye-proportion"),
      appTheme.echartTheme
    );

    this.echartInstanceGdp = echart.init(
      document.getElementById("chart-chanye-gdp"),
      appTheme.echartTheme
    );

    ///
    Api.base.get_sczz().then((res) => {
      this.chartData = res.data.cy;
      this.nimabi();
    });
  },
};
</script>

<style lang="less" scoped>
.industry-wrap {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  color: #fff;
  .item {
    flex:0 0 auto;
    margin-bottom: 24px;
    width: 49.75%;
    .section {
      font-size: 18px;
    }
  }
}
</style>
