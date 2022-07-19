<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:50:57
 * @LastEditTime: 2021-05-30 10:46:30
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
<<<<<<< HEAD
    <div class="row-side">
=======
    <div class="row-side side-left">
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
      <div class="transform-box">
        <ModuleCard title="固定资产投资总额累计增长速度" class="item-wrap">
          <ChartMonth
            :height="220"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
<<<<<<< HEAD
        <ModuleCard title="近五年固定资产投资总额及增长率" class="item-wrap">
=======
        <ModuleCard title="固定资产投资总额及增长率" class="item-wrap">
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeYearMode('gross')"
                >总额</Button
              >
              <Button @click="handleChangeYearMode('rise')">增长率</Button>
            </ButtonGroup>
          </template>
          <ChartYear
            :height="220"
            :mode="timelineYearData.mode"
            :title="timelineYearData.title"
            :chart-data="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
        <ModuleCard title="固定资产投资结构情况" class="item-wrap">
          <div id="chart-basegross" class="chart-base"></div>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>
    <div class="row-big">
      <div class="banner-box"></div>
      <div class="item-wrap">
        <div class="l-row l-row-bt">
          <EffectCircleCount3D :data="totalInfo.all"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.zhishu"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.kaifaqu"></EffectCircleCount3D>
        </div>
      </div>
    </div>
<<<<<<< HEAD
    <div class="row-side">
=======
    <div class="row-side side-right">
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
      <div class="transform-box">
        <ModuleCard title="全区固定资产投资比较" class="item-wrap">
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeCompareCounty('gross')"
                >总值</Button
              >
              <Button @click="handleChangeCompareCounty('rise')">增长率</Button>
            </ButtonGroup>
          </template>
          <ChartCompareCounty
            :height="220"
            :mode="compareCountyData.mode"
            :title="compareCountyData.title"
            :chart-data="compareCountyData.data"
          ></ChartCompareCounty>
        </ModuleCard>
        <ModuleCard title="国内其他区域比较" class="item-wrap">
          <ChartCompareDomestic
            :height="220"
            :title="compareDomesticData.title"
            :chart-data="compareDomesticData.data"
          ></ChartCompareDomestic>
        </ModuleCard>
        <ModuleCard title="固定资产投资增长率" class="item-wrap">
          <div id="chart-baserise" class="chart-base"></div>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import { formatStringWrap } from "@/libs/tools.js";
import chartMixin from "@/libs/chart-mixin.js";
export default {
  mixins: [chartMixin],
  data() {
    return {
      totalInfo: {
        all: {
          title: "金湾区",
          num: 131.41,
          measure: "亿元",
          rise: 41.6,
        },
        zhishu: {
          title: "直属区",
          num: 97.76,
          measure: "亿元",
          rise: 66.7,
        },
        kaifaqu: {
          title: "经济开发区",
          num: 33.65,
          measure: "亿元",
          rise: -1.5,
        },
      },
      key: "value",
    };
  },
  methods: {
    handleChangeCate(e) {
      console.log(e);
    },
    handleChangeRise(e) {
      console.log(e);
    },
    handleChangeYear(e) {
      console.log(e);
    },

    handleShowMonitor(index) {
      console.log(index);
    },
  },
  mounted() {
    var chartName = ["basegross", "baserise"];
    this.chartInit({ chartName });

    /***指标对比 */
    Api.jjzb.get_county().then((res) => {
      this.compareCountyData = {
        mode: "gross",
        title: {},
        data: res.data,
      };
    });

    /*** 国内部分区域指标 */
    Api.jjzb.get_domestic().then((res) => {
      this.compareDomesticData = res;
    });

    /***按月 累计增长率 */
    Api.timeline.get_monthdata().then((res) => {
      this.leijizengzhangData = {
        title: {
<<<<<<< HEAD
          text: "2020年3-2021年3月",
=======
          text: "近一年",
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
        },
        data: res.data,
      };
    });

    /*** 年度数据 */
    Api.timeline
      .get_yeardata({ params: { cate: "investment" } })
      .then((res) => {
        this.timelineYearData = {
          title: {
<<<<<<< HEAD
            text: this.title,
=======
            text: this.title || "近五年",
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
          },
          mode:"gross",
          data: res.data,
          origin: res,
        };
      });

    // 各镇指标
    Api.jjzb.get_town().then((res) => {
      var chartData = res.data;
      //   chartData.unshift(["pruduct", "总量", "增长"]);
    });

    // 基本指标
    Api.base.get_gdzctz().then((res) => {
      var chartGrossData = res.data.gross;
      var chartRiseData = res.data.rise;
      this.echartInstance.basegross.setOption({
        dataset: { source: chartGrossData },
        title: {
          text: "",
          subtext: "",
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
<<<<<<< HEAD
          left: "center",
=======
          left: "right",
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
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
<<<<<<< HEAD
            name: "投资总量(亿)",
=======
            name: "",
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
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
          },
          {
            type: "bar",
            showBackground: true,
          },
          {
            type: "bar",
            showBackground: true,
          },
        ],
      });
      this.echartInstance.baserise.setOption({
        dataset: { source: chartRiseData },
        title: {
          text: "",
          subtext: "",
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
<<<<<<< HEAD
          left: "center",
=======
          left: "right",
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
          //   top: "bottom",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            formatter: function (value) {
              return formatStringWrap(value, 4);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            name: "同比增长",
            axisLabel: {
              formatter: "{value}%",
            },
            splitLine: {
              show: true,
            },
          },
        ],
        series: [
          {
            type: "line",
          },
          {
            type: "line",
          },
          {
            type: "line",
          },
        ],
      });
      //////////////
    });
  },
};
</script>

<style lang="less" scoped>
.m-total-unit .info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #fff;
}
.banner-box {
  height: 680px;
}
.item-wrap {
  margin-bottom: 0.083333rem;
}

.chart-base {
  height: 220px;
}
</style>
