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
        <van-icon name="/screen/demo3/assets/icon/icon-huoyou.svg" class="icon" />
        <div class="info">
          <div class="title">{{ totalInfo.gk.title }}</div>
          <div class="gross">
            总量：
            <span class="num">{{ totalInfo.gk.gross }}</span
            ><span class="measure">{{ totalInfo.gk.measure }}</span>
          </div>
          <div class="rise">
            同比:
            <Trend
              :size="14"
              :rate="totalInfo.gk.rise"
              v-if="totalInfo.gk.rise"
            ></Trend>
          </div>
        </div>
      </div>
      <div class="top-total-wrap item">
        <van-icon
          name="/screen/demo3/assets/icon/icon-jizhuangxiang.svg"
          class="icon"
        />
        <div class="info">
          <div class="title">{{ totalInfo.jzx.title }}</div>
          <div class="gross">
            总量：
            <span class="num">{{ totalInfo.jzx.gross }}</span
            ><span class="measure">{{ totalInfo.jzx.measure }}</span>
          </div>
          <div class="rise">
            同比:
            <Trend
              :size="14"
              :rate="totalInfo.jzx.rise"
              v-if="totalInfo.jzx.rise"
            ></Trend>
          </div>
        </div>
      </div>
    </div>


    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="近一年高栏港港口吐量累计增长">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('rise', 'timelineMonthLvkeData')"
              :type="chartModeBtnType('rise', 'timelineMonthLvkeData')"
              size="mini"
              >累计增长速度</van-button
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
        <ModuleCard title="近一年集装箱累计增长">
          <template v-slot:extra>
            <van-button
              size="mini"
              :type="chartModeBtnType('rise', 'timelineMonthHuoyouData')"
              @click="handleChangeChartMode('rise', 'timelineMonthHuoyouData')"
              >累计增长</van-button
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
        <ModuleCard title="近五年高栏港港口吞吐量">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'yearGangkouData')"
              :type="chartModeBtnType('gross', 'yearGangkouData')"
              size="mini"
              >总量及增长</van-button
            >
            <van-button
              :type="yearGangkouData.vmode == 'table' ? 'info' : 'default'"
              size="mini"
              icon="notes-o"
              @click="handleChangeViewMode('table', 'yearGangkouData')"
              >表格模式</van-button
            >
          </template>

          <ChartTransportYear
            :height="260"
            chart-id="chart-year-lvke"
            :vmode="yearGangkouData.vmode"
            :cmode="yearGangkouData.cmode"
            :title="yearGangkouData.title"
            :mdata="yearGangkouData.data"
          ></ChartTransportYear>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="近五年高栏港集装箱吐量情况">
          <template v-slot:extra>
            <van-button
              size="mini"
              :type="chartModeBtnType('gross', 'yearJizhuangxiangData')"
              @click="handleChangeChartMode('gross', 'yearJizhuangxiangData')"
              >总量及增长</van-button
            >
            <van-button
              :type="
                yearJizhuangxiangData.vmode == 'table' ? 'info' : 'default'
              "
              size="mini"
              icon="notes-o"
              @click="handleChangeViewMode('table', 'yearJizhuangxiangData')"
              >表格模式</van-button
            >
          </template>
          <ChartTransportYear
            :height="260"
            chart-id="chart-year-huoyou"
            :vmode="yearJizhuangxiangData.vmode"
            :cmode="yearJizhuangxiangData.cmode"
            :title="yearJizhuangxiangData.title"
            :mdata="yearJizhuangxiangData.data"
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
        gk: {
          measure: "",
          gross: 0,
          rise: 0,
        },
        jzx: {
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
      yearGangkouData: {
        tableColumn: [],
        tableData: [],
      },
      yearJizhuangxiangData: {
        tableColumn: [],
        tableData: [],
      },
    };
  },
  methods: {},
  mounted() {
    Api.base
      .get_data_for_transport({ params: { cate: "高栏港" } })
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
      .get_yeardata_transport({ params: { cate: "高栏港" } })
      .then((res) => {
        this.yearGangkouData = {
          cmode: "gross",
          vmode: "chart",
          title: { text: "" },
          data: {
            tableColumn: res.data.gk.columns,
            tableData: res.data.gk.list,
          },
        };
        this.yearJizhuangxiangData = {
          cmode: "gross",
          vmode: "chart",
          title: { text: "" },
          data: {
            tableColumn: res.data.jzx.columns,
            tableData: res.data.jzx.list,
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
