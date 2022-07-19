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
        <ModuleCard :title="'重点支柱产业' + cardTitle" class="item-wrap">
          <ChartPillarCate
            :height="240"
            :chart-data="zhizhuchanyeData"
          ></ChartPillarCate>
        </ModuleCard>
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
      </div>
      <div class="bt-shadow"></div>
    </div>

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
              'child-nav-item-active': economyTitle == '规模以上工业增加值',
            }"
            @click="hangdleChangeTitle('规模以上工业增加值')"
          >
            <div class="nav-name">工业增加值</div>
          </div>
          <div
            class="child-nav-item"
            :class="{
              'child-nav-item-active': economyTitle == '规模以上工业总产值',
            }"
            @click="hangdleChangeTitle('规模以上工业总产值')"
          >
            <div class="nav-name">工业总产值</div>
          </div>
          <!-- <router-link :to="{ name: 'gongye_ny' }" class="child-nav-item">
            <div class="nav-name">能源消费及用电量</div>
          </router-link> -->
        </div>
      </div>
    </div>

    <!-- 工业生产总值 -->
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
            :height="240"
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
        <ModuleCard
          :title="'现代产业和规上民营企业' + cardTitle"
          class="item-wrap"
        >
          <ChartMingying
            :height="220"
            :chart-data="mingyingData"
          ></ChartMingying>
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
import ChartPillarCate from "./components/chart-zdzzcy.vue";
import ChartMingying from "./components/chart-xdmy.vue";
export default {
  mixins: [chartMixin],
  components: { ChartPillarCate, ChartMingying },
  data() {
    return {
      cardTitle: "规上工业增加值",
      economyTitle: "规模以上工业增加值",
      cateName: "zjz",
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
      zhizhuchanyeData: [],
      mingyingData: [],
    };
  },
  methods: {
    hangdleChangeTitle(title) {
      this.economyTitle = title;
      this.cateName = title == "规模以上工业增加值" ? "zjz" : "zcz";
      this.cardTitle =
        title == "规模以上工业增加值" ? "规上工业增加值" : "规上工业总产值";
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

      /*** 重点支柱产业 */
      Api.base.get_pillar({ params: { cate: this.cateName } }).then((res) => {
        this.zhizhuchanyeData = this.$formatTableToChart(
          res.data.list,
          res.data.columns
        );
      });

      /*** 现代产业及民营企业 */
      Api.base
        .get_industry_xdmy({ params: { cate: this.cateName } })
        .then((res) => {
          this.mingyingData = this.$formatTableToChart(
            res.data.list,
            res.data.columns
          );
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