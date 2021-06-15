<!--
 * @Author: Joy wang
 * @Date: 2021-05-06 12:24:22
 * @LastEditTime: 2021-05-25 05:16:54
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div style="width: 100%; height: 100%; position: relative">
    <video
      x5-video-player-type="h5"
      playsinline=""
      webkitplaysinline="true"
      width="1920"
      height="1080"
      autoplay
      loop
      src="/assets/bg-effects.mp4"
      poster=""
      x5-playsinline=""
      webkit-playsinline=""
      controlslist="nodownload"
      style="
        width: 1920px;
        height: 1080px;
        object-fit: fill;
        opacity: 1;
        transform: none;
      "
    ></video>
    <div class="content-wrap">
      <div class="row-side">
        <ModuleCard
          title="固定资产投资"
          :total-info="gdzctzTotalData"
          class="item-wrap"
        >
          <div id="chart-gudingzichantouzi"></div>
        </ModuleCard>

        <ModuleCard
          title="外贸进出口"
          :total-info="wgjckData.total"
          class="item-wrap"
        >
          <div class="m-waimao-cate-total">
            <div class="item">
              <div class="l-row">
                <Icon type="ios-globe-outline" class="icon" />
                <div class="title">外贸出口</div>
              </div>
              <div class="l-row l-row-bt">
                <div class="num">91.43</div>
                <Trend :rate="37.6" />
              </div>
            </div>
            <div class="item">
              <div class="l-row">
                <Icon type="ios-globe-outline" class="icon" />
                <div class="title">外贸进口</div>
              </div>
              <div class="l-row l-row-bt">
                <div class="num">94.11</div>
                <Trend :rate="47.5" />
              </div>
            </div>
          </div>
        </ModuleCard>
        <ModuleCard
          title="外商投资"
          :total-info="wstzTotalData"
          class="item-wrap"
        >
          <div id="chart-waishangtouzi"></div>
        </ModuleCard>
        <ModuleCard title="机场、港口" class="item-wrap">
          <div class="m-jcgk-wrap">
            <div class="item">
              <Icon type="md-plane" class="icon" />
              <div class="info">
                <div class="unit">
                  <div class="num">189.17</div>
                  <div class="">旅客吞吐量(万人次)</div>
                  <div class="l-row">同比<Trend :rate="50.7" /></div>
                </div>
                <div class="unit">
                  <div class="num">0.99</div>
                  <div class="">货邮吞吐量(万吨)</div>
                  <div class="l-row">同比<Trend :rate="33.6" /></div>
                </div>
              </div>
            </div>
            <div class="item">
              <Icon type="md-boat" class="icon" />
              <div class="info">
                <div class="unit">
                  <div class="num">2823</div>
                  <div class="">货物吞吐量(万吨)</div>
                  <div class="l-row">同比<Trend :rate="12.7" /></div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div id="chart-jichanggangkou"></div> -->
        </ModuleCard>
      </div>

      <!-- middle -->
      <div class="row-big">
        <div class="banner">
          <div id="nimabi-map" style="width: 100%; height: 500px"></div>
          <div class="total-box">
            <div class="item">
              <div class="title">一季度地区生产总值(亿元)</div>
              <div class="count-up">155.45</div>
              <div class="trend-box">
                <span>同比增长</span>
                <Trend :rate="20.1"></Trend>
              </div>
            </div>
          </div>
          <!-- <img src="@/assets/images/map-bg.png" alt="" /> -->
        </div>
        <ModuleCard
          title="规模以上工业增加值"
          :total-info="gyzjzData.total"
          class="item-wrap"
        >
          <div class="l-row l-row-bt">
            <div
              class="chart-gongyezengjiazhi-height"
              style="width: 40.25%"
            ></div>
            <div style="width: 49.25%">
              <div
                id="chart-gongyezengjiazhi"
                class="chart-gongyezengjiazhi-height"
              ></div>
            </div>
          </div>
        </ModuleCard>
        <ModuleCard
          title="规模以上工业总产值"
          :total-info="gyzczData.total"
          class="item-wrap"
        >
          <div class="l-row l-row-bt">
            <div
              class="chart-gongyezongchanzhi-height"
              style="width: 49.25%"
            ></div>
            <div
              id="chart-gongyezongchanzhi"
              class="chart-gongyezongchanzhi-height"
              style="width: 49.25%"
            ></div>
          </div>
        </ModuleCard>
      </div>

      <!-- side -->
      <div class="row-side">
        <ModuleCard title="各区地区生产总值比较" class="item-wrap">
          <div id="chart-zhibiaoduibi"></div>
        </ModuleCard>
        <ModuleCard
          title="一般公共预算收入"
          :total-info="ggysTotalData.income"
          class="item-wrap"
        >
          <div id="chart-caizhengyusuan-income"></div>
        </ModuleCard>
        <ModuleCard
          title="一般公共预算支出"
          :total-info="ggysTotalData.expend"
          class="item-wrap"
        >
          <div id="chart-caizhengyusuan-expend"></div>
        </ModuleCard>
        <ModuleCard
          title="社会消费及零售"
          :total-info="xfplsTotalData"
          class="item-wrap"
        >
          <div id="chart-shehuixiaofei"></div>
        </ModuleCard>
      </div>
    </div>
  </div>
