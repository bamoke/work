<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:50:57
 * @LastEditTime: 2021-06-01 03:03:07
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
        <ModuleCard title="外贸进出口近一年累计增速" class="item-wrap">
          <ChartMonth
            :height="200"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard title="外贸进出口近五年情况" class="item-wrap">
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
      <TownMap :total-info="townTotalInfo"></TownMap>
      <div class="item-wrap">
        <div class="l-row l-row-bt">
          <EffectCircleCount3D :data="totalInfo.jw"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.zs"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.kfq"></EffectCircleCount3D>
        </div>
      </div>

    </div>
<<<<<<< HEAD
    <div class="row-side">
=======
    <div class="row-side side-right">
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
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
        jw: {
          area:"金湾区",
          gross: 0,
          measure: "",
          rise: '0',
        },
        zs: {
          area:"金湾直属",
          gross: 0,
          measure: "",
          rise: '0',
        },
        kfq: {
          area:"开发区",
          num: 0,
          measure: "",
          rise: '0',
        },
      },
      townTotalInfo:{}
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

    Api.base.get_total({ cate: "外贸进出口总额" }).then((res) => {
      this.totalInfo = res.data;
    });
        // 各镇指标
    Api.jjzb.get_town({params:{ cate: "外贸进出口总额" }}).then((res) => {
      this.townTotalInfo = res.data
    });
    /***指标对比 */
    Api.jjzb.get_county({ params: { cate: "外贸进出口总额" } }).then((res) => {
      this.compareCountyData = {
        mode: "gross",
        title: {},
        data: this.$formatTableToChart(res.data.list, res.data.columns),
      };
    });

    /*** 国内部分区域指标 */
    Api.jjzb.get_domestic({ params: { cate: "外贸进出口总额" } }).then((res) => {
      this.compareDomesticData = {
        title: {
          text: res.data.title,
        },
        data: this.$formatTableToChart(res.data.list, res.data.columns),
      };
    });

    /***按月 累计增长率 */
    Api.timeline
      .get_monthdata({ params: { cate: "外贸进出口" } })
      .then((res) => {
        this.leijizengzhangData = {
          title: {
            text: "",
          },
          data: this.$formatTableToChart(res.data.list, res.data.columns),
        };
      });

    /*** 年度数据 */
    Api.timeline
      .get_yeardata({ params: { cate: "外贸进出口" } })
      .then((res) => {
        this.timelineYearData = {
          title: {
            text: this.title || "",
          },
          mode: "gross",
          data: this.$formatTableToChart(res.data.list, res.data.columns),
          origin: this.$formatTableToChart(res.data.list, res.data.columns),
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
