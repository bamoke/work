<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:45:06
 * @LastEditTime: 2021-06-01 02:59:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div style="width: 100%; height: 100%">
    <div class="content-wrap">
<<<<<<< HEAD
      <div class="row-side">
=======
      <div class="row-side side-left">
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
        <div class="transform-box">
          <ModuleCard title="地区生产总值近一年累计增速" class="item-wrap">
            <ChartMonth
              :title="leijizengzhangData.title"
              :chart-data="leijizengzhangData.data"
              :height="200"
            ></ChartMonth>
          </ModuleCard>
<<<<<<< HEAD
          <ModuleCard title="地区生产总值近五年情况" class="item-wrap">
=======
<<<<<<< HEAD
          <ModuleCard title="近五年地区生产总值及增长率" class="item-wrap">
=======
          <ModuleCard title="地区生产总值及增长率" class="item-wrap">
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
>>>>>>> 23d6d38042cc57823cacef462cf8fdc01e79e502
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
              :mode="timelineYearData.mode"
              :title="timelineYearData.title"
              :chart-data="timelineYearData.data"
            ></ChartYear>
          </ModuleCard>
          <ModuleCard title="一二三产业占比" class="item-wrap">
            <div id="chart-changye-proportion" style="height: 240px"></div>
          </ModuleCard>
        </div>
        <div class="bt-shadow"></div>
      </div>

      <!-- 中间 -->
      <div class="row-big">
        <TownMap></TownMap>
        <div class="l-row l-row-bt">
          <EffectCircleCount3D :data="totalInfo.jw"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.zs"></EffectCircleCount3D>
          <EffectCircleCount3D :data="totalInfo.kfq"></EffectCircleCount3D>
        </div>
        <div class="item-wrap">
          <div class="m-child-nav-box">
            <router-link :to="{ name: 'gdp_company' }" class="child-nav-item">
              <div class="nav-name">重点企业经营情况</div>
            </router-link>
          </div>
        </div>
      </div>

      <!-- side -->
<<<<<<< HEAD
      <div class="row-side">
=======
      <div class="row-side side-right">
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
        <div class="transform-box">
          <ModuleCard title="各区地区生产总值比较" class="item-wrap">
            <template v-slot:extra>
              <ButtonGroup size="small">
                <Button
                  type="primary"
                  @click="handleChangeCompareCounty('gross')"
                  >总值</Button
                >
                <Button @click="handleChangeCompareCounty('rise')"
                  >增长率</Button
                >
              </ButtonGroup>
            </template>
            <ChartCompareCounty
              :height="200"
              :mode="compareCountyData.mode"
              :title="compareCountyData.title"
              :chart-data="compareCountyData.data"
            ></ChartCompareCounty>
          </ModuleCard>

          <ModuleCard title="国内部分区域地区生产总值比较" class="item-wrap">
            <ChartCompareDomestic
              :height="200"
              :title="compareDomesticData.title"
              :chart-data="compareDomesticData.data"
            ></ChartCompareDomestic>
          </ModuleCard>
          <ModuleCard title="按行业总量及增速" class="item-wrap">
            <div id="chart-hangye-gross" style="height: 240px"></div>
          </ModuleCard>
        </div>
        <div class="bt-shadow"></div>
      </div>
    </div>

    <transition> </transition>
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
      townTotalInfo: {},
      sliderIndex: 0,
      totalInfo: {
        jw: {
          title: "金湾区",
          gross: 155.45,
          measure: "亿元",
          rise: "0",
        },
        zs: {
          title: "金湾直属",
          gross: 73.18,
          measure: "亿元",
          rise: "0",
        },
        kfq: {
          title: "经济开发区",
          gross: 82.26,
          measure: "亿元",
          rise: "0",
        },
      },
      chanyeProportionData: [],
      baseData: {},
      echartInstance: {},
      monitorTableList: [],
      propertyTableList: [],
      showModal: false,
      modalTitle: "地区总产值按产业情况",
      showChild: "",
    };
  },
  methods: {
    handleShowMonitor(tableName) {
      this.$router.push({ name: "gdp_monitor", query: { table: tableName } });
    },
    openChild(title, moduleName) {
      this.showModal = true;
      this.modalTitle = title;
      this.showChild = moduleName;
    },
  },
  mounted() {
    var chartName = ["changye-proportion", "hangye-gross"];
    this.chartInit({ chartName });

    Api.base.get_total({ cate: "地区生产总值" }).then((res) => {
      this.totalInfo = res.data;
    });
    /***指标对比 */
    Api.jjzb.get_county({ params: { cate: "地区生产总值" } }).then((res) => {
      this.compareCountyData = {
        mode: "gross",
        title: {},
        data: this.$formatTableToChart(res.data.list, res.data.columns),
      };
    });

    /*** 国内部分区域指标 */
    Api.jjzb.get_domestic({ params: { cate: "地区生产总值" } }).then((res) => {
      this.compareDomesticData = {
        title: {
          text: res.data.title,
        },
        data: this.$formatTableToChart(res.data.list, res.data.columns),
      };
    });

    /***按月 累计增长率 */
    Api.timeline
      .get_monthdata({ params: { cate: "地区生产总值" } })
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
      .get_yeardata({ params: { cate: "地区生产总值" } })
      .then((res) => {
        this.timelineYearData = {
          title: {
            text: res.title,
          },
          mode: "gross",
          data: this.$formatTableToChart(res.data.list, res.data.columns),
          origin: res.data,
        };
      });

    Api.base.get_gdp_hangye({ cate: "按产业" }).then((res) => {
      this.echartInstance["changye-proportion"].setOption({
        dataset: { source: res.data.list },
        legend: {
          show: true,
          left: "right",
          top: "top",
          orient: "vertical",
        },
        tooltip: {
          trigger: "item",
        },

        series: [
          {
            type: "pie",
            radius: ["0", "65%"],
            center: ["50%", "50%"],
            label: {
              show: true,
              formatter: "{b}\n占比:{d}%",
            },
            labelLine: {
              show: true,
            },
          },
        ],
      });
    });

    Api.base.get_gdp_hangye({ cate: "按行业" }).then((res) => {
      this.echartInstance["hangye-gross"].setOption({
        dataset: { source: res.data.list },
        grid: {
          top: 40,
          left: 60,
          right: 40,
          bottom: 80,
        },

        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            rotate: -45,
            formatter: function (value) {
              return value;
              // return formatStringWrap(value, 4);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: "{value}",
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
      });
    });
  },
};
</script>

<style lang="less" scoped>
.content-wrap {
}

.banner-box {
  height: 3.4375rem;
}
.item-wrap {
  margin-bottom: 0.083333rem;
}

#chart-timelineyear {
  height: 1.666667rem;
}
.chart-cate-height {
  height: 1.666667rem;
}

/** */
.m-shujujiance {
  .item {
    padding: 0 0.125rem;
    height: 0.1875rem;
    line-height: 0.1875rem;
    text-align: left;
    cursor: pointer;
  }
  .item:nth-child(2n + 1) {
    background-color: rgba(180, 180, 180, 0.1);
  }
}
</style>
