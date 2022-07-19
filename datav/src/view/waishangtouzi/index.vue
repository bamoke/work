<!--
 * @Author: Joy wang
 * @Date: 2021-05-19 04:41:13
 * @LastEditTime: 2021-06-02 04:36:28
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="row-side">
      <div class="transform-box">
        <ModuleCard title="累计增长速度" class="item-wrap">
          <ChartMonth
            :height="200"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard title="近五年总额及增长率" class="item-wrap">
          <ChartYear
            :height="500"
            :is-open="true"
            :title="timelineYearData.title"
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
          <EffectCircleCount3D :data="totalInfo.all"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.zhishu"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.kaifaqu"></EffectCircleCount3D>
        </div>
      </div>
    </div>
    <div class="row-side">
      <div class="transform-box">
        <ModuleCard title="各区实际吸收外商直接投资比较" class="item-wrap">
          <ChartCompareCounty
            :height="500"
            :is-open="true"
            :title="compareCountyData.title"
            :chart-data="compareCountyData.data"
          ></ChartCompareCounty>
        </ModuleCard>

        <ModuleCard title="国内其他区域比较" class="item-wrap">
          <ChartCompareDomestic
            :height="200"
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
      totalInfo: {
        all: {
          title: "金湾区",
          num: 2603,
          measure: "万美元",
          rise: 154.2,
        },
        zhishu: {
          title: "金湾直属",
          num: 0,
          measure: "万美元",
          rise: -100,
        },
        kaifaqu: {
          title: "开发区",
          num: 2603,
          measure: "万美元",
          rise: 846.5,
        },
      },
    };
  },
  methods: {
    name() {},
  },
  mounted() {
    var chartName = [];
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
      this.compareDomesticData = {
        mode: "gross",
        title: {
          text: res.title,
        },
        data: res.data,
      };
    });

    /***按月 累计增长率 */
    Api.timeline.get_monthdata().then((res) => {
      this.leijizengzhangData = {
        title: { text: res.title },
        data: res.data,
      };
    });

    /*** 年度数据 */
    Api.timeline.get_yeardata().then((res) => {
      this.timelineYearData = {
        mode: "gross",
        title: { text: res.title },
        data: res.data,
        origin: res,
      };
    });
  },
};
</script>

<style lang="less" scoped>
.content-wrap {
  // background-image: url("../../assets/images/bg-xiaofei.jpg");
}
.banner-box {
  height: 680px;
}
</style>
