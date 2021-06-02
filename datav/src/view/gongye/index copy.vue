<!--
 * @Author: Joy wang
 * @Date: 2021-05-06 12:49:38
 * @LastEditTime: 2021-05-10 12:18:01
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="side-wrap">
      <ModuleCard title="重点支柱产业工业总产值" :total-info="zzcyData.total">
        <div id="zzcy" style="width: 100%; height: 360px"></div>
      </ModuleCard>

      <ModuleCard
        title="现代产业和规上民营工业企业总产值"
        :total-info="xdcyData.total"
        style="margin-top: 24px"
      >
        <div id="xdcy" style="width: 100%; height: 306px"></div>
      </ModuleCard>
    </div>

    <div class="big-wrap">
      <div class="img-box">
        <div id="gd-map-container"></div>
        <!-- <img
          src="@/assets/map-bg.png"
          style="width: 100%; height: 100%"
          alt=""
        /> -->
      </div>

      <div style="padding-top: 24px; height: 40%">
        <ModuleCard title="工业增加值" style="height: 100%; display: flex">
          <div class="big-bt-item">
            <div id="gyzcz" style="width: 100%; height: 100%"></div>
          </div>
        </ModuleCard>
      </div>
    </div>

    <div class="side-wrap">
      <ModuleCard title="规模以上工业经济效益">
        <div class="jjxy-wrap">
          <div class="jjxy-item">
            <div class="section">资产负债率</div>
            <div class="content">
              <div class="value"><span class="num">53.5%</span></div>
              <div>同比 1%</div>
            </div>
          </div>
          <div class="jjxy-item">
            <div class="section">营业收入<span class="sub">(万元)</span></div>
            <div class="content">
              <div class="value"><span class="num">4952142</span></div>
              <div>同比 45.4%</div>
            </div>
          </div>
          <div class="jjxy-item">
            <div class="section">利润总额<span class="sub">(万元)</span></div>
            <div class="content">
              <div class="value"><span class="num">506943</span></div>
              <div>同比 89.4%</div>
            </div>
          </div>
        </div>
      </ModuleCard>

      <ModuleCard
        title="GDP能耗及规上工业能源消费情况"
        :total-info="nyxfData.total"
        style="margin-top: 24px"
      >
        <div id="nyxf" style="width: 100%; height: 190px"></div>
      </ModuleCard>
      <ModuleCard
        title="全社会用电量情况"
        :total-info="ydlqkData.total"
        style="margin-top: 24px"
      >
        <div id="ydlqk" style="width: 100%; height: 206px"></div>
      </ModuleCard>
    </div>
  </div>
</template>





