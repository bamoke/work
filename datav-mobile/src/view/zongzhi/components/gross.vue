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
        <van-icon name="points" size="56" class="icon" />
        <div class="info">
          <div class="val">155.45</div>
          <div class="section">地区生产总值(亿元)</div>
        </div>
      </div>
      <div class="item item-rise">
        <van-icon name="chart-trending-o" size="56" class="icon" />
        <div class="info">
          <div class="val">120%</div>
          <div class="section">同比增长</div>
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
            <van-button
              :type="compareCountyData.mode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeCompareCounty('table')"
              >表格模式</van-button
            >
          </template>
          <ChartCompareCounty
            :height="240"
            :mode="compareCountyData.mode"
            :title="compareCountyData.title"
            :chart-data="compareCountyData.data"
          ></ChartCompareCounty>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="近一年地区生产总值情况">
          <template v-slot:extra>
            <van-button
              @click="handleChangeTimelineMonth('rise')"
              :type="timelineMonthData.mode == 'rise' ? 'info' : 'default'"
              size="mini"
              >累计增长速度</van-button
            >
            <van-button
              :type="timelineMonthData.mode == 'table' ? 'info' : 'default'"
              size="mini"
              icon="notes-o"
              @click="handleChangeTimelineMonth('table')"
              >表格模式</van-button
            >
          </template>

          <ChartMonth
            :title="timelineMonthData.title"
            :chart-data="timelineMonthData.data"
            :height="240"
            :mode="timelineMonthData.mode"
          ></ChartMonth>
        </ModuleCard>
      </div>
    </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="近五年地区生产总值情况">
          <template v-slot:extra>
            <van-button
              size="mini"
              :type="timelineYearData.mode == 'gross' ? 'info' : 'default'"
              @click="handleChangeYearMode('gross')"
              >总量</van-button
            >
            <van-button
              size="mini"
              :type="timelineYearData.mode == 'rise' ? 'info' : 'default'"
              @click="handleChangeYearMode('rise')"
              >增长率</van-button
            >
            <van-button
              :type="timelineYearData.mode == 'table' ? 'info' : 'default'"
              size="mini"
              icon="notes-o"
              @click="handleChangeYearMode('table')"
              >表格模式</van-button
            >
          </template>
          <ChartYear
            :height="240"
            :mode="timelineYearData.mode"
            :title="timelineYearData.title"
            :chart-data="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="GDP能耗">
          <div style="height: 240px" class="">
            <div class="gdp-nenghao">
              <div class="item">
                <div class="val">26.4%</div>
                <div class="title">GDP增速</div>
              </div>

              <div class="item">
                <div class="val down"><van-icon name="down" />16.3%</div>
                <div class="title">单位GDP能耗</div>
              </div>
            </div>
            <div class="nengyuanxiaofei">
              <div class="title">
                规上工业能源消费总量(等价值)<span class="sub"
                  >单位:(万吨标准煤)</span
                >
              </div>
              <div class="content-row">
                <div class="item">
                  <div class="val">99.71</div>
                  <div class="section">本期数</div>
                </div>
                <div class="item">
                  <div class="val">71.81</div>
                  <div class="section">本期数</div>
                </div>
                <div class="item">
                  <div class="val">38.85</div>
                  <div class="section">增长(%)</div>
                </div>
              </div>
            </div>
          </div>
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
    };
  },
  methods: {},
  mounted() {
    var chartName = [];
    this.chartInit({ chartName });

    /***指标对比 */
    Api.jjzb.get_county({ params: { cate: "gdp" } }).then((res) => {
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
        mode: "gross",
        data: res.data,
      };
    });

    /***按月 累计增长率 */
    Api.timeline.get_monthdata({ params: { cate: "gdp" } }).then((res) => {
      this.timelineMonthData = {
        title: {
          text: "",
        },
        mode: "rise",
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
      opacity: .6;
    }
  }
  .item-gross {
    .val {
      margin-bottom: 4px;
      color: #ff6600;
    }
  }
  .item-rise {
    .val {
      margin-bottom: 4px;
      color: #dd2416;
    }
  }
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

.gdp-nenghao {
  display: flex;
  justify-content: space-between;
  .item {
    flex: 0 0 auto;
    width: 40%;
    text-align: center;
    padding: 8px 0;
    border: 1px solid rgba(0, 0, 0, 0.1);
    .val {
      font-size: 16px;
      font-weight: bold;
    }
    .down {
      color: #00cc99;
    }
  }
}
.nengyuanxiaofei {
  margin-top: 12px;
  padding-top: 6px;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  .title {
    .sub {
      margin-left: 12px;
      font-size: 11px;
      color: #969696;
    }
  }
  .content-row {
    display: flex;
    justify-content: space-between;
    padding-top: 8px;
    .item {
      display: flex;
      flex-direction: column;
      justify-content: center;
      width: 72px;
      height: 72px;
      text-align: center;
      border-radius: 50%;
      border: 4px solid #99ccff;
      .val {
        font-size: 14px;
        font-weight: bold;
      }
    }
  }
}
</style>
