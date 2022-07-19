<!--
 * @Author: Joy wang
 * @Date: 2021-05-06 12:24:22
 * @LastEditTime: 2021-05-28 15:42:01
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div style="width: 100%; height: 100%; position: relative" id="theme-dark">
    <HeadBar item-bg-color="rgba(0, 0, 0, 0.5)"></HeadBar>
    <div class="content-wrap">
      <div class="row-side side-left">
        <div class="transform-box">
          <ModuleCard
            title="固定资产投资"
            :total-info="gdzctzTotalData"
            class="item-wrap"
          >
            <div id="chart-gudingzichantouzi" class="h-large"></div>
          </ModuleCard>

          <ModuleCard
            title="吸收外商投资"
            :total-info="wstzTotalData"
            class="item-wrap"
          >
            <div id="chart-waishangtouzi" class="h-large"></div>
          </ModuleCard>
          <ModuleCard
            title="外贸进出口"
            :total-info="wgjckData.total"
            class="item-wrap"
          >
            <div class="index-waimao h-small">
              <ChartPie3D></ChartPie3D>
            </div>
          </ModuleCard>
        </div>
        <div class="bt-shadow"></div>
      </div>

      <!-- middle -->
      <div class="row-big">
        <div class="banner">
          <div id="nimabi-map"></div>
          <div class="total-box" style="display: block">
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

        <div class="m-middle-slider-wrap">
          <div class="bar">
            <div
              :class="['item', sliderIndex == 0 ? 'current' : '']"
              @click="sliderIndex = 0"
            >
              工业增加值
            </div>
            <div
              :class="['item', sliderIndex == 1 ? 'current' : '']"
              @click="sliderIndex = 1"
            >
              工业总产值
            </div>
            <div
              :class="['item', sliderIndex == 2 ? 'current' : '']"
              @click="sliderIndex = 2"
            >
              机场港口
            </div>
          </div>
          <Carousel v-model="sliderIndex" dots="none">
            <CarouselItem>
              <div class="l-row l-row-bt">
                <div style="width: 30.25%">
                  <div class="module-total-num">
                    <EffectCircle>
                      <div class="num-box">
                        <div>
                          <span class="num">114.49</span>
                          <div class="desc">(亿元)</div>
                        </div>
                        <div class="trend-box">
                          <!-- <span>同比</span> -->
                          <Trend :rate="27.8"></Trend>
                        </div>
                      </div>
                    </EffectCircle>
                  </div>
                </div>
                <div
                  id="chart-gongyezengjiazhi"
                  style="width: 640px"
                  class="slide-height"
                ></div>
              </div>
            </CarouselItem>
            <CarouselItem>
              <div class="l-row l-row-bt">
                <div style="width: 30.25%">
                  <div class="module-total-num">
                    <EffectCircle>
                      <div class="num-box">
                        <div>
                          <span class="num">484.83</span>
                          <div class="desc">(亿元)</div>
                        </div>
                        <div class="trend-box">
                          <!-- <span>同比</span> -->
                          <Trend :rate="29.6"></Trend>
                        </div>
                      </div>
                    </EffectCircle>
                  </div>
                </div>
                <div
                  id="chart-gongyezongchanzhi"
                  style="width: 640px"
                  class="slide-height"
                ></div>
              </div>
            </CarouselItem>
            <CarouselItem>
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
                    <div class="unit">
                      <div class="num">35</div>
                      <div class="">集装箱吞吐量(万TEU)</div>
                      <div class="l-row">同比<Trend :rate="9.8" /></div>
                    </div>
                  </div>
                </div>
              </div>
            </CarouselItem>
          </Carousel>
        </div>
      </div>

      <!-- side -->
      <div class="row-side side-right">
        <div class="transform-box">
          <ModuleCard
            title="一般公共预算收入"
            :total-info="ggysTotalData.income"
            class="item-wrap"
          >
            <div id="chart-caizhengyusuan-income" class="h-large"></div>
          </ModuleCard>
          <ModuleCard
            title="一般公共预算支出"
            :total-info="ggysTotalData.expend"
            class="item-wrap"
          >
            <div id="chart-caizhengyusuan-expend" class="h-large"></div>
          </ModuleCard>
          <ModuleCard
            title="社会消费品零售总额"
            :total-info="xfplsTotalData"
            class="item-wrap"
          >
            <div id="chart-shehuixiaofei" class="h-small"></div>
          </ModuleCard>
        </div>
        <div class="bt-shadow"></div>
      </div>
    </div>

    <!--  -->

  </div>