</template>

<script>
import * as baseApi from "@/api/base.js";
import Axios from "@/api/request.js";
// import tool function
import { formatStringWrap } from "@/libs/tools.js";
export default {
  components: {},
  data() {
    return {
      echartInstance: {},
      gdzctzTotalData: {},
      wgjckData: {
        total: {
          num: 185.54,
          measure: "亿元",
          rise: 42.5,
        },
      },
      gyzjzData: {
        total: {},
        chartOpt: {},
      },
      gyzczData: {
        total: {},
        chartOpt: {},
      },
      ggysTotalData: {
        income: {},
        expend: {},
      },
      wstzTotalData: {},
      xfplsTotalData: {},
    };
  },
  methods: {
    chartInit({ themeName = this.$config.chartTheme } = {}) {
      /**图表初始化 */
      var echartInstance = {};

      // 固定资产投资
      echartInstance.gudingzichantouzi = this.$echarts.init(
        document.getElementById("chart-gudingzichantouzi"),
        themeName
      );
      // 外商投资
      echartInstance.waishangtouzi = this.$echarts.init(
        document.getElementById("chart-waishangtouzi"),
        themeName
      );

      // 重点支柱工业增加值
      echartInstance.gongyezengjiazhi = this.$echarts.init(
        document.getElementById("chart-gongyezengjiazhi"),
        themeName
      );
      // 重点支柱工业总产值
      echartInstance.gongyezongchanzhi = this.$echarts.init(
        document.getElementById("chart-gongyezongchanzhi"),
        themeName
      );
      // 财政预算税收收入
      echartInstance.caizhengyusuan_income = this.$echarts.init(
        document.getElementById("chart-caizhengyusuan-income"),
        themeName
      );
      // 财政预算支出-公共服务
      echartInstance.caizhengyusuan_expend = this.$echarts.init(
        document.getElementById("chart-caizhengyusuan-expend"),
        themeName
      );
      // 社会消费品零售
      echartInstance.shehuixiaofei = this.$echarts.init(
        document.getElementById("chart-shehuixiaofei"),
        themeName
      );
      // 机场港口
      // echartInstance.jichanggangkou = this.$echarts.init(
      //   document.getElementById("chart-jichanggangkou"),
      //   themeName
      // );

      // 指标对比
      echartInstance.zhibiaoduibi = this.$echarts.init(
        document.getElementById("chart-zhibiaoduibi"),
        themeName
      );
      this.echartInstance = echartInstance;
    },
  },
  mounted() {
    /** */
    this.chartInit();

    /*** 固定资产投资 */
    baseApi.get_gdzctz().then((res) => {
      this.gdzctzTotalData = res.total;
      this.echartInstance.gudingzichantouzi.setOption({
        dataset: { source: res.data.gross },
        tooltip: { trigger: "axis" },
        legend: {
          left: "left",
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            inside: false,
            formatter: function (value) {
              return formatStringWrap(value, 4);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: "{value}" + "亿",
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
            backgroundStyle: {
              color: "rgba(180, 180, 180, 0.2)",
            },
          },
          {
            type: "bar",
          },
          {
            type: "bar",
          },
        ],
      });
    });

    /**** 工业增加值 */
    baseApi.get_gyzjz().then((res) => {
      var charData = res.data.slice(1);
      this.gyzjzData = {
        total: res.total,
        chartOpt: {
          chart: {
            type: "pie",
            options3d: {
              enabled: true,
              alpha: 45,
              beta: 0,
            },
          },
          title: {
            text: "规模以上工业增加值",
          },
          tooltip: {
            pointFormat: "占全区比重: <b>{point.percentage:.1f}%</b>",
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              borderWidth: 0,
              cursor: "pointer",
              depth: 35,
              innerSize: 40,
              dataLabels: {
                enabled: true,
                distance: "-45%",
                formatter: function () {
                  return "增加值:" + this.point.y;
                  // return this.point.name + "<br>增加值:" + this.point.y;
                },
                style: {
                  color: "#fff",
                  fontSize: "12px",
                  fontWeight: "normal",
                  textOutline: "none",
                },
              },
            },
          },
          series: [
            {
              type: "pie",
              name: "工业增加值",
              data: charData,
            },
          ],
        },
      };
    });

    /**** 工业总产值 */
    baseApi.get_gyzcz().then((res) => {
      var charData = res.data.slice(1);
      this.gyzczData = {
        total: res.total,
        chartOpt: {
          chart: {
            type: "pie",
            options3d: {
              enabled: true,
              alpha: 45,
              beta: 0,
            },
          },
          title: {
            text: "规模以上工业总产值",
          },
          tooltip: {
            pointFormat: "占全区比重: <b>{point.percentage:.1f}%</b>",
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              borderWidth: 0,
              cursor: "pointer",
              depth: 35,
              innerSize: 40,
              dataLabels: {
                enabled: true,
                distance: "-45%",
                formatter: function () {
                  return "增加值:" + this.point.y;
                  // return this.point.name + "<br>增加值:" + this.point.y;
                },
                style: {
                  color: "#fff",
                  fontSize: "12px",
                  fontWeight: "normal",
                  textOutline: "none",
                },
              },
            },
          },
          series: [
            {
              type: "pie",
              name: "工业总产值",
              data: charData,
            },
          ],
        },
      };
    });

    /***重点支柱工业增加值 */
    baseApi.get_gyzjz_zdzz().then((res) => {
      var chartData = res.data;
      chartData.unshift(["product", "增加值", "同比增长"]);
      this.echartInstance.gongyezengjiazhi.setOption({
        dataset: { source: chartData },
        title: {
          text: "重点支柱产业工业增加值",
        },
        tooltip: { trigger: "axis" },
        legend: {
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            inside: false,
            // rotate: -45,
            formatter: function (value) {
              return formatStringWrap(value, 2);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: function (value) {
                return value / 100 + "K";
              },
            },
          },
          {
            type: "value",
            axisLabel: {
              formatter: "{value}" + "%",
            },
          },
        ],
        series: [
          {
            type: "bar",
            showBackground: true,
            backgroundStyle: {
              color: "rgba(180, 180, 180, 0.2)",
            },
          },
          {
            type: "line",
            yAxisIndex: 1,
          },
        ],
      });
    });

    /***重点支柱工业总产值 */
    baseApi.get_gyzcz_zdzz().then((res) => {
      var chartData = res.data;
      chartData.unshift(["product", "总产值", "同比增长"]);
      this.echartInstance.gongyezongchanzhi.setOption({
        dataset: { source: chartData },
        title: {
          text: "重点支柱产业工业总产值",
        },
        tooltip: { trigger: "axis" },
        legend: {
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            inside: false,
            // rotate: -45,
            formatter: function (value) {
              return formatStringWrap(value, 2);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: function (value) {
                return value / 100 + "K";
              },
            },
          },
          {
            type: "value",
            axisLabel: {
              formatter: "{value}" + "%",
            },
          },
        ],
        series: [
          {
            type: "bar",
            showBackground: true,
            backgroundStyle: {
              color: "rgba(180, 180, 180, 0.2)",
            },
          },
          {
            type: "line",
            yAxisIndex: 1,
          },
        ],
      });
    });

    /***一般公共预算 */
    baseApi.get_ggys().then((res) => {
      var incomeChartData = res.income.data;
      var expendChartData = res.expend.data;
      // incomeChartData.unshift(["product", "总量", "同比增长"]);
      // expendChartData.unshift(["product", "总量", "同比增长"]);
      console.log(expendChartData);

      //设置统计信息
      this.ggysTotalData.income = res.income.total;
      this.ggysTotalData.expend = res.expend.total;

      // 税收
      this.echartInstance.caizhengyusuan_income.setOption({
        dataset: { source: incomeChartData },
        title: {
          text: "全区税收收入",
        },
        tooltip: { trigger: "axis" },

        xAxis: {
          type: "value",
        },
        yAxis: [
          {
            type: "category",
            axisLabel: {
              formatter: function (value) {
                return formatStringWrap(value, 3);
              },
            },
          },
        ],
        series: [
          {
            type: "bar",
            showBackground: true,
            backgroundStyle: {
              color: "rgba(180, 180, 180, 0.2)",
            },
            barWidth: 12,
            itemStyle: {
              borderRadius: [0, 6, 6, 0],
            },
          },
        ],
      });

      // 公共服务支出
      this.echartInstance.caizhengyusuan_expend.setOption({
        dataset: { source: expendChartData },
        title: {
          text: "一般公共服务支出",
        },
        tooltip: { trigger: "axis" },
        legend: {
          top: "top",
        },
        xAxis: {
          type: "value",
          axisLabel: {
            formatter: function (value) {
              return value;
            },
          },
        },
        yAxis: [
          {
            type: "category",
            axisLabel: {
              formatter: function (value) {
                return formatStringWrap(value, 4);
              },
            },
          },
          // {
          //   type: "value",
          //   axisLabel: {
          //     formatter: "{value}" + "%",
          //   },
          // },
        ],
        series: [
          {
            type: "bar",
            showBackground: true,
            backgroundStyle: {
              color: "rgba(180, 180, 180, 0.2)",
            },
            barWidth: 12,
            itemStyle: {
              borderRadius: [0, 6, 6, 0],
            },
          },
          // {
          //   type: "line",
          //   yAxisIndex: 1,
          // },
        ],
      });
    });

    /***机场港口 */
    baseApi.get_gk_glg().then((res) => {
      return false;
      var chartData = res.data;
      chartData.unshift(["product", "总量", "同比增长"]);
      this.echartInstance.jichanggangkou.setOption({
        dataset: { source: chartData },
        title: {
          text: "高栏港港口吞吐量分类统计情况",
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: false,
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            fontSize: "12px",
            formatter: function (value) {
              var ret = "";
              var maxLength = 2;
              var rowNum = Math.ceil(value.length / maxLength);
              if (rowNum > 1) {
                for (var i = 0; i < rowNum; i++) {
                  var temp = "";
                  var start = i * maxLength;
                  var end = start + maxLength;
                  temp = value.substring(start, end) + "\n";
                  ret += temp;
                }
                return ret;
              } else {
                return value;
              }
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
          },
          {
            type: "value",
            axisLabel: {
              formatter: "{value}" + "%",
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
    });

    /***外商投资 */
    baseApi.get_wstz().then((res) => {
      var chartData = res.data;
      // chartData.unshift(["product", "金湾区", "金湾直属", "开发区"]);
      this.wstzTotalData = res.total;
      this.echartInstance.waishangtouzi.setOption({
        dataset: { source: chartData },
        title: {
          text: "实际利用外商直接投资累计增长速度",
          subtext: "2020年3月——2021年3月",
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "center",
          top: "bottom",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            fontSize: "12px",
            rotate: -45,
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
          },
          // {
          //   type: "line",
          //   areaStyle: {},
          // },
          // {
          //   type: "line",
          //   areaStyle: {},
          // },
        ],
      });
    });

    /***指标对比 */
    baseApi.get_zbdb().then((res) => {
      var chartData = res.data;
      this.echartInstance.zhibiaoduibi.setOption({
        dataset: { source: chartData },
        title: {
          text: "",
        },
        legend: {
          left: "right",
          orient: "vertical",
        },
        tooltip: {
          trigger: "item",
        },
        series: [
          {
            type: "pie",
            radius: ["40%", "70%"],
            label: {
              show: true,
              color: "#fff",
            },
            labelLine: {
              show: true,
            },
          },
        ],
      });
    });

    /***社会消费品零售总额 */
    baseApi.get_xfpls().then((res) => {
      this.xfplsTotalData = res.total;
      this.echartInstance.shehuixiaofei.setOption({
        dataset: { source: res.data },
        title: {
          text: "社会消费品零售总额累计增长速度",
          subtext: "2020年3月——2021年3月",
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "center",
          top: "bottom",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            fontSize: "12px",
            rotate: -45,
            formatter: function (value) {
              return value.substring(5);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: function (value) {
                return value + "%";
              },
            },
          },
        ],
        series: [
          {
            type: "line",
            areaStyle: {},
          },
        ],
      });
    });

    /***** */
    var nimabiMapData = [
      {
        name: "红旗镇",
        value: [113.352134, 22.144778, 399],
      },
      {
        name: "三灶镇",
        value: [113.358185, 22.053177, 500],
      },
      {
        name: "平沙镇",
        value: [113.194542, 22.111279, 600],
      },
      {
        name: "南水镇",
        value: [113.247733, 22.032468, 700],
      },
    ];
    Axios.request({ url: "../../../img/jinwan-map.json" }).then((res) => {
      this.$echarts.registerMap("sicily", { geoJSON: res });
      // var chart = this.$echarts.init(document.getElementById("nimabi-map"));
      return;
      chart.setOption({
        geo: {
          map: "sicily",
          aspectScale: 0.75, //长宽比
          zoom: 1.1,
          roam: false,
          itemStyle: {
            normal: {
              areaColor: "#ddd",
              shadowColor: "#ddd",
              shadowOffsetX: 0,
              shadowOffsetY: 0,
            },
            emphasis: {
              areaColor: "#fff",
              borderWidth: 0,
              color: "#fff",
              label: {
                show: false,
              },
            },
          },
        },
        series: [
          {
            type: "effectScatter",
            coordinateSystem: "geo",
            showEffectOn: "render",
            rippleEffect: {
              period: 15,
              scale: 4,
              brushType: "fill",
            },
            hoverAnimation: true,
            itemStyle: {
              normal: {
                color: "#ffff",
                shadowBlur: 20,
                shadowColor: "#333",
              },
            },
            data: nimabiMapData,
          },
        ],
      });
    });
  },
};
</script>

<style lang="less">
/****theme */
#app .m-header-bar {
  background-color: transparent;
}
#app .m-module-card-wrap {
  background-color: rgba(0, 0, 0, 0.15);
  color:#fff;
}
#app .m-module-card-wrap .corner {
  border-color:rgba(255, 255, 255, 0.4);
}
#app .m-module-card-wrap .corner-top-right {
  border-left-color: transparent;
  border-bottom-color: transparent;
}
#app .m-module-card-wrap .corner-top-left {
  border-right-color: transparent;
  border-bottom-color: transparent;
}
#app .m-module-card-wrap .corner-bottom-right {
  border-left-color: transparent;
  border-top-color: transparent;
}
#app .m-module-card-wrap .corner-bottom-left {
  border-right-color: transparent;
  border-top-color: transparent;
}
/*** */
.content-wrap {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  // background-image: url(/img/index-1.jpg);
  // color: #0388f0;
  .banner {
    position: relative;
    height: 3.125rem;
  }
}
.item-wrap {
  margin-bottom: 0.083333rem;
}

