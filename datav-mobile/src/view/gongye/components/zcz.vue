<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:45:06
 * @LastEditTime: 2021-06-01 02:59:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="m-base-total item-wrap">
      <div class="item item-gross">
        <van-icon name="points" size="48" class="icon" />
        <div class="info">
          <div class="section">地区生产总值(亿元)</div>
          <div class="val">837465</div>
        </div>
      </div>
      <div class="item item-rise">
        <van-icon name="chart-trending-o" size="48" class="icon" />
        <div class="info">
          <div class="section">同比增长</div>
          <div class="val">120%</div>
        </div>
      </div>
    </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="各区地区生产总值比较">
          <template v-slot:extra>
            <van-button
              @click="handleChangeCompareCounty('rise')"
              :type="compareCountyData.mode == 'rise' ? 'info' : 'default'"
              size="mini"
              >总量及增长率</van-button
            >
            <van-button
              :type="compareCountyData.mode == 'gross' ? 'info' : 'default'"
              size="mini"
              @click="handleChangeCompareCounty('gross')"
              >占全市比重</van-button
            >
          </template>
          <ChartCompareCounty
            :height="200"
            :mode="compareCountyData.mode"
            :title="compareCountyData.title"
            :chart-data="compareCountyData.data"
          ></ChartCompareCounty>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="国内部分区域地区生产总值比较">
          <ChartCompareDomestic
            :height="200"
            :title="compareDomesticData.title"
            :chart-data="compareDomesticData.data"
          ></ChartCompareDomestic>
        </ModuleCard>
      </div>
    </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="近一年地区生产总值情况">
          <template v-slot:extra>
            <van-button
              @click="handleChangeTimelineMonth('gross')"
              :type="timelineMonthData.mode == 'gross' ? 'info' : 'default'"
              size="mini"
              >总量</van-button
            >
            <van-button
              :type="timelineMonthData.mode == 'rise' ? 'info' : 'default'"
              size="mini"
              @click="handleChangeTimelineMonth('rise')"
              >累计增长速度</van-button
            >
          </template>

          <ChartMonth
            :title="timelineMonthData.title"
            :chart-data="timelineMonthData.data"
            :height="200"
            :mode="timelineMonthData.mode"
          ></ChartMonth>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="近五年地区生产总值情况">
          <template v-slot:extra>
            <van-button
              type="info"
              size="mini"
              @click="handleChangeYearMode('gross')"
              >总量</van-button
            >
            <van-button size="mini" @click="handleChangeYearMode('rise')"
              >增长率</van-button
            >
          </template>
          <ChartYear
            :height="200"
            :mode="timelineYearData.mode"
            :title="timelineYearData.title"
            :chart-data="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
      </div>
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
      sliderIndex: 0,
      totalInfo: {
        all: {
          title: "金湾区",
          num: 155.45,
          measure: "亿元",
          rise: 20.1,
        },
        zhishu: {
          title: "金湾直属",
          num: 73.18,
          measure: "亿元",
          rise: 25.4,
        },
        kaifaqu: {
          title: "经济开发区",
          num: 82.26,
          measure: "亿元",
          rise: 20.7,
        },
      },
      baseData: {},
      echartInstance: {},
      monitorTableList: [
        "工业企业产值监测表",
        "限额以上批发企业统计监测表",
        "限额以上零售业企业统计监测表",
        "限额以上住宿业企业统计监测表",
        "限额以上餐饮业企业统计监测表",
        "规模以上服务业企业统计监测表",
        "建筑业企业产值统计监测表",
        "房地产开发企业销售情况统计监测表",
      ],
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
    var chartName = [];
    this.chartInit({ chartName });

    /***指标对比 */
    Api.jjzb.get_county().then((res) => {
      this.compareCountyData = {
        mode: "rise",
        title: {},
        data: res.data,
      };
    });

    /*** 国内部分区域指标 */
    Api.jjzb.get_domestic().then((res) => {
      this.compareDomesticData = {
        title: {
          text: res.title,
        },
        data: res.data,
      };
    });

    /***按月 累计增长率 */
    Api.timeline.get_monthdata({params:{cate:'gdp'}}).then((res) => {
      this.timelineMonthData = {
        title: {
          text: "",
        },
        mode:"gross",
        data: res.data,
      };
    });

    /*** 年度数据 */
    Api.timeline.get_yeardata({ params: { cate: "gdp" } }).then((res) => {
      this.timelineYearData = {
        title: {
          text: res.title,
        },
        mode: "gross",
        data: res.data,
        origin: res.data,
      };
    });
  },
};
</script>

<style lang="less" scoped>
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

.m-base-total {
  display: flex;
  justify-content: space-between;
  .item {
    box-sizing: border-box;
    flex: 0 0 auto;
    padding: 0.0625rem;
    width: 49.25%;
    display: flex;
    align-items: center;
    background: #fff;
    line-height: 1;
    .icon {
      flex: 0 0 auto;
      margin-right: 12px;
    }
  }
  // .item-gross {
  //   color:#0066ff;
  // }
  //   .item-rise {
  //   color:#dd2416;
  // }
  .val {
    margin-top: 8px;
    font-weight: 500;
    font-size: 24px;
    font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
  }
}
.m-content-row .item-wrap {
  flex: 0 0 auto;
  width: 49.25%;
}
</style>
