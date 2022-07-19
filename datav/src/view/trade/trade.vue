<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:50:57
 * @LastEditTime: 2021-06-01 03:03:07
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="row-side">
      <div class="transform-box">
        <ModuleCard title="累计增长速度" class="item-wrap">
          <template v-slot:extra>
            <ButtonGroup size="small">
              <Button type="primary" @click="handleChangeRise('default')"
                >外贸进出口</Button
              >
              <Button @click="handleChangeRise('dynamic')">外贸出口</Button>
            </ButtonGroup>
          </template>
          <ChartMonth
            :height="200"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard title="外贸进出口近五年总额及增长率" class="item-wrap">
          <ChartYear
            :height="500"
            :is-open="true"
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
          <EffectCircleCount3D :data="totalInfo.all"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.zhishu"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.kaifaqu"></EffectCircleCount3D>
        </div>
      </div>

    </div>
    <div class="row-side">
      <div class="transform-box">
        <ModuleCard title="各区外贸进出口比较" class="item-wrap">
          <ChartCompareCounty
            :height="500"
            :is-open="true"
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
  components: {},
  data() {
    return {
      totalInfo: {
        all: {
          title:"金湾区",
          num: 131.41,
          measure: "亿元",
          rise: 41.6,
        },
        zhishu: {
          title:"金湾直属",
          num: 97.76,
          measure: "亿元",
          rise: 66.7,
        },
        kaifaqu: {
          title:"开发区区",
          num: 33.65,
          measure: "亿元",
          rise: -1.5,
        },
      },
    };
  },
  methods: {
    handleChangeCate(e) {
      console.log(e);
    },

    handleShowMonitor(index) {
      console.log(index);
    },
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
        this.compareDomesticData = res
    });

    /***按月 累计增长率 */
    Api.timeline.get_monthdata().then((res) => {
      this.leijizengzhangData = {
        title: {
          text: "2020年3-2021年3月",
        },
        data: res.data,
      };
    });

    /*** 年度数据 */
    Api.timeline.get_yeardata().then((res) => {
      this.timelineYearData = {
        mode: "gross",
        title: {
          text: res.title,
        },
        data: res.data,
        origin: res,
      };
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
  height: 200px;
}


</style>
