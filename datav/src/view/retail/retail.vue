<!--
 * @Author: Joy wang
 * @Date: 2021-05-19 04:41:13
 * @LastEditTime: 2021-05-30 20:40:33
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
        <ModuleCard title="社消零总额近一年累计增速" class="item-wrap">
          <ChartMonth
            :height="240"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard title="社消零总额近五年情况" class="item-wrap">
          <ChartYear
            :height="520"
            :is-open="true"
            :title="timelineYearData.title"
            :chart-data="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
      </div>
      <div class="bt-shadow"></div>
    </div>
    <div class="row-big">
      <TownMap></TownMap>
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
        <ModuleCard title="各区社消零比较" class="item-wrap">
          <ChartCompareCounty
            :height="520"
            :is-open="true"
            :title="compareCountyData.title"
            :chart-data="compareCountyData.data"
          ></ChartCompareCounty>
        </ModuleCard>

        <ModuleCard title="国内其他区域比较" class="item-wrap">
          <ChartCompareDomestic
            :height="240"
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
        jw: {
          area: "金湾区",
          gross: 0,
          measure: "",
          rise: '0',
        },
        zs: {
          area: "金湾直属",
          gross: 0,
          measure: "",
          rise: '0',
        },
        kfq: {
          area: "开发区",
          num: 0,
          measure: "",
          rise: '0',
        },
      },
      townTotalInfo: {},
    };
  },
  methods: {
    name() {},
  },
  mounted() {
    var chartName = [];
    this.chartInit({ chartName });

    Api.base.get_total({ cate: "社会消费品零售总额" }).then((res) => {
      this.totalInfo = res.data;
    });

    /***指标对比 */
    Api.jjzb.get_county({ params: { cate: "社会消费品零售总额" } }).then((res) => {
      this.compareCountyData = {
        mode: "gross",
        title: {},
        data: this.$formatTableToChart(res.data.list, res.data.columns),
      };
    });

    /*** 国内部分区域指标 */
    Api.jjzb
      .get_domestic({ params: { cate: "社会消费品零售总额" } })
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
      .get_monthdata({ params: { cate: "社会消费品零售总额" } })
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
      .get_yeardata({ params: { cate: "社会消费品零售总额" } })
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
.content-wrap {
  // background-image: url("../../assets/images/bg-xiaofei.jpg");
}
.banner-box {
  height: 680px;
}
</style>
