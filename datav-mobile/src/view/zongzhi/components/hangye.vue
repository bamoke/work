<!--
 * @Author: Joy wang
 * @Date: 2021-05-31 05:00:41
 * @LastEditTime: 2021-05-31 09:26:34
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <ModuleCard title="地区生产总值按行业情况" style="min-height: 100%">
      <div class="hangye-wrap">
        <div class="item item-long">
          <div id="chart-chanye-gross" style="height: 280px"></div>
        </div>

        <div class="item item-long">
          <div id="chart-chanye-gdp" style="height: 280px"></div>
        </div>
        <div class="item">
          <div id="chart-chanye-proportion" style="height: 280px"></div>
        </div>
      </div>
    </ModuleCard>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import { formatStringWrap } from "@/libs/tools.js";
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
        title: {
          text: "各行业总量及同比",
        },
        grid: {
          top: 40,
          left: 60,
          right: 60,
          bottom: 80,
        },
        tooltip: { trigger: "axis",},
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
              return formatStringWrap(value, 4);
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
            showBackground: true,
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
        title: {
          text: "各行业占总计比重情况",
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
            radius: ["0", "50%"],
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
        title: {
          text: "各行业拉动GDP增长(百分点)",
        },
        grid: {
          top: 40,
          left: 60,
          right: 20,
          bottom: 80,
        },
        tooltip: { trigger: "axis",  },
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
              return formatStringWrap(value, 4);
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
            showBackground: true,
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
      this.chartData = res.data.hy;
      this.nimabi();
    });
  },
};
</script>

<style lang="less" scoped>
.hangye-wrap {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  color: #fff;
  .item {
    margin-bottom: 24px;
    flex: 0 0 auto;
    width: 50%;
    
    .section {
      font-size: 18px;
    }
  }
  .item-long {
    width:100%;
    border-bottom: 1px solid rgba(0,0,0,.1);
  }
}
</style>
