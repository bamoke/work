<template>
  <div class="content-wrap">
    <div class="item-wrap">
      <div class="page-bar">
        <div class="title">{{pageName}}</div>
        <div>
          <van-button
            size="mini"
            style="width: 80px"
            type="info"
            @click="goBack()"
            ><van-icon name="arrow-left" />返回</van-button
          >
        </div>
      </div>

    </div>
    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard :title="curCateName + '细分总量及增速情况'">
          <div style="height: 240px" id="chart-cate" class=""></div>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard :title="timelineMonthData.title">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('rise', 'timelineMonthData')"
              :type="chartModeBtnType('rise', 'timelineMonthData')"
              size="mini"
              >累计增度</van-button
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
            :height="240"
            :vmode="timelineMonthData.vmode"
            :cmode="timelineMonthData.cmode"
            :mdata="timelineMonthData.data"
          ></ChartMonth>
        </ModuleCard>
      </div>
    </div>
    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard :title="'各镇' + townData.title + '情况'">
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
            :mdata="townData.data"
          ></ChartTown>
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard :title="'各镇' + townDataTwo.title + '情况'">
          <template v-slot:extra>
            <van-button
              @click="handleChangeChartMode('gross', 'townDataTwo')"
              :type="chartModeBtnType('gross', 'townDataTwo')"
              size="mini"
              >总量及增速</van-button
            >
            <van-button
              :type="townDataTwo.vmode == 'table' ? 'info' : 'default'"
              icon="notes-o"
              size="mini"
              @click="handleChangeViewMode('table', 'townDataTwo')"
              >表格模式</van-button
            >
          </template>
          <ChartTown
            :height="240"
            chart-id="chart-towntwo"
            :vmode="townDataTwo.vmode"
            :cmode="townDataTwo.cmode"
            :mdata="townDataTwo.data"
          ></ChartTown>
        </ModuleCard>
      </div>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import PageCard from "@/components/main/page-card.vue";
import { formatStringWrap } from "@/libs/tools";
import chartMixin from "@/libs/chart-mixin.js";
export default {
  mixins: [chartMixin],
  components: {
    PageCard,
  },
  data() {
    return {
      pageName:'',
      curCateName: "",
      echartInstanceCate: null,
      townDataTwo: { title: "" },
    };
  },
  methods: {
    goBack() {
      this.$router.back();
    },
  },
  mounted() {
    const curCate = this.$route.query.cate;
    this.curCateName = curCate
    this.pageName = `${curCate}详情`
    this.chartInit({ chartName: ["cate"] });

    Api.base.get_gdp_hangye_child({ cate: curCate }).then((res) => {
      const resData = res.data;
      this.townData = {
        title: resData.townData.title,
        vmode: "chart",
        cmode: "gross",
        data: {
          tableData: resData.townData.list,
          tableColumn: resData.townData.columns,
        },
      };
      this.townDataTwo = {
        title: resData.townDataTwo.title,
        vmode: "chart",
        cmode: "gross",
        data: {
          tableData: resData.townDataTwo.list,
          tableColumn: resData.townDataTwo.columns,
        },
      };
      this.timelineMonthData = {
        cmode: "rise",
        vmode: "chart",
        title: resData.monthData.title,
        data: {
          tableColumn: resData.monthData.columns,
          tableData: resData.monthData.list,
        },
      };

      this.echartInstance.cate.setOption({
        dataset: { source: resData.cateData.list },
        grid: {
          top: 40,
          left: 60,
          right: 60,
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
          triggerEvent: true,
          axisLabel: {
            fontSize: "12px",
            // rotate: -45,
            formatter: function (value) {
              return formatStringWrap(value, 3);
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
            showBackground: true,
          },
          {
            type: "line",
            yAxisIndex: 1,
          },
        ],
      });
    });
  },
};
</script>

<style lang="less" scoped>
.page-bar {
  display: flex;
  justify-content: space-between;
  padding:.0625rem;
  background:#fff;
  .title {
    font-size:14px;
    font-weight: bold;
  }
}
</style>