<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:45:06
 * @LastEditTime: 2021-06-01 02:59:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <BmkTitleTotal :total="totalInfo.jw"></BmkTitleTotal>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="各镇一般公共预算支出情况">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'townData')"
              :type="chartModeBtnType('gross', 'townData')"
              size="mini"
              >总量及增速</van-button
            >
            <van-button
              :type="townData.vmode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeViewMode('table', 'townData')"
              >表格模式</van-button
            >
          </template>
          <ChartTown
            :height="240"
            :vmode="townData.vmode"
            :cmode="townData.cmode"
            :title="townData.title"
            :mdata="townData.data"
          ></ChartTown>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="各区一般公共预算支出比较">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'compareCountyData')"
              :type="chartModeBtnType('gross', 'compareCountyData')"
              size="mini"
              >总量及增速</van-button
            >
            <van-button
              :type="chartModeBtnType('proportion', 'compareCountyData')"
              size="mini"
              @click="handleChangeChartMode('proportion', 'compareCountyData')"
              >占全市比重</van-button
            >
            <van-button
              :type="compareCountyData.vmode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeViewMode('table', 'compareCountyData')"
              >表格模式</van-button
            >
          </template>
          <ChartCompareCounty
            :height="240"
            :vmode="compareCountyData.vmode"
            :cmode="compareCountyData.cmode"
            :title="compareCountyData.title"
            :mdata="compareCountyData.data"
          ></ChartCompareCounty>
        </ModuleCard>
      </div>
    </div>
    <div class="item-wrap">
      <ModuleCard title="一般公共预算支出按类别情况">
        <template v-slot:extra>
          <van-button
            size="mini"
            :type="chartModeBtnType('gross', 'cateZhichuData')"
            @click="handleChangeChartMode('gross', 'cateZhichuData')"
            >总量及同比</van-button
          >
          <van-button
            :type="cateZhichuData.vmode == 'table' ? 'info' : 'default'"
            size="mini"
            icon="notes-o"
            @click="handleChangeViewMode('table', 'cateZhichuData')"
            >表格模式</van-button
          >
        </template>
        <ChartCate
          :height="240"
          :vmode="cateZhichuData.vmode"
          :cmode="cateZhichuData.cmode"
          :title="cateZhichuData.title"
          :mdata="cateZhichuData.data"
        ></ChartCate>
      </ModuleCard>
    </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard title="近一年一般公共预算支出情况">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('rise', 'timelineMonthData')"
              :type="chartModeBtnType('rise', 'timelineMonthData')"
              size="mini"
              >累计增速</van-button
            >
            <van-button
              :type="timelineMonthData.vmode == 'table' ? 'info' : 'default'"
              size="mini"
              icon="notes-o"
              @click="handleChangeViewMode('table', 'timelineMonthData')"
              >表格模式</van-button
            >
          </template>

          <ChartMonth
            :height="260"
            :vmode="timelineMonthData.vmode"
            :cmode="timelineMonthData.cmode"
            :title="timelineMonthData.title"
            :mdata="timelineMonthData.data"
          ></ChartMonth>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="近五年一般公共预算支出情况">
          <template v-slot:extra>
            <van-button
              size="mini"
              :type="chartModeBtnType('gross', 'timelineYearData')"
              @click="handleChangeChartMode('gross', 'timelineYearData')"
              >总量</van-button
            >
            <van-button
              size="mini"
              :type="chartModeBtnType('rise', 'timelineYearData')"
              @click="handleChangeChartMode('rise', 'timelineYearData')"
              >增速</van-button
            >
            <van-button
              :type="timelineYearData.vmode == 'table' ? 'info' : 'default'"
              size="mini"
              icon="notes-o"
              @click="handleChangeViewMode('table', 'timelineYearData')"
              >表格模式</van-button
            >
          </template>
          <ChartYear
            :height="260"
            :vmode="timelineYearData.vmode"
            :cmode="timelineYearData.cmode"
            :title="timelineYearData.title"
            :mdata="timelineYearData.data"
          ></ChartYear>
        </ModuleCard>
      </div>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import chartMixin from "@/libs/chart-mixin.js";
import ChartCate from "./chart-cate.vue";
export default {
  mixins: [chartMixin],
  components: { ChartCate },
  data() {
    return {
      totalInfo: {
        jw: {
          gross: 0,
          rise: 0,
        },
      },
      cateZhichuData: {
        tableColumn: [],
        tableData: [],
      },
    };
  },
  methods: {},
  mounted() {
    Api.base.get_total({ cate: "一般公共预算支出" }).then((res) => {
      this.totalInfo = res.data;
    });

    /***各镇指标 */
    Api.jjzb.get_town({ params: { cate: "一般公共预算支出" } }).then((res) => {
      this.townData = {
        cmode: "gross",
        vmode: "chart",
        title: {},
        data: {
          tableColumn: res.data.columns,
          tableData: res.data.list,
        },
      };
    });

    /***各区指标对比 */
    Api.jjzb
      .get_county({ params: { cate: "一般公共预算支出" } })
      .then((res) => {
        this.compareCountyData = {
          cmode: "gross",
          vmode: "chart",
          title: {},
          data: {
            tableColumn: res.data.columns,
            tableData: res.data.list,
          },
        };
      });

    /*** 国内部分区域指标 */
    Api.jjzb
      .get_domestic({ params: { cate: "一般公共预算支出" } })
      .then((res) => {
        this.compareDomesticData = {
          cmode: "gross",
          vmode: "chart",
          title: { text: res.data.title },
          data: {
            tableColumn: res.data.columns,
            tableData: res.data.list,
          },
        };
      });

    /***按月 累计增速 */
    Api.timeline
      .get_monthdata({ params: { cate: "一般公共预算支出" } })
      .then((res) => {
        this.timelineMonthData = {
          cmode: "rise",
          vmode: "chart",
          title: { text: res.data.title },
          data: {
            tableColumn: res.data.columns,
            tableData: res.data.list,
          },
        };
      });

    /*** 年度数据 */
    Api.timeline
      .get_yeardata({ params: { cate: "一般公共预算支出" } })
      .then((res) => {
        this.timelineYearData = {
          cmode: "gross",
          vmode: "chart",
          title: { text: res.data.title },
          data: {
            tableColumn: res.data.columns,
            tableData: res.data.list,
          },
        };
      });

    /*** 按类别 */
    Api.base.get_finance({ params: { cate: "支出" } }).then((res) => {
      this.cateZhichuData = {
        cmode: "gross",
        vmode: "chart",
        title: { text: res.data.title },
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
</style>