/**高度 */
#chart-zhibiaoduibi {
  height: 1.145833rem;
}
#chart-gudingzichantouzi {
  height: 1.458333rem;
}
#chart-waishangtouzi {
  height: 1.770833rem;
}
#chart-waimao {
  height: 1.666667rem;
}
.chart-gongyezengjiazhi-height {
  height: 1.71875rem;
}
.chart-gongyezongchanzhi-height {
  height: 1.71875rem;
}
#chart-caizhengyusuan-income {
  height: 1.458333rem;
}
#chart-caizhengyusuan-expend {
  height: 1.658333rem;
}
#chart-shehuixiaofei {
  height: 1.145833rem;
}
#chart-jichanggangkou {
  height: 1.666667rem;
}

/** */
.m-jcgk-wrap {
  padding-top: 0.0625rem;
  .item {
    display: flex;
    padding-bottom: 0.125rem;
    margin-bottom: 0.125rem;
    border-bottom: 1px solid rgba(180, 180, 180, 0.2);
    .icon {
      flex: 0 0 auto;
      width: 0.4rem;
      height: 0.4rem;
      font-size: 0.4rem;
      color: #0388f0;
    }
    .info {
      display: flex;
      justify-content: space-between;
      flex-grow: 1;
      padding-left: 0.0625rem;
      text-align: left;
      color: #2a7ac1;
      .unit {
        width: 45%;
        text-align: left;
        .num {
          font-size: 0.125rem;
          color: #fff;
        }
      }
    }
  }
  .item:last-child {
    margin-bottom: 0;
    border: none;
  }
}

/** */
.m-waimao-cate-total {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.125rem 0;
  color: rgba(255, 255, 255, 0.8);
  .item {
    width: 45%;
    .icon {
      margin-right: 6px;
      font-size: 24px;
      width: 0.125rem;
      height: 0.125rem;
      color: #4ccbfe;
    }
    .num {
      font-size: 0.125rem;
      color: turquoise;
    }
  }
}

/*** */
.main-banner-box {
  position: relative;
  padding-top: 80px;
  width: 100%;
  height: 600px;
}
.total-box {
  display: flex;
  justify-content: center;
  position: absolute;
  left: 0;
  top: 0;
  z-index: 99;
  width: 100%;
}
.total-box .item {
  display: inline-block;
  padding: 24px;
  color: #fff;
  text-align: center;
  .count-up {
    margin: 12px 0;
    padding: 0 24px;
    font-size: 36px;
    background-color: rgba(0, 0, 0, 0.2);
    text-shadow: 0 2px 20px rgba(0, 100, 255, 0.5);
    letter-spacing: 4px;
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
  }
}
</style>
