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
      <div class="top-total-wrap item">
        <van-icon name="friends" class="icon" />
        <div class="info">
          <div class="title">{{ totalInfo.jclk.title }}</div>
          <div class="gross">
            总量：
            <span class="num">{{ totalInfo.jclk.gross }}</span
            ><span class="measure">{{ totalInfo.jclk.measure }}</span>
          </div>
          <div class="rise">
            同比:
            <Trend
              :size="14"
              :rate="totalInfo.jclk.rise"
              v-if="totalInfo.jclk.rise"
            ></Trend>
          </div>
        </div>
      </div>
      <div class="top-total-wrap item">
        <van-icon name="/screen/demo3/assets/icon/icon-huoyou.svg" class="icon" />
        <div class="info">
          <div class="title">{{ totalInfo.jchy.title }}</div>
          <div class="gross">
            总量：
            <span class="num">{{ totalInfo.jchy.gross }}</span
            ><span class="measure">{{ totalInfo.jchy.measure }}</span>
          </div>
          <div class="rise">
            同比:
            <Trend
              :size="14"
              :rate="totalInfo.jchy.rise"
              v-if="totalInfo.jchy.rise"
            ></Trend>
          </div>
        </div>
      </div>
    </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="近一年旅客吞吐量累计增长">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('rise', 'timelineMonthLvkeData')"
              :type="chartModeBtnType('rise', 'timelineMonthLvkeData')"
              size="mini"
              >累计增速</van-button
            >
            <van-button
              :type="
                timelineMonthLvkeData.vmode == 'table' ? 'info' : 'default'
              "
              size="mini"
              icon="notes-o"
              @click="handleChangeViewMode('table', 'timelineMonthLvkeData')"
              >表格模式</van-button
            >
          </template>

          <ChartMonth
            :height="260"
            :vmode="timelineMonthLvkeData.vmode"
            :cmode="timelineMonthLvkeData.cmode"
            :title="timelineMonthLvkeData.title"
            :mdata="timelineMonthLvkeData.data"
          ></ChartMonth>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="近一年邮吞吐量累计增速">
          <template v-slot:extra>
            <van-button
              size="mini"
              :type="chartModeBtnType('rise', 'timelineMonthHuoyouData')"
              @click="handleChangeChartMode('rise', 'timelineMonthHuoyouData')"
              >累计增速</van-button
            >
            <van-button
              :type="
                timelineMonthHuoyouData.vmode == 'table' ? 'info' : 'default'
              "
              size="mini"
              icon="notes-o"
              @click="handleChangeViewMode('table', 'timelineMonthHuoyouData')"
              >表格模式</van-button
            >
          </template>
          <ChartMonth
            :height="260"
            chart-id="chart-timeline-month-huoyou"
            :vmode="timelineMonthHuoyouData.vmode"
            :cmode="timelineMonthHuoyouData.cmode"
            :title="timelineMonthHuoyouData.title"
            :mdata="timelineMonthHuoyouData.data"
          ></ChartMonth>
        </ModuleCard>
      </div>
    </div>
    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="近五年旅客吞吐量">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'timelineYearLvkeData')"
              :type="chartModeBtnType('gross', 'timelineYearLvkeData')"
              size="mini"
              >总量及增速</van-button
            >
            <van-button
              :type="timelineYearLvkeData.vmode == 'table' ? 'info' : 'default'"
              size="mini"
              icon="notes-o"
              @click="handleChangeViewMode('table', 'timelineYearLvkeData')"
              >表格模式</van-button
            >
          </template>

          <ChartTransportYear
            :height="260"
            chart-id="chart-year-lvke"
            :vmode="timelineYearLvkeData.vmode"
            :cmode="timelineYearLvkeData.cmode"
            :title="timelineYearLvkeData.title"
            :mdata="timelineYearLvkeData.data"
          ></ChartTransportYear>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="近五年货邮吞吐量情况">
          <template v-slot:extra>
            <van-button
              size="mini"
              :type="chartModeBtnType('gross', 'timelineYearHuoyouData')"
              @click="handleChangeChartMode('gross', 'timelineYearHuoyouData')"
              >总量及增速</van-button
            >
            <van-button
              :type="
                timelineYearHuoyouData.vmode == 'table' ? 'info' : 'default'
              "
              size="mini"
              icon="notes-o"
              @click="handleChangeViewMode('table', 'timelineYearHuoyouData')"
              >表格模式</van-button
            >
          </template>
          <ChartTransportYear
            :height="260"
            chart-id="chart-year-huoyou"
            :vmode="timelineYearHuoyouData.vmode"
            :cmode="timelineYearHuoyouData.cmode"
            :title="timelineYearHuoyouData.title"
            :mdata="timelineYearHuoyouData.data"
          ></ChartTransportYear>
        </ModuleCard>
      </div>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import chartMixin from "@/libs/chart-mixin.js";
import ChartTransportYear from "./chart-cate.vue";
export default {
  mixins: [chartMixin],
  components: { ChartTransportYear },
  data() {
    return {
      totalInfo: {
        jclk: {
          measure: "",
          gross: 0,
          rise: 0,
        },
        jchy: {
          measure: "",
          gross: 0,
          rise: 0,
        },
      },
      timelineMonthHuoyouData: {
        tableColumn: [],
        tableData: [],
      },
      timelineMonthLvkeData: {
        tableColumn: [],
        tableData: [],
      },
      timelineYearLvkeData: {
        tableColumn: [],
        tableData: [],
      },
      timelineYearHuoyouData: {
        tableColumn: [],
        tableData: [],
      },
    };
  },
  methods: {},
  mounted() {
    Api.base
      .get_data_for_transport({ params: { cate: "珠海机场" } })
      .then((res) => {
        this.totalInfo = res.data;
      });

    /***按月 累计增长率 */
    Api.timeline.get_monthdata({ params: { cate: "珠海机场" } }).then((res) => {
      this.timelineMonthLvkeData = {
        cmode: "rise",
        vmode: "chart",
        title: { text: res.data.jclk.title },
        data: {
          measure: res.data.jclk.measure,
          tableColumn: res.data.jclk.columns,
          tableData: res.data.jclk.list,
        },
      };
      this.timelineMonthHuoyouData = {
        cmode: "rise",
        vmode: "chart",
        title: { text: res.data.jchy.title },
        data: {
          measure: res.data.jchy.measure,
          tableColumn: res.data.jchy.columns,
          tableData: res.data.jchy.list,
        },
      };
    });

    /*** 年度数据 */
    Api.timeline
      .get_yeardata_transport({ params: { cate: "珠海机场" } })
      .then((res) => {
        this.timelineYearLvkeData = {
          cmode: "gross",
          vmode: "chart",
          title: { text: "" },
          data: {
            tableColumn: res.data.jclk.columns,
            tableData: res.data.jclk.list,
          },
        };
        this.timelineYearHuoyouData = {
          cmode: "gross",
          vmode: "chart",
          title: { text: "" },
          data: {
            tableColumn: res.data.jchy.columns,
            tableData: res.data.jchy.list,
          },
        };
      });
  },
};
</script>

<style lang="less" scoped>
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
  }
}
.top-total-wrap {
  display: flex;
  align-items: center;
  .icon {
    flex: 0 0 auto;
    font-size: 72px;
    color: #696969;
    opacity: 0.7;
  }
  .info {
    padding: 0.0625rem;
    .title {
      font-size: 14px;
      font-weight: bold;
    }
    .num {
      margin-right: 12px;
      font-size: 24px;
      font-weight: bold;
      color: #ff3300;
    }
    .measure {
      color: #969696;
    }
  }
}
</style>
