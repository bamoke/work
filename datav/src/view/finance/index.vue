<!--
 * @Author: Joy wang
 * @Date: 2021-05-19 04:41:13
 * @LastEditTime: 2021-06-01 06:22:05
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="row-side side-left">
      <div class="transform-box">
        <ModuleCard :title="cardTitle + '近一年累计增速'" class="item-wrap">
          <ChartMonth
            :height="220"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard :title="cardTitle + '近五年情况'" class="item-wrap">
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeYearMode('gross')"
                >总量</Button
              >
              <Button @click="handleChangeYearMode('rise')">增速</Button>
            </ButtonGroup>
          </template>
          <ChartYear
            :height="220"
            :title="timelineYearData.title"
            :mode="timelineYearData.mode"
            :chart-data="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
        <ModuleCard :title="cateCardTitle" class="item-wrap">
          <ChartCate :height="220" :chart-data="cateData"></ChartCate>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>

    <!--middle--->
    <div class="row-big">
      <TownMap :total-info="townTotalInfo"></TownMap>
        <div class="l-row l-row-bt">
          <EffectCircleCount3D :data="totalInfo.jw"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.zs"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.kfq"></EffectCircleCount3D>
        </div>
      <div class="item-wrap">
        <div class="m-child-nav-box">
          <div
            class="child-nav-item"
            :class="{
              'child-nav-item-active': economyTitle == '一般公共预算收入',
            }"
            @click="hangdleChangeTitle('一般公共预算收入')"
          >
            <div class="nav-name">一般公共预算收入</div>
          </div>
          <div
            class="child-nav-item"
            :class="{
              'child-nav-item-active': economyTitle == '一般公共预算支出',
            }"
            @click="hangdleChangeTitle('一般公共预算支出')"
          >
            <div class="nav-name">一般公共预算支出</div>
          </div>
          <!-- <router-link :to="{ name: 'gongye_ny' }" class="child-nav-item">
            <div class="nav-name">能源消费及用电量</div>
          </router-link> -->
        </div>
      </div>
    </div>

    <!-- side -->
    <div class="row-side side-right">
      <div class="transform-box">
        <ModuleCard :title="'各区' + cardTitle + '比较'" class="item-wrap">
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeCompareCounty('gross')"
                >占比</Button
              >
              <Button @click="handleChangeCompareCounty('rise')">增速</Button>
            </ButtonGroup>
          </template>
          <ChartCompareCounty
            :height="520"
            :is-open="true"
            :mode="compareCountyData.mode"
            :title="compareCountyData.title"
            :chart-data="compareCountyData.data"
          ></ChartCompareCounty>
        </ModuleCard>
        <ModuleCard
          :title="'国内其他区域' + cardTitle + '比较'"
          class="item-wrap"
        >
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
import ChartCate from "./components/chart-cate.vue";
export default {
  mixins: [chartMixin],
  components: {
    ChartCate,
  },
  data() {
    return {
      cardTitle: "一般公共预算收入",
      economyTitle: "一般公共预算收入",
      cateName: "税收收入",
      cateCardTitle: "税收收入情况",
      townTotalInfo: {},
      totalInfo: {
        jw: {
          title: "金湾区",
          gross: 0,
          measure: "亿元",
          rise: "0",
        },
        zs: {
          title: "直属",
          gross: 0,
          measure: "亿元",
          rise: "0",
        },
        kfq: {
          title: "开发区",
          gross: 0,
          measure: "亿元",
          rise: "0",
        },
      },
      cateData: [],
    };
  },
  methods: {
    hangdleChangeTitle(title) {
      this.economyTitle = this.cardTitle = title;
      this.cateName = title == "一般公共预算收入" ? "税收收入" : "支出";
      this.cateCardTitle =
        title == "一般公共预算收入" ? "税收收入情况" : "民生支出情况";
      this.loadData();
    },
    loadData() {
      /***total */
      Api.base.get_total({ cate: this.economyTitle }).then((res) => {
        this.totalInfo = res.data;
      });

      // 各镇指标
      Api.jjzb.get_town({ params: { cate: this.economyTitle } }).then((res) => {
        this.townTotalInfo = res.data;
        this.townTotalInfo.integer = true;
      });

      /***各区指标对比 */
      Api.jjzb
        .get_county({ params: { cate: this.economyTitle } })
        .then((res) => {
          this.compareCountyData = {
            mode: "gross",
            title: {},
            data: this.$formatTableToChart(res.data.list, res.data.columns),
          };
        });

      /*** 国内部分区域指标 */
      Api.jjzb
        .get_domestic({ params: { cate: this.economyTitle } })
        .then((res) => {
          this.compareDomesticData = {
            title: {
              text: res.data.title,
            },
            data: this.$formatTableToChart(res.data.list, res.data.columns),
          };
        });

      /***按月 累计增长率*/
      Api.timeline
        .get_monthdata({ params: { cate: this.economyTitle } })
        .then((res) => {
          this.leijizengzhangData = {
            title: {
              text: "",
            },
            data: this.$formatTableToChart(res.data.list, res.data.columns),
          };
        });

      /*** 年度数据收入 */
      Api.timeline
        .get_yeardata({ params: { cate: this.economyTitle } })
        .then((res) => {
          this.timelineYearData = {
            mode: "gross",
            title: {
              text: res.data.title || "",
            },
            data: this.$formatTableToChart(res.data.list, res.data.columns),
          };
        });

      /*** 按类别 */
      Api.base.get_finance({ params: { cate: this.cateName } }).then((res) => {
        this.cateData = this.$formatTableToChart(
          res.data.list,
          res.data.columns
        );
        console.log(this.cateData);
      });
    },
  },
  mounted() {
    var chartName = [];
    // var chartName = ["financeincome", "financeexpend"];
    this.chartInit({ chartName });
    this.loadData();
  },
};
</script>

<style lang="less" scoped>
.banner-box {
  height: 680px;
}
.base-height {
  height: 160px;
}
</style>
