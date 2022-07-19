<!--
 * @Author: Joy wang
 * @Date: 2021-06-01 02:42:01
 * @LastEditTime: 2021-06-01 05:19:29
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="wrap">
    <div id="chart-expend"></div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import { formatStringWrap } from "@/libs/tools.js";
export default {
  data() {
    return {
      key: "",
    };
  },
  mounted() {
    let echartInstance = this.$echarts.init(
      document.getElementById("chart-expend"),
      this.$config.chartTheme
    );
    Api.base.get_ggys().then((res) => {
      echartInstance.setOption({
        dataset: { source: res.expend.data },
        title: {
          text: "",
          subtext: "",
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "right",
          //   top: "bottom",
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
            name:"总量",
            showBackground: true,
          },
          {
            type: "line",
            name:"同比增长",
            yAxisIndex: 1,
            // showBackground: true,
          },
        ],
      });
    });
  },
};
</script>

<style lang="less" scoped>
.wrap {
  width: 900px;
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
#chart-expend {
    width: 100%;
    height: 320px;
}
</style>