<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:50:57
 * @LastEditTime: 2021-05-30 10:46:30
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="row-side side-left">
      <div class="transform-box">
        <ModuleCard title="固定资产投资近一年累计增速" class="item-wrap">
          <ChartMonth
            :height="220"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard title="固定资产投资近五年情况" class="item-wrap">
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeYearMode('gross')"
                >总额</Button
              >
              <Button @click="handleChangeYearMode('rise')">增速</Button>
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
          <div id="chart-cate" class="chart-base"></div>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>
    <div class="row-big">
      <TownMap :total-info="townTotalInfo"></TownMap>
      <div class="item-wrap">
        <div class="l-row l-row-bt">
          <EffectCircleCount3D :data="totalInfo.jw"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.zs"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.kfq"></EffectCircleCount3D>
        </div>
      </div>
    </div>
    <div class="row-side side-right">
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
            :height="516"
            :is-open="true"
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
      townTotalInfo: {},
      totalInfo: {
        jw: {
          title: "金湾区",
          num: 0,
          measure: "亿元",
          rise: "0",
        },
        zs: {
          title: "直属",
          num: 0,
          measure: "亿元",
          rise: "0",
        },
        kfq: {
          title: "开发区",
          num: 0,
          measure: "亿元",
          rise: "0",
        },
      },
      key: "value",
    };
  },
  methods: {},
  mounted() {
    var chartName = ["cate"];
    this.chartInit({ chartName });

    Api.base.get_total({ cate: "全社会固定资产投资" }).then((res) => {
      this.totalInfo = res.data;
    });
    // 各镇指标
    Api.jjzb
      .get_town({ params: { cate: "全社会固定资产投资" } })
      .then((res) => {
        this.townTotalInfo = res.data;
      });

    /***指标对比 */
    Api.jjzb.get_county({ params: { cate: "固定资产投资额" } }).then((res) => {
      this.compareCountyData = {
        mode: "gross",
        title: {},
        data: this.$formatTableToChart(res.data.list, res.data.columns),
      };
    });

    /*** 国内部分区域指标 */
    Api.jjzb
      .get_domestic({ params: { cate: "固定资产投资额" } })
      .then((res) => {
        this.compareDomesticData = {
          title: {
            text: res.data.title,
          },
          data: this.$formatTableToChart(res.data.list, res.data.columns),
        };
      });

    /***按月 累计增长率 */
    Api.timeline
      .get_monthdata({ params: { cate: "固定资产投资" } })
      .then((res) => {
        this.leijizengzhangData = {
          title: {
            text: "近一年",
          },
          data: this.$formatTableToChart(res.data.list, res.data.columns),
        };
      });

    /*** 年度数据 */
    Api.timeline
      .get_yeardata({ params: { cate: "固定资产投资" } })
      .then((res) => {
        this.timelineYearData = {
          title: {
            text: this.title || "近五年",
          },
          mode: "gross",
          data: this.$formatTableToChart(res.data.list, res.data.columns),
          origin: this.$formatTableToChart(res.data.list, res.data.columns),
        };
      });

    // 基本指标
    /*** 按类别固定资产投资完成情况 */
    Api.base.get_investment({ params: { cate: "2" } }).then((res) => {
      var opt = {
        title: {
          text: "",
        },
        dataset: {
          source: this.$formatTableToChart(res.data.list, res.data.columns),
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        grid: {
          left: 60,
          right: 40,
          bottom: 60,
        },

        xAxis: {
          type: "category",
          axisLabel: {
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
                return value;
              },
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
            lineStyle: {
              color: "#59fedd",
            },
            itemStyle: {
              color: "#59fedd",
            },
          },
        ],
      };
      this.echartInstance["cate"].setOption(opt);
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
