<!--
 * @Author: Joy wang
 * @Date: 2021-05-19 04:41:13
 * @LastEditTime: 2021-06-02 04:36:28
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="row-side side-left">
      <div class="transform-box">
        <ModuleCard title="近一年累计增速" class="item-wrap">
          <ChartMonth
            :height="200"
            :title="leijizengzhangData.title"
            :chart-data="leijizengzhangData.data"
          ></ChartMonth>
        </ModuleCard>
        <ModuleCard title="近五年情况" class="item-wrap">
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

    Api.base.get_total({ cate: "实际吸收外商投资" }).then((res) => {
      var totalInfo = res.data
      totalInfo.jw.gross = parseInt(totalInfo.jw.gross)
      totalInfo.zs.gross = parseInt(totalInfo.zs.gross)
      totalInfo.kfq.gross = parseInt(totalInfo.kfq.gross)
      this.totalInfo = totalInfo;
    });
    // 各镇指标
    Api.jjzb.get_town({params:{ cate: "实际吸收外商投资" }}).then((res) => {
      this.townTotalInfo = res.data;
    });
    /***指标对比 */
    Api.jjzb.get_county({ params: { cate: "实际吸收外商直接投资" } }).then((res) => {
      this.compareCountyData = {
        mode: "gross",
        title: {},
        data: this.$formatTableToChart(res.data.list, res.data.columns),
      };
    });

    /*** 国内部分区域指标 */
    Api.jjzb
      .get_domestic({ params: { cate: "实际吸收外商直接投资" } })
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
      .get_monthdata({ params: { cate: "实际利用外商直接投资" } })
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
      .get_yeardata({ params: { cate: "实际利用外商直接投资" } })
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
