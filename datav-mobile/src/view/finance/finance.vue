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
        <ModuleCard title="各区一般公共预算收入比较" class="item-wrap">
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeCompareCounty('gross')"
                >总量</Button
              >
              <Button @click="handleChangeCompareCounty('rise')">增长率</Button>
            </ButtonGroup>
          </template>
          <ChartCompareCounty
            :height="200"
            :mode="compareCountyData.mode"
            :title="compareCountyData.title"
            :chart-data="compareCountyData.data"
          ></ChartCompareCounty>
        </ModuleCard>
        <ModuleCard title="一般公共预算收入累计增长速度" class="item-wrap">
          <ChartMonth
            :height="200"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard
          title="一般公共预算收入近五年总额及增长率"
          class="item-wrap"
        >
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeYearMode('gross')"
                >总值</Button
              >
              <Button @click="handleChangeYearMode('rise')">增长率</Button>
            </ButtonGroup>
          </template>
          <ChartYear
            :height="200"
            :title="timelineYearData.title"
            :mode="timelineYearData.mode"
            :chart-data="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>
    <div class="row-big">
      <div class="banner-box"></div>
      <div class="item-wrap">
        <div class="l-row l-row-bt">
          <EffectCircleCount3D :data="totalInfo.income"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.expend"></EffectCircleCount3D>
        </div>
      </div>

        <div class="item-wrap">
          <div class="m-child-nav-box">
            <router-link :to="{ name: 'finance_income' }" class="child-nav-item">
              <div class="nav-name">一般公共预算收入情况</div>
            </router-link>
            <router-link :to="{ name: 'finance_expend' }" class="child-nav-item">
              <div class="nav-name">一般公共预算支出情况</div>
            </router-link>
          </div>
        </div>


    </div>

    <!-- side -->
    <div class="row-side side-right">
      <div class="transform-box">
        <ModuleCard title="各区一般公共预算支出比较" class="item-wrap">
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button
                type="primary"
                @click="
                  handleChangeCompareCounty('gross', 'compareCountyDataExpend')
                "
                >总量</Button
              >
              <Button
                @click="
                  handleChangeCompareCounty('rise', 'compareCountyDataExpend')
                "
                >增长率</Button
              >
            </ButtonGroup>
          </template>
          <ChartCompareCounty
            :height="200"
            chart-id="chart-compare-county-expend"
            :mode="compareCountyDataExpend.mode"
            :title="compareCountyDataExpend.title"
            :chart-data="compareCountyDataExpend.data"
          ></ChartCompareCounty>
        </ModuleCard>

        <ModuleCard title="一般公共预算支出累计增长速度" class="item-wrap">
          <ChartMonth
            chart-id="chart-leijizengzhangexpend"
            :height="200"
            :title="leijizengzhangDataExpend.title"
            :chart-data="leijizengzhangDataExpend.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard
          title="一般公共预算支出近五年总额及增长率"
          class="item-wrap"
        >
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button
                type="primary"
                @click="handleChangeYearMode('gross', 'timelineYearDataExpend')"
                >总值</Button
              >
              <Button
                @click="handleChangeYearMode('rise', 'timelineYearDataExpend')"
                >增长率</Button
              >
            </ButtonGroup>
          </template>
          <ChartYear
            chart-id="chart-timelineyearexpend"
            :height="200"
            :title="timelineYearDataExpend.title"
            :mode="timelineYearDataExpend.mode"
            :chart-data="timelineYearDataExpend.data"
          ></ChartYear>
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
        income: {
          title: "一般公共预算收入",
          num: 11.48,
          measure: "亿元",
          rise: 0.7,
        },
        expend: {
          title: "一般公共预算支出",
          num: 26.96,
          measure: "亿元",
          rise: 50.6,
        },
      },
      compareCountyDataExpend: {},
      timelineYearDataExpend: {},
      leijizengzhangDataExpend:{}
    };
  },
  methods: {
    name() {},
  },
  mounted() {
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

    /***各区指标对比 */
    Api.jjzb.get_county({ params: { cate: "financeexpend" } }).then((res) => {
      this.compareCountyDataExpend = {
        mode: "gross",
        title: {},
        data: res.data,
      };
    });

    /*** 国内部分区域指标 */
    Api.jjzb.get_domestic().then((res) => {
      this.compareDomesticData = res.data;
    });

    /***按月 累计增长率 收入*/
    Api.timeline.get_monthdata().then((res) => {
      this.leijizengzhangData = {
        title: {
          text: "2020年3-2021年3月",
        },
        data: res.data,
      };
    });

        /***按月 累计增长率 支出*/
    Api.timeline.get_monthdata({params:{cate:'dynamic'}}).then((res) => {
      this.leijizengzhangDataExpend = {
        title: {
          text: "2020年3-2021年3月",
        },
        data: res.data,
      };
    });

    /*** 年度数据收入 */
    Api.timeline
      .get_yeardata({ params: { cate: "financeincome" } })
      .then((res) => {
        this.timelineYearData = {
          mode: "gross",
          title: {
            text: res.title || "",
          },
          data: res.data,
        };
      });

    /*** 年度数据支出 */
    Api.timeline
      .get_yeardata({ params: { cate: "financeexpend" } })
      .then((res) => {
        this.timelineYearDataExpend = {
          mode: "gross",
          title: {
            text: res.title || "",
          },
          data: res.data,
        };
      });
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