</template>

<script>
import * as baseApi from "@/api/base.js";
import Axios from "@/api/request.js";
// import tool function
import { formatStringWrap } from "@/libs/tools.js";
import EffectCircle from "@/components/effects/effect-circle.vue";
import ChartPie3D from "@/components/bmk-chart/chart-pie3d.vue";
import HeadBar from "@/components/common/header-bar.vue";
export default {
  components: { EffectCircle, ChartPie3D, HeadBar },
  data() {
    return {
      sliderIndex: 0,
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
    sliderChange(n, o) {
      console.log(n, o);
    },
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

      // 外贸进出口
      // echartInstance.waimaojinchukou = this.$echarts.init(
      //   document.getElementById("chart-waimaojinchukou"),
      //   themeName
      // );

      // 指标对比
      // echartInstance.zhibiaoduibi = this.$echarts.init(
      //   document.getElementById("chart-zhibiaoduibi"),
      //   themeName
      // );
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
            itemStyle: {
              color: "#1ee6e7",
            },
          },
          {
            type: "bar",
            itemStyle: {
              // color: "#1ee6e7",
            },
          },
          {
            type: "bar",
            itemStyle: {
              color: "#1aaff7",
            },
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
            barWidth: 12,
            itemStyle: {
              normal: {
                color: {
                  type: "linear",
                  x: 0,
                  y: 0,
                  x2: 0,
                  y2: 1,
                  colorStops: [
                    {
                      offset: 0,
                      color: "#1aaff7", //  0%  处的颜色
                    },
                    {
                      offset: 1,
                      color: "#1ee5e7", //  100%  处的颜色
                    },
                  ],
                  global: false, //  缺省为  false
                },
              },
              emphasis: {
                opacity: 1,
              },
            },
          },
          {
            type: "line",
            yAxisIndex: 1,
            itemStyle: {
              color: "rgba(55,200,255,0.7)",
            },
            areaStyle: {
              normal: {
                color: new this.$echarts.graphic.LinearGradient(
                  0,
                  0,
                  0,
                  1,
                  [
                    {
                      offset: 0,
                      color: "rgba(55,200,255,0.7)",
                    },
                    {
                      offset: 1,
                      color: "rgba(55,200,255,0)",
                    },
                  ],
                  false
                ),
                shadowColor: "rgba(55,200,255, 0.9)",
                shadowBlur: 20,
              },
            },
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
            barWidth: 12,
            itemStyle: {
              normal: {
                color: {
                  type: "linear",
                  x: 0,
                  y: 0,
                  x2: 0,
                  y2: 1,
                  colorStops: [
                    {
                      offset: 0,
                      color: "#1aaff7", //  0%  处的颜色
                    },
                    {
                      offset: 1,
                      color: "#1ee5e7", //  100%  处的颜色
                    },
                  ],
                  global: false, //  缺省为  false
                },
              },
              emphasis: {
                opacity: 1,
              },
            },
          },
          {
            type: "line",
            yAxisIndex: 1,
            itemStyle: {
              color: "rgba(55,200,255,0.7)",
            },
            areaStyle: {
              normal: {
                color: new this.$echarts.graphic.LinearGradient(
                  0,
                  0,
                  0,
                  1,
                  [
                    {
                      offset: 0,
                      color: "rgba(55,200,255,0.7)",
                    },
                    {
                      offset: 1,
                      color: "rgba(55,200,255,0)",
                    },
                  ],
                  false
                ),
                shadowColor: "rgba(55,200,255, 0.9)",
                shadowBlur: 20,
              },
            },
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
          text: "税收收入",
        },
        tooltip: { trigger: "axis" },

        xAxis: {
          type: "category",
          axisLabel: {
            formatter: function (value) {
              return formatStringWrap(value, 3);
            },
          },
        },
        yAxis: [
          {
            type: "value",
          },
        ],
        series: [
          {
            type: "pictorialBar",
            barCategoryGap: "0%",
            symbol:
              "path://M0,10 L10,10 C5.5,10 5.5,5 5,0 C4.5,5 4.5,10 0,10 z",
            symbolSize: ["400%", "100%"],

            barWidth: 12,
            itemStyle: {
              normal: {
                color: {
                  type: "linear",
                  x: 0,
                  y: 0,
                  x2: 0,
                  y2: 1,
                  colorStops: [
                    {
                      offset: 0,
                      color: "#1aaff7", //  0%  处的颜色
                    },
                    {
                      offset: 1,
                      color: "#1ee5e7", //  100%  处的颜色
                    },
                  ],
                  global: false, //  缺省为  false
                },
              },
              emphasis: {
                opacity: 1,
              },
            },
            label: {
              show: true,
              position: "top",
              distance: 10,
              color: "#08DFFE",
              fontWeight: "100",
              fontSize: 12,
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
        xAxis: [
          {
            type: "category",
            axisLabel: {
              formatter: function (value) {
                return formatStringWrap(value, 2);
              },
            },
          },
        ],
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
            showBackground: true,
            backgroundStyle: {
              color: "rgba(180, 180, 180, 0.2)",
            },
            barWidth: 12,
            itemStyle: {
              normal: {
                color: {
                  type: "linear",
                  x: 0,
                  y: 0,
                  x2: 0,
                  y2: 1,
                  colorStops: [
                    {
                      offset: 0,
                      color: "#1aaff7", //  0%  处的颜色
                    },
                    {
                      offset: 1,
                      color: "#1ee5e7", //  100%  处的颜色
                    },
                  ],
                  global: false, //  缺省为  false
                },
              },
              emphasis: {
                opacity: 1,
              },
            },
          },
          {
            type: "line",
            yAxisIndex: 1,
            itemStyle: {
              color: "rgba(55,200,255,0.7)",
            },
            areaStyle: {
              normal: {
                color: new this.$echarts.graphic.LinearGradient(
                  0,
                  0,
                  0,
                  1,
                  [
                    {
                      offset: 0,
                      color: "rgba(55,200,255,0.7)",
                    },
                    {
                      offset: 1,
                      color: "rgba(55,200,255,0)",
                    },
                  ],
                  false
                ),
                shadowColor: "rgba(55,200,255, 0.9)",
                shadowBlur: 20,
              },
            },
          },
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
          subtext: "",
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
            showAllSymbol: true,
            // symbol: 'image://./static/images/guang-circle.png',
            symbol: "circle",
            symbolSize: 4,
            itemStyle: {
              color: "rgba(55,200,255,1)",
              borderColor: "#fff",
              borderWidth: 4,
              shadowColor: "rgba(55,200,255,1)",
              shadowBlur: 6,
            },
            areaStyle: {
              normal: {
                color: new this.$echarts.graphic.LinearGradient(
                  0,
                  0,
                  0,
                  1,
                  [
                    {
                      offset: 0,
                      color: "rgba(55,200,255,0.7)",
                    },
                    {
                      offset: 1,
                      color: "rgba(55,200,255,0)",
                    },
                  ],
                  false
                ),
                shadowColor: "rgba(55,200,255, 0.9)",
                shadowBlur: 20,
              },
            },
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
            showAllSymbol: true,
            // symbol: 'image://./static/images/guang-circle.png',
            symbol: "circle",
            symbolSize: 4,
            itemStyle: {
              color: "rgba(55,200,255,1)",
              borderColor: "#fff",
              borderWidth: 4,
              shadowColor: "rgba(55,200,255,1)",
              shadowBlur: 6,
            },
            areaStyle: {
              normal: {
                color: new this.$echarts.graphic.LinearGradient(
                  0,
                  0,
                  0,
                  1,
                  [
                    {
                      offset: 0,
                      color: "rgba(55,200,255,0.7)",
                    },
                    {
                      offset: 1,
                      color: "rgba(55,200,255,0)",
                    },
                  ],
                  false
                ),
                shadowColor: "rgba(55,200,255, 0.9)",
                shadowBlur: 20,
              },
            },
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

    /***外贸进出口 */

    /***** */
    var nimabiMapData = [
      {
        name: "金湾",
        value: [113.369874, 22.14481, 1000],
      },
      {
        name: "红旗镇",
        value: [113.334661, 22.115515, 399],
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
        value: [113.236263, 21.994282, 700],
      },
    ];
    var convertData = [];
    convertData = nimabiMapData.slice(1).map((item, index) => {
      return {
        fromName: item.name,
        toName: "金湾",
        coords: [item.value, nimabiMapData[0].value],
      };
    });
    Axios.request({ url: "/assets/img/jinwan-map.json" }).then((res) => {
      this.$echarts.registerMap("sicily", { geoJSON: res });
      var chart = this.$echarts.init(document.getElementById("nimabi-map"));
      // return;
      chart.setOption({
        geo: {
          map: "sicily",
          aspectScale: 1, //长宽比
          zoom: 1,
          roam: false,
          itemStyle: {
            normal: {
              areaColor: "rgba(0,0,0,0)",
              borderWidth: 0,
              shadowColor: "#fff",
              shadowOffsetX: 0,
              shadowOffsetY: 0,
            },
            emphasis: {
              areaColor: "rgba(0,0,0,0)",
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
              scale: 8,
              brushType: "fill",
            },
            hoverAnimation: true,
            itemStyle: {
              normal: {
                color: "#03fbfc",
                shadowBlur: 20,
                shadowColor: "#1ee6e7",
              },
            },
            data: nimabiMapData,
          },
          {
            // name: " Top10",
            type: "lines",
            zlevel: 2,
            symbol: ["none", "arrow"],
            symbolSize: 10,
            effect: {
              show: true,
              color: "#fba714",
              period: 4,
              trailLength: 0.8,
              symbol: "arrow",
              symbolSize: 6,
            },
            lineStyle: {
              color: "#fba714",
              width: 1,
              opacity: 0.6,
              curveness: 0.2,
            },
            data: convertData,
          },
        ],
      });
    });
  },
};
</script>

<style lang="less" scoped>
/****theme */
#app .m-header-bar {
  background-color: transparent;
}
#app .nav .link-item {
  background-color: rgba(0, 0, 0, 0.5);
}
#theme-dark {
  background: url(../../assets/images/index-banner.jpg);
  
  background-repeat: no-repeat;
  background-size: contain;
}
#theme-dark .m-module-card-wrap {
  background: rgba(10, 20, 60, 0.8)
  // color: #fff;
}
#theme-dark .m-module-card-wrap .corner {
  display: none;
  border-color: rgba(255, 255, 255, 0.4);
}
#theme-dark .m-module-card-wrap .corner-top-right {
  border-left-color: transparent;
  border-bottom-color: transparent;
}
#theme-dark .m-module-card-wrap .corner-top-left {
  border-right-color: transparent;
  border-bottom-color: transparent;
}
#theme-dark .m-module-card-wrap .corner-bottom-right {
  border-left-color: transparent;
  border-top-color: transparent;
}
#theme-dark .m-module-card-wrap .corner-bottom-left {
  border-right-color: transparent;
  border-top-color: transparent;
}
#theme-dark .m-module-card-wrap .bar {
  background-color: rgba(0, 0, 0, 0.2);
}

#theme-dark .row-big {
  position: absolute;
  left:22%;
  bottom:40px;
  width:56%;
}
#theme-dark .row-side .bt-shadow {
  // padding-bottom:48px;
  width: 100%;
  height: 64px;
  background: url(../../assets/images/side-shadow.png);
  
  background-repeat: no-repeat;
  background-size: contain;
}
#theme-dark .side-right .bt-shadow {
  background-position: right bottom;
}
#theme-dark .side-left .bt-shadow {
  background-position: left bottom;
  transform: rotateX(150deg);
}
#theme-dark .side-left .transform-box{
  transform: rotateY(30deg);
  transform-origin: left center;
}
#theme-dark .side-right .transform-box{
  transform: rotateY(-30deg);
  transform-origin: right center;
}
#theme-dark .row-side .item-wrap:last-child {
  margin:0;
}

/*** */
.content-wrap {
  position: absolute;
  left: 0;
  top: 0;
  box-sizing: border-box;
  // padding-bottom: 32px;
  width: 100%;
  height: 100%;
  z-index: 1;
  .row-side {
    perspective: 3000px;
  }
  // background-image: url(/img/index-1.jpg);
  // color: #0388f0;
  .banner {
    position: relative;
    padding-top: 100px;
    height: 660px;
  }
}
.item-wrap {
  margin-bottom: 0.083333rem;
}

