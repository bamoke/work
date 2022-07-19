<!--
 * @Author: Joy wang
 * @Date: 2021-05-06 12:49:38
 * @LastEditTime: 2021-06-02 08:03:40
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <!--工业增加值-->
    <div class="row-side side-left">
      <div class="transform-box">
        <ModuleCard title="规上工业增加值累计增长速度" class="item-wrap">
          <ChartMonth
            :height="220"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard title="规上工业增加值及同比增长" class="item-wrap">
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeYearMode('gross')"
                >总值</Button
              >
              <Button @click="handleChangeYearMode('rise')">增长率</Button>
            </ButtonGroup>
          </template>
          <ChartYear
            :height="220"
            :title="timelineYearData.title"
            :mode="timelineYearData.mode"
            :chart-data="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
        <ModuleCard title="各区规上工业增加值比较" class="item-wrap">
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeCompareCounty('gross')"
                >总量</Button
              >
              <Button @click="handleChangeCompareCounty('rise')">同比增长</Button>
            </ButtonGroup>
          </template>
          <ChartCompareCounty
            :height="220"
            :mode="compareCountyData.mode"
            :title="compareCountyData.title"
            :chart-data="compareCountyData.data"
          ></ChartCompareCounty>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>



    <div class="row-big">
      <div class="banner-box"></div>
      <div class="item-wrap">
        <div class="l-row l-row-bt">
          <EffectCircleCount3D :data="totalInfo.zjz"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.zcz"></EffectCircleCount3D>
        </div>
      </div>
      <div class="item-wrap">
        <div class="m-child-nav-box">
          <router-link :to="{ name: 'gongye_zzcy' }" class="child-nav-item">
            <div class="nav-name">重点支柱产业</div>
          </router-link>
          <router-link :to="{ name: 'gongye_myqy' }" class="child-nav-item">
            <div class="nav-name">现代产业和规上民营企业</div>
          </router-link>
          <router-link :to="{ name: 'gongye_hy' }" class="child-nav-item">
            <div class="nav-name">规模以上工业分行业</div>
          </router-link>
          <router-link :to="{ name: 'gongye_ny' }" class="child-nav-item">
            <div class="nav-name">能源消费及用电量</div>
          </router-link>
        </div>
      </div>
    </div>

    <!-- 工业生产总值 -->
    <div class="row-side side-right">
      <div class="transform-box">
        <ModuleCard title="规工业总产值累计增长速度" class="item-wrap">
          <ChartMonth
            chart-id="chart-leijizengzhangexpend"
            :height="200"
            :title="leijizengzhangDataZcz.title"
            :chart-data="leijizengzhangDataZcz.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard title="规上工业总产值及同比增长" class="item-wrap">
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeYearMode('gross','timelineYearDataZcz')"
                >总值</Button
              >
              <Button @click="handleChangeYearMode('rise','timelineYearDataZcz')">增长率</Button>
            </ButtonGroup>
          </template>
          <ChartYear
            chart-id="chart-timelineyearzcz"
            :height="200"
            :title="timelineYearDataZcz.title"
            :mode="timelineYearDataZcz.mode"
            :chart-data="timelineYearDataZcz.data"
          ></ChartYear>
        </ModuleCard>
        <ModuleCard title="规上工业经济效益" class="item-wrap">
          <div class="jjxy-wrap">
            <div class="jjxy-item">
              <div class="section">营业收入<span class="sub">(万元)</span></div>
              <div class="content">
                <div class="value"><span class="num">4952142</span></div>
                <div>同比<Trend :rate="45.4" /></div>
              </div>
            </div>
            <div class="jjxy-item">
              <div class="section">利润总额<span class="sub">(万元)</span></div>
              <div class="content">
                <div class="value"><span class="num">506943</span></div>
                <div>同比 <Trend :rate="89.4" /></div>
              </div>
            </div>
            <div class="jjxy-item">
              <Vcircle
                :size="140"
                :trail-width="4"
                :stroke-width="8"
                :percent="53.5"
                stroke-linecap="square"
                stroke-color="#43a3fb"
              >
                <div class="section">资产负债率</div>
                <div class="content">
                  <div class="value"><span class="num">53.5%</span></div>
                  <div>同比<Trend :rate="1" /></div>
                </div>
              </Vcircle>
            </div>
            <div class="jjxy-item">
              <Vcircle
                :size="140"
                :trail-width="4"
                :stroke-width="8"
                :percent="37.6"
                stroke-linecap="square"
                stroke-color="#07a485"
              >
                <div class="section">亏损企业数</div>
                <div class="content">
                  <div class="value"><span class="num">214</span></div>
                  <div>同比<Trend :rate="-19.9" /></div>
                </div>
              </Vcircle>
            </div>
          </div>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>
  </div>
