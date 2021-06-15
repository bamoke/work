<!--
 * @Author: Joy wang
 * @Date: 2021-06-02 05:45:35
 * @LastEditTime: 2021-06-02 06:11:52
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="wrap">
    <div class="item">
      <div class="section">工业增加值</div>
      <div id="chart-child-zjz" class="chart-box"></div>
    </div>
    <div class="item">
      <div class="section">工业总产值</div>
      <div id="chart-child-zcz" class="chart-box"></div>
    </div>
  </div>
</template>

<script>
import { formatStringWrap } from "@/libs/tools.js";
export default {
  mounted() {
    let zjzChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zjz"),
      this.$config.chartTheme
    );

    let zczChartInstance = this.$echarts.init(
      document.getElementById("chart-child-zcz"),
      this.$config.chartTheme
    );

    const data = [
      ["product", "金湾区", "金湾直属", "开发区"],
      ["先进制造业", 2828991, 992345, 1836646],
      ["装备制造业", 1187043, 745449, 441595],
      ["先进装备制造业", 627222, 301770, 325452],
      ["高技术", 783252, 720789, 62463],
      ["新材料", 974337, 327043, 647294],
      ["规上民营工业企业", 1764384, 1033107, 731277],
    ];

    let options = {
      legend: {
        left: "center",
        top: "top",
        //   orient: "vertical",
      },
      tooltip: {},
      dataset: {
        // 提供一份数据。
        source: data,
      },
      xAxis: [
        {
          type: "category",
          axisLabel: {
            inside: false,
            // rotate: -45,
            formatter:function(value){
               return formatStringWrap(value,4)
            }
          },
        },
      ],
      yAxis: [
        {
          type: "value",
          axisLabel: {
            inside: false,
            formatter: function (v) {
              return v / 10000 + "亿";
            },
          },
        },
      ],

      series: [
        {
          name: "金湾区",
          type: "bar",
          stack: "",
          emphasis: {
            focus: "series",
          },
        },
        {
          name: "金湾直属",
          type: "bar",
          stack: "",
          emphasis: {
            focus: "series",
          },
        },
        {
          name: "开发区",
          type: "bar",
          stack: "",
          emphasis: {
            focus: "series",
          },
        },
      ],
    };
    zjzChartInstance.setOption(options);
    zczChartInstance.setOption(options);
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
    width: 45%;
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