/**高度 */
#theme-dark .h-small {
  height: 170px;
}
#theme-dark .h-large {
  height: 0.9375rem;
}

#theme-dark .slide-height {
  height: 180px;
}
.chart-gongyezongchanzhi-height {
  height: 1.71875rem;
}

/** */
.m-jcgk-wrap {
  display: flex;
  padding-top: 0.0625rem;
  .item {
    width: 50%;
    display: flex;
    padding-bottom: 0.125rem;
    margin-bottom: 0.125rem;

    .icon {
      flex: 0 0 auto;
      width: 0.4rem;
      height: 0.4rem;
      font-size: 0.4rem;
      color: #37c3fd;
    }
    .info {
      display: flex;
      justify-content: space-between;
      flex-grow: 1;
      padding-left: 0.0625rem;
      text-align: left;
      color: rgba(255, 255, 255, 0.6);
      .unit {
        width: 45%;
        text-align: left;
        .num {
          font-size: 0.125rem;
          font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
          color: #fff;
        }
      }
    }
  }
  .item:last-child {
    padding-left: 24px;
    border-left: 1px solid rgba(180, 180, 180, 0.2);
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

.module-total-num {
  position: relative;
  margin: 0 auto;
  width: 180px;
  height: 180px;
  .num-box {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    line-height: 1;
    font-size: 12px;
    .num {
      margin-right: 8px;
      font-size: 32px;
      font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
      color: #fff;
    }
    .desc {
      color: rgba(255, 255, 255, 0.7);
    }
  }
}

#nimabi-map {
  margin: 0 auto;
  width: 560px;
  height: 560px;
  background: url(../../assets/images/map-bg-1.png);
  background-size: contain;
}

.m-middle-slider-wrap {
  padding: 12px;
  background: rgba(10, 20, 60, 0.8);

  .bar {
    display: flex;
    // justify-content: space-between;
    margin-bottom: 12px;
    padding: 0 12px 12px;
    font-size: 18px;
    color: #fff;
    line-height: 1;
    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    .item {
      position: relative;
      margin-right: 24px;
      padding: 0 12px;
      height: 32px;
      line-height: 32px;
      background-color: rgba(0, 0, 0, 0.2);
      cursor: pointer;
    }
    .item::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      width: 12px;
      height: 12px;
      border-left: 2px solid rgba(255, 255, 255, 0.6);
      border-top: 2px solid rgba(255, 255, 255, 0.6);
    }
    .item::after {
      content: "";
      position: absolute;
      width: 12px;
      height: 12px;
      right: 0;
      bottom: 0;
      border-right: 2px solid rgba(255, 255, 255, 0.6);
      border-bottom: 2px solid rgba(255, 255, 255, 0.6);
    }
    .current {
      background-color: #2a3c54;
      color: #1cfafc;
    }
    .current::before {
      border-color: #1cfafc;
    }
    .current::after {
      border-color: #1cfafc;
    }
  }
}

.index-waimao {
  background: url(../../assets/images/data-bg-1.png);
  background-repeat: no-repeat;
  background-position: bottom center;
  background-size: 80% auto;
}
</style>