</template>





<script>
import chartMixin from "@/libs/chart-mixin.js";
import * as Api from "@/api/index";
import { formatStringWrap } from "@/libs/tools.js";

export default {
  mixins: [chartMixin],
  components: {},
  data() {
    return {
      selectorText: {
        zjlZzcy: {
          zjz: "增加值及增长率",
          proportion: "增加值比重",
          comnum: "企业数量",
        },
      },
      echartInstanceList: {},
      echartChangeKey: {
        zjzGs: "month",
        zjzZzcy: "zjz",
        zbdb: "city",
        nyxf: "swl",
      },
      totalInfo: {
        zjz: {
          title: "规模以上工业增加值",
          num: 114.49,
          measure: "亿元",
          rise: 27.8,
        },
        zcz: {
          title: "规模以上工业生产总值",
          num: 484.83,
          measure: "亿元",
          rise: 29.6,
        },
      },

      zjzZzcyData: {
        total: { num: 1144935, measure: "万元", rise: 27.8 },
      },
      czZzcyData: {
        total: { num: 4848292, measure: "万元", rise: 29.6 },
      },
      czGsData: {
        total: { num: 4848292, measure: "万元", rise: 29.6 },
      },
      czXdcyData: {},
      ydlqkData: {
        total: { num: 158962, measure: "万千瓦时", rise: 27.11 },
      },
      nyxfData: {
        total: { num: 99.71, measure: "万吨标准煤", rise: 38.85 },
      },
      zjzHyData: {
        column: [
          {
            title: "指标名称",
            key: "title",
            fixed: "left",
          },
          {
            title: "公司数量",
            key: "com_num",
            sortable: true,
            width: "120",
          },
          {
            title: "总量(万元)",
            key: "jw_total",
            sortable: true,
            width: "120",
          },
          {
            title: "同比增长",
            key: "jw_rise",
            sortable: true,
            width: "120",
          },
        ],

        data: [
          {
            title: "石油和天然气开采业",
            com_num: 1,
            jw_total: 190525,
            jw_rise: 16.4,
          },
          {
            title: "农副食品加工业",
            com_num: 6,
            jw_total: 1443,
            jw_rise: -13.1,
          },
          {
            title: "食品制造业",
            com_num: 13,
            jw_total: 123137,
            jw_rise: 9.5,
          },
          {
            title: "食品制造业",
            com_num: 13,
            jw_total: 123137,
            jw_rise: 9.5,
          },
          {
            title: "酒、饮料和精制茶制造业",
            com_num: 13,
            jw_total: 123137,
            jw_rise: 9.5,
          },
          {
            title: "纺织业",
            com_num: 6,
            jw_total: 13298,
            jw_rise: -7.8,
          },
          {
            title: "纺织服装、服饰业",
            com_num: 4,
            jw_total: 6107,
            jw_rise: 22.0,
          },
          {
            title: "皮革、皮毛、羽毛及其制品和制鞋业",
            com_num: 1,
            jw_total: 744,
            jw_rise: 116.1,
          },
          {
            title: "铁路、船舶、航空航天和其他运输设备制造业",
            com_num: 17,
            jw_total: 212891,
            jw_rise: 42.7,
          },
          {
            title: "燃气生产和供应业",
            com_num: 1,
            jw_total: 239581,
            jw_rise: 33.6,
          },
          {
            title: "水的生产和供应业",
            com_num: 2,
            jw_total: 1055,
            jw_rise: -20.0,
          },
        ],
      },

      leijizengzhangDataZcz: {},
      timelineYearDataZcz: {},
    };
  },
  methods: {
    handleChangeZjzgs(e) {
      var option = {
        month: {
          title: {
            text: "近12个月累计增长速度",
            top: "top",
          },
          legend: {
            top: "bottom",
          },
          tooltip: {},
          dataset: {
            // 提供一份数据。
            source: [
              ["product", "金湾区", "金湾直属", "开发区"],
              ["2020年3月", -16.3, -17.2, -15.8],
              ["4月", -11.3, -14.5, -9.5],
              ["5月", -8.3, -13.3, -5.3],
              ["6月", -6.3, -6.3, -6.3],
              ["7月", -3.5, -2.8, -4.1],
              ["8月", -2.3, 0.3, -4.2],
              ["9月", -0.3, -3.1, -2.8],
              ["10月", 1.7, 4.9, -0.6],
              ["11月", 2.4, 4.8, 0.6],
              ["12月", 1.5, 2.5, 0.7],
              ["2月", 37.1, 43.0, 33.6],
              ["3月", 27.8, 28.6, 27.1],
            ],
          },
          // 声明一个 X 轴，类目轴（category）。默认情况下，类目轴对应到 dataset 第一列。
          xAxis: { type: "category" },
          // 声明一个 Y 轴，数值轴。
          yAxis: [
            {
              type: "value",
              axisLabel: {
                formatter: "{value}" + "%",
              },
            },
          ],
          // 声明多个 bar 系列，默认情况下，每个系列会自动对应到 dataset 的每一列。
          series: [
            {
              type: "line",
              itemStyle: {
                color: "#fdaadb",
              },
            },
            {
              type: "line",
              itemStyle: {
                color: "#a4c3fe",
              },
            },
            {
              type: "line",
              itemStyle: {
                color: "#ffcf29",
              },
            },
          ],
        },
        year: {
          title: {
            text: "近五年累计增长速度",
            top: "top",
          },
          legend: {
            top: "bottom",
          },
          tooltip: {},
          dataset: {
            // 提供一份数据。
            source: [
              ["product", "金湾直属", "开发区"],
              ["2016年", 10.4, 7.8],
              ["2017年", 12.0, 11.2],
              ["2018年", 18.0, 14.4],
              ["2019年", 4.8, 2.6],
              ["2020年", 2.5, 0.7],
            ],
          },
          // 声明一个 X 轴，类目轴（category）。默认情况下，类目轴对应到 dataset 第一列。
          xAxis: { type: "category" },
          // 声明一个 Y 轴，数值轴。
          yAxis: [
            {
              type: "value",
              axisLabel: {
                formatter: "{value}" + "%",
              },
            },
          ],
          // 声明多个 bar 系列，默认情况下，每个系列会自动对应到 dataset 的每一列。
          series: [
            {
              type: "line",
              itemStyle: {
                color: "#fdaadb",
              },
            },
            {
              type: "line",
              itemStyle: {
                color: "#a4c3fe",
              },
            },
          ],
        },
      };
      if (this.echartChangeKey.zjzGs == e) {
        console.log("图表已生成");
        return;
      }

      this.echartChangeKey.zjzGs = e;
      this.echartInstance.zjzGsChart.clear();
      this.echartInstance.zjzGsChart.setOption(option[e]);
    },
    handleChangeZjzZzcy(e) {
      var option = {
        zjz: {
          title: {
            text: "增加值及增长率",
          },
          tooltip: {},
          dataset: {
            // 提供一份数据。
            source: [
              ["生物医药", 167370, 18.7],
              ["高端打印设备", 22691, 36.9],
              ["高端精细化工", 154617, 19.0],
              ["新能源", 25864, 57.7],
              ["清洁能源", 248184, 23.9],
              ["智能家电", 87608, 40.6],
              ["船舶与海洋装备制造", 43542, 45.1],

              ["钢铁制造", 70111, 42.3],
              ["电力生产", 29889, 34.4],
              ["传统优势", 308754, 31.9],
            ],
          },
          xAxis: {
            type: "category",
            axisLabel: {
              inside: false,
              rotate: -45,
            },
          },
          yAxis: [
            {
              axisLabel: {
                formatter: function (value) {
                  return value / 1000 + "k";
                },
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
              itemStyle: {
                color: new this.$echarts.graphic.LinearGradient(0, 0, 0, 1, [
                  { offset: 0, color: "#f57fc5" },
                  { offset: 0.5, color: "#f1209f" },
                  { offset: 1, color: "#f0189b" },
                ]),
              },
            },
            {
              type: "line",
              yAxisIndex: 1,
              itemStyle: {
                color: "#ffcf29",
              },
            },
          ],
        },
        proportion: {
          title: {
            text: "增加值比重情况",
          },
          tooltip: {
            formatter: "{b0}: {c0}<br />{b1}: {c1}",
          },
          dataset: {
            // 提供一份数据。
            source: [
              ["生物医药", 14.4, 18.7],
              ["高端打印设备", 2.0, 36.9],
              ["高端精细化工", 13.3, 19.0],
              ["新能源", 2.2, 57.7],
              ["清洁能源", 21.4, 23.9],
              ["智能家电", 7.6, 40.6],
              ["船舶与海洋装备制造", 3.8, 45.1],

              ["钢铁制造", 6.1, 42.3],
              ["电力生产", 2.6, 34.4],
              ["传统优势", 26.6, 31.9],
            ],
          },

          series: [
            {
              type: "pie",
              radius: ["20%", "50%"],
              emphasis: {
                itemStyle: {
                  shadowBlur: 10,
                  shadowOffsetX: 0,
                  shadowColor: "rgba(0, 0, 0, 0.5)",
                },
              },
              label: {
                show: true,
                position: "top",
                color: "#fff",
              },
            },
          ],
        },
        comnum: {
          title: {
            text: "企业数量",
          },
          tooltip: {
            show: false,
          },
          dataset: {
            // 提供一份数据。
            source: [
              ["生物医药", 24],
              ["高端打印设备", 31],
              ["高端精细化工", 76],
              ["新能源", 23],
              ["清洁能源", 9],
              ["智能家电", 94],
              ["船舶与海洋装备制造", 13],

              ["钢铁制造", 1],
              ["电力生产", 3],
              ["传统优势", 293],
            ],
          },
          xAxis: {
            type: "category",
            axisLabel: {
              inside: false,
              rotate: -45,
            },
          },
          yAxis: [
            {
              type: "value",
            },
          ],
          series: [
            {
              type: "bar",
              barWidth: 30,
              label: {
                show: true,
                position: "top",
                color: "#fff",
              },
              itemStyle: {
                color: {
                  x: 0,
                  y: 0,
                  x2: 0,
                  y2: 1,
                  type: "linear",
                  global: false,
                  colorStops: [
                    {
                      offset: 0,
                      color: "#0577e0",
                    },
                    {
                      offset: 1,
                      color: "#63caff",
                    },
                  ],
                },
              },
            },

            {
              data: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
              type: "pictorialBar",
              barMaxWidth: "20",
              symbol: "diamond",
              symbolOffset: [0, "50%"],
              symbolSize: [30, 15],
              itemStyle: {
                color: "#63caff",
              },
            },
            {
              type: "pictorialBar",
              barMaxWidth: "20",
              symbolPosition: "end",
              symbol: "diamond",
              symbolOffset: [0, "-50%"],
              symbolSize: [30, 12],
              zlevel: 2,
              itemStyle: {
                color: "#63caff",
              },
            },
          ],
        },
      };
      if (this.echartChangeKey.zjzZzcy == e) {
        console.log("图表已生成");
        return;
      }
      this.echartChangeKey.zjzZzcy = e;
      this.echartInstance.zjzZzcyChart.clear();
      this.echartInstance.zjzZzcyChart.setOption(option[e]);
    },
    handleChangeZbdb(e) {
      console.log(e);
      var option = {
        city: {
          title: {
            text: "各区规模以上工业增加值对比",
            top: "top",
          },
          legend: {
            top: "bottom",
          },
          tooltip: {},
          dataset: {
            // 提供一份数据。
            source: [
              ["product", "工业增加值", "同比增长"],
              ["横琴新区", 14.25, 14.0, 4.9],
              ["香洲区", 92.24, 56.6, 31.9],
              ["金湾区", 114.49, 27.8, 39.6],
              ["斗门区", 42.63, 30.8, 14.8],
              ["高新区", 25.16, 59.7, 8.7],
            ],
          },
          // 声明一个 X 轴，类目轴（category）。默认情况下，类目轴对应到 dataset 第一列。
          xAxis: { type: "category" },
          // 声明一个 Y 轴，数值轴。
          yAxis: [
            {
              type: "value",
              axisLabel: {
                formatter: "{value}" + "亿",
              },
            },
            {
              type: "value",
              axisLabel: {
                formatter: "{value}" + "%",
              },
            },
          ],
          // 声明多个 bar 系列，默认情况下，每个系列会自动对应到 dataset 的每一列。
          series: [
            {
              type: "bar",
              barMaxWidth: 16,
              itemStyle: {
                color: "#fdaadb",
              },
            },

            {
              type: "line",
              itemStyle: {
                color: "#ffcf29",
              },
            },
          ],
        },
        country: {
          title: {
            text: "与国内其他区域对比",
            subText: "(规模以上工业)",
            top: "top",
          },
          legend: {
            top: "bottom",
          },
          tooltip: {},
          dataset: {
            // 提供一份数据。
            source: [
              [
                "product",
                "工业总产值",
                "总产值同比增长",
                "工业增加值",
                "增加值同比增长",
              ],
              ["金湾区", 304.38, 36.9, 71.92, 37.1],
              ["苏州工业园", 836, 52.5, 31.9, 42.3],
              ["深证龙岗区", 1124.49, 27.8, 139.6, 23.8],
            ],
          },
          // 声明一个 X 轴，类目轴（category）。默认情况下，类目轴对应到 dataset 第一列。
          xAxis: { type: "category" },
          // 声明一个 Y 轴，数值轴。
          yAxis: [
            {
              type: "value",
              axisLabel: {
                formatter: "{value}" + "亿",
              },
            },
            {
              type: "value",
              axisLabel: {
                formatter: "{value}" + "%",
              },
            },
          ],
          // 声明多个 bar 系列，默认情况下，每个系列会自动对应到 dataset 的每一列。
          series: [
            {
              type: "bar",
              barMaxWidth: 16,
            },

            {
              type: "line",
              yAxisIndex: 1,
              itemStyle: {
                color: "#ffcf29",
              },
            },
            {
              type: "bar",
              barMaxWidth: 16,
            },

            {
              type: "line",
              yAxisIndex: 1,
            },
          ],
        },
      };
      if (this.echartChangeKey.zbdb == e) {
        console.log("图表已生成");
        return;
      }
      this.echartChangeKey.zbdb = e;
      this.echartInstance.zbdbChart.clear();
      this.echartInstance.zbdbChart.setOption(option[e]);
    },
    handleChangeNyxf(e) {
      console.log(e);
      if (this.echartChangeKey.nyxf == e) {
        return;
      }
      var nyxfData = {
        swl: {
          column: [
            {
              title: "实物量(当量值)",
              key: "title",
              width: "160",
              fixed: "left",
            },
            {
              title: "计量单位",
              key: "measure",
              width: "120",
            },
            {
              title: "总量",
              key: "jw_total",
              sortable: true,
              width: "120",
            },
            {
              title: "同比增长",
              key: "jw_rise",
              sortable: true,
              width: "120",
            },
          ],

          data: [
            {
              title: "原煤",
              measure: "吨",
              jw_total: 1258917,
              jw_rise: 47.3,
            },
            {
              title: "焦炭",
              measure: "吨",
              jw_total: 352495,
              jw_rise: 52.9,
            },
            {
              title: "高炉煤气",
              measure: "吨",
              jw_total: 159424,
              jw_rise: 53.5,
            },
            {
              title: "转炉煤气",
              measure: "万立方米",
              jw_total: 11769,
              jw_rise: 23.3,
            },
            {
              title: "天然气",
              measure: "万立方米",
              jw_total: 40331,
              jw_rise: 73.0,
            },
            {
              title: "液化天然气",
              measure: "万立方米",
              jw_total: 6135,
              jw_rise: 21.3,
            },
            {
              title: "汽油",
              measure: "吨",
              jw_total: 594,
              jw_rise: -18.1,
            },
          ],
        },
        bzl: {
          column: [
            {
              title: "标准量(吨标准煤,当量值)",
              key: "title",
              width: "160",
              fixed: "left",
            },
            {
              title: "总量",
              key: "jw_total",
              sortable: true,
              width: "120",
            },
            {
              title: "同比增长",
              key: "jw_rise",
              sortable: true,
              width: "120",
            },
          ],

          data: [
            {
              title: "原煤",
              jw_total: 1258917,
              jw_rise: 47.3,
            },
            {
              title: "焦炭",
              jw_total: 352495,
              jw_rise: 52.9,
            },
            {
              title: "高炉煤气",
              jw_total: 159424,
              jw_rise: 53.5,
            },
            {
              title: "转炉煤气",
              jw_total: 11769,
              jw_rise: 23.3,
            },
            {
              title: "天然气",
              jw_total: 40331,
              jw_rise: 73.0,
            },
            {
              title: "液化天然气",
              jw_total: 6135,
              jw_rise: 21.3,
            },
            {
              title: "汽油",
              jw_total: 594,
              jw_rise: -18.1,
            },
          ],
        },
      };
      this.nyxfData = nyxfData[e];
      this.echartChangeKey.nyxf = e;
    },
  },
  mounted() {
    const chartTextColor = "rgba(255, 255, 255, 1)";
    const chartTitleStyle = {
      left: "center",
      textStyle: {
        fontWeight: "normal",
        fontSize: "16px",
      },
      textAlign: "auto",
    };

    var chartName = [];
    // var chartName = ["financeincome", "financeexpend"];
    this.chartInit({ chartName });

    /***各区指标对比 */
    Api.jjzb.get_county({ params: { cate: "financeincome" } }).then((res) => {
      this.compareCountyData = {
        mode: "gross",
        title: {},
        data: res.data,
      };
    });

    // 累计临时数据
    let source = [
      ["product", "金湾区", "金湾直属", "开发区"],
      ["2020年3月", -16.3, -17.2, -15.8],
      ["4月", -11.3, -14.5, -9.5],
      ["5月", -8.3, -13.3, -5.3],
      ["6月", -6.3, -6.3, -6.3],
      ["7月", -3.5, -2.8, -4.1],
      ["8月", -2.3, 0.3, -4.2],
      ["9月", -0.3, -3.1, -2.8],
      ["10月", 1.7, 4.9, -0.6],
      ["11月", 2.4, 4.8, 0.6],
      ["12月", 1.5, 2.5, 0.7],
      ["2月", 37.1, 43.0, 33.6],
      ["3月", 27.8, 28.6, 27.1],
    ];
    /***按月 累计增长率*/
    Api.timeline.get_monthdata().then((res) => {
      this.leijizengzhangData = {
        title: {
          text: "2020年3-2021年3月",
        },
        data: source,
        // data: res.data,
      };
    });

    /***按月 累计增长率 支出*/
    Api.timeline.get_monthdata({ params: { cate: "dynamic" } }).then((res) => {
      this.leijizengzhangDataZcz = {
        title: {
          text: "2020年3-2021年3月",
        },
        data: source,
        // data: res.data,
      };
    });

    /*** 年度数据收入 */
    Api.timeline.get_yeardata().then((res) => {
      this.timelineYearData = {
        mode: "gross",
        title: {
          text: res.title || "",
        },
        data: res.data,
      };
    });

    /*** 年度数据支出 */
    Api.timeline.get_yeardata().then((res) => {
      this.timelineYearDataZcz = {
        mode: "gross",
        title: {
          text: res.title || "",
        },
        data: res.data,
      };
    });

    /**
     *
     */

    /**生产总值图表实例配置 */

    /**用电量情况图表实例配置 */
  },
};
</script>

<style lang="less" scoped>
.content-wrap {
}

.chart-box {
  width: 100%;
  height: 300px;
}

.jjxy-wrap {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  color: rgba(255, 255, 255, 0.8);
  .jjxy-item {
    margin-bottom: 12px;
    width: 48%;
  }
}
.jjxy-wrap .value {
  padding: 6px 0;
}
.jjxy-wrap .num {
  font-size: 24px;
  color: #fff;
}

/** */

.banner-box {
  height: 600px;
}

.demo-Circle-custom {
  & h1 {
    color: #3f414d;
    font-size: 28px;
    font-weight: normal;
  }
  & p {
    color: #657180;
    font-size: 14px;
    margin: 10px 0 15px;
  }
  & span {
    display: block;
    padding-top: 15px;
    color: #657180;
    font-size: 14px;
    &:before {
      content: "";
      display: block;
      width: 50px;
      height: 1px;
      margin: 0 auto;
      background: #e0e3e6;
      position: relative;
      top: -15px;
    }
  }
  & span i {
    font-style: normal;
    color: #3f414d;
  }
}
</style>