<script>
export default {
  components: {},
  data() {
    return {
      zzcyData: {
        total: { num: 484827, measure: "万元", rate: 29.6 },
      },
      xdcyData: {},
      ydlqkData: {
        total: { num: 158962, measure: "万千瓦时", rate: 27.11 },
      },
      nyxfData: {
        total: { num: 99.71, measure: "万吨标准煤", rate: 38.85 },
      },
    };
  },
  mounted() {
    console.log(this.$echarts);
    const chartTextColor = "rgba(255, 255, 255, 1)";
    const splitLinesplitLine = {
      show: true,
      lineStyle: {
        color: "#336699",
        type: "dashed",
      },
    };

    var zzcyChart = this.$echarts.init(document.getElementById("zzcy"));
    var xdcyChart = this.$echarts.init(document.getElementById("xdcy"));
    var ydlqkChart = this.$echarts.init(document.getElementById("ydlqk"));
    var gyzczChart = this.$echarts.init(document.getElementById("gyzcz"));
    var nyxfChart = this.$echarts.init(document.getElementById("nyxf"));
    zzcyChart.setOption({
      title: {
        text: "",
      },
      textStyle: {
        color: chartTextColor,
      },
      xAxis: {
        type: "category",
        data: [
          "生物医药",
          "高端打印设备",
          "高端精细化工",
          "新能源",
          "清洁能源",
          "智能家电",
          "船舶与海洋装备制造",
          "航空产业",
          "钢铁制造",
          "电力生产",
          "传统优势",
        ],
        axisLabel: {
          inside: false,
          rotate: -45,
        },
      },
      yAxis: {
        name: "产值",
        type: "value",
        axisTick: {
          show: false,
        },
        splitLine: splitLinesplitLine,
      },
      series: [
        {
          data: [
            433386,
            92548,
            1035924,
            129491,
            606460,
            388992,
            216328,
            0,
            409847,
            101283,
            1434033,
          ],
          type: "bar",
          itemStyle: {
            color: new this.$echarts.graphic.LinearGradient(0, 0, 0, 1, [
              { offset: 0, color: "#83bff6" },
              { offset: 0.5, color: "#188df0" },
              { offset: 1, color: "#188df0" },
            ]),
          },
        },
      ],
    });

    xdcyChart.setOption({
      legend: {
        data: ["金湾直属", "开发区"],
      },
      textStyle: {
        color: chartTextColor,
      },
      xAxis: [
        {
          type: "category",
          data: [
            "先进制造业",
            "装备制造业",
            "先进装备制造业",
            "高技术",
            "新材料",
            "规上民营工业企业",
          ],
          axisLabel: {
            inside: false,
            rotate: -45,
          },
        },
      ],
      yAxis: [
        {
          type: "value",
          splitLine: splitLinesplitLine,
          axisLabel: {
            inside: false,
          },
        },
      ],
      series: [
        {
          name: "金湾直属",
          type: "bar",
          stack: "",
          emphasis: {
            focus: "series",
          },
          data: [992345, 745449, 301770, 720789, 327043, 1033107],
        },
        {
          name: "开发区",
          type: "bar",
          stack: "",
          emphasis: {
            focus: "series",
          },
          data: [1836646, 441595, 325452, 62463, 647294, 731277],
        },
      ],
    });

    // jjs
    ydlqkChart.setOption({
      textStyle: {
        color: chartTextColor,
      },
      xAxis: {
        type: "value",
        boundaryGap: [0, 0.01],
        splitLine: splitLinesplitLine,
      },
      yAxis: {
        type: "category",
        data: ["工业用电量", "非工业用电量", "规上工业用电量"],
        axisLabel: {
          inside: false,
        },
      },
      series: [
        {
          name: "同期数",
          type: "bar",
          data: [132757, 26205, 128032],
        },
      ],
    });

    //
    gyzczChart.setOption({
      title: {
        text: "规模以上工业增加值",
        subtext: "(亿元)",
        left: "center",
      },
      textStyle: {
        color: chartTextColor,
      },
      tooltip: {
        trigger: "item",
      },
      legend: {
        orient: "horizontal",
        bottom: "bottom",
        textStyle: {
          color: chartTextColor,
        },
      },
      series: [
        {
          name: "规上工业增加值",
          type: "pie",
          radius: "50%",
          data: [
            { value: 30.63, name: "三灶镇" },
            { value: 15.77, name: "红旗镇" },
            { value: 58.57, name: "南水镇" },
            { value: 9.52, name: "平沙镇" },
          ],
          emphasis: {
            itemStyle: {
              shadowBlur: 10,
              shadowOffsetX: 0,
              shadowColor: "rgba(0, 0, 0, 0.5)",
            },
          },
        },
      ],
    });

    nyxfChart.setOption({
      tooltip: {
        trigger: "item",
      },
      textStyle: {
        color: chartTextColor,
      },
      legend: {
        data: ["同期数", "本期数"],
        textStyle: {
          color: chartTextColor,
        },
      },
      xAxis: {
        type: "value",
        boundaryGap: [0, 0.01],
        splitLine: splitLinesplitLine,
      },
      yAxis: {
        type: "category",
        data: ["全区", "金湾直属", "开发区"],
        axisLabel: {
          inside: false,
        },
      },
      series: [
        {
          name: "同期数",
          type: "bar",
          data: [71.81, 8.71, 63.1],
        },
        {
          name: "本期数",
          type: "bar",
          data: [99.71, 11.7, 88.01],
        },
      ],
    });
  },
};
</script>

<style lang="less" scoped>
.content-wrap {
  display: flex;
  background-color: #003366;
  background-image: url("../../assets/bg-gongye.jpg");
  background-position: center;
  background-size: cover;
}
.side-wrap {
  flex: 0 0 auto;
  box-sizing: border-box;
  width: 25%;
}
.big-wrap {
  padding: 0 24px;
  width: 50%;
  height: 100%;
}
.img-box {
  height: 60%;
}

.chart-box {
  width: 100%;
  height: 300px;
}
.big-bt-item {
  flex: 0 0 auto;
  width: 50%;
  height: 100%;
}

.jjxy-wrap {
  display: flex;
  justify-content: space-between;
  color: #6699cc;
}
.jjxy-wrap .value {
  padding: 12px 0;
}
.jjxy-wrap .num {
  font-size: 28px;
  color: #ccffff;
}
</style>