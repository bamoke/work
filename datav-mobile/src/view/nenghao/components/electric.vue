<template>
  <div class="content-wrap">
    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard>
          <div class="top-total-wrap">
            <div class="info">
              <div class="title">{{ totalInfo.gy.title }}</div>
              <div class="gross">
                总量：
                <span class="num">{{ totalInfo.gy.gross }}</span
                ><span class="measure">{{ totalInfo.gy.measure }}</span>
              </div>
              <div class="rise">
                同比:
                <Trend
                  :size="14"
                  :rate="totalInfo.gy.rise"
                  v-if="totalInfo.gy.rise"
                ></Trend>
              </div>
            </div>
          </div>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard>
          <div class="top-total-wrap">
            <div class="info">
              <div class="title">{{ totalInfo.fgy.title }}</div>
              <div class="gross">
                总量：
                <span class="num">{{ totalInfo.fgy.gross }}</span
                ><span class="measure">{{ totalInfo.fgy.measure }}</span>
              </div>
              <div class="rise">
                同比:
                <Trend
                  :size="14"
                  :rate="totalInfo.fgy.rise"
                  v-if="totalInfo.fgy.rise"
                ></Trend>
              </div>
            </div>
          </div>
        </ModuleCard>
      </div>
    </div>
    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="各区全社会用电量比较">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'allData')"
              :type="chartModeBtnType('gross', 'allData')"
              size="mini"
              >总量及增长率</van-button
            >
            <van-button
              :type="chartModeBtnType('proportion', 'allData')"
              size="mini"
              @click="handleChangeChartMode('proportion', 'allData')"
              >占全市比重</van-button
            >
            <van-button
              :type="allData.vmode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeViewMode('table', 'allData')"
              >表格模式</van-button
            >
          </template>
          <ChartCompareCounty
            :height="240"
            :vmode="allData.vmode"
            :cmode="allData.cmode"
            :title="allData.title"
            :mdata="allData.data"
          ></ChartCompareCounty>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="各区工业用电量比较">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'industryData')"
              :type="chartModeBtnType('gross', 'industryData')"
              size="mini"
              >总量及增长率</van-button
            >
            <van-button
              :type="chartModeBtnType('proportion', 'industryData')"
              size="mini"
              @click="handleChangeChartMode('proportion', 'industryData')"
              >占全市比重</van-button
            >
            <van-button
              :type="industryData.vmode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeViewMode('table', 'industryData')"
              >表格模式</van-button
            >
          </template>
          <ChartCompareCounty
            chart-id="chart-compare-county-industry"
            :height="240"
            :vmode="industryData.vmode"
            :cmode="industryData.cmode"
            :title="industryData.title"
            :mdata="industryData.data"
          ></ChartCompareCounty>
        </ModuleCard>
      </div>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import chartMixin from "@/libs/chart-mixin.js";
export default {
  mixins: [chartMixin],
  data() {
    return {
      totalInfo: {
        gy: {},
        fgy: {},
      },
      industryData: {},
      allData: {},
    };
  },
  mounted() {
    Api.nenghao.get_electric_use({ params: { cate: "all" } }).then((res) => {
      this.totalInfo = res.data;
    });
    /***各区指标对比 */
    Api.jjzb.get_county({ params: { cate: "全社会用电量" } }).then((res) => {
      this.allData = {
        cmode: "gross",
        vmode: "chart",
        title: {},
        data: {
          tableColumn: res.data.columns,
          tableData: res.data.list,
        },
      };
    });
    Api.jjzb.get_county({ params: { cate: "工业用电量" } }).then((res) => {
      this.industryData = {
        cmode: "gross",
        vmode: "chart",
        title: {},
        data: {
          tableColumn: res.data.columns,
          tableData: res.data.list,
        },
      };
    });
  },
};
</script>

<style lang="less" scoped>
.top-total-wrap {
  display: flex;
  align-items: center;
  .icon {
    flex: 0 0 auto;
    font-size: 72px;
    color: #696969;
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
    }
    .measure {
      color: #969696;
    }
  }
}
</style>