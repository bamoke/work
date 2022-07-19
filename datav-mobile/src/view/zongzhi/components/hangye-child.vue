<template>
  <div class="content-wrap">
    <div class="item-wrap">
      <div class="page-bar">
        <div class="title">{{ pageName }}</div>
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
        <ModuleCard :title="curCateName + '近一年累计增速'">
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
      <div class="item-wrap" v-if="hasTownData">
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
      <div class="item-wrap" v-if="hasCountyData">
        <ModuleCard :title="'各区' + compareCountyData.title + '比较'">
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
            :mdata="compareCountyData.data"
          ></ChartCompareCounty>
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
      pageName: "",
      curCateName: "",
      hasTownData:true,
      hasCountyData:true,
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
    this.curCateName = curCate;
    this.pageName = `${curCate}详情`;
    this.chartInit({ chartName: ["cate"] });

    Api.base.get_gdp_hangye_child({ cate: curCate }).then((res) => {
      const resData = res.data;
      this.hasTownData = resData.townData.list.length > 0
      this.hasCountyData = resData.countyData.list.length > 0
      this.townData = {
        title: resData.townData.title,
        vmode: "chart",
        cmode: "gross",
        data: {
          tableData: resData.townData.list,
          tableColumn: resData.townData.columns,
        },
      };

      this.compareCountyData = {
        title: resData.countyData.title,
        vmode: "chart",
        cmode: "gross",
        data: {
          tableData: resData.countyData.list,
          tableColumn: resData.countyData.columns,
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
        title:{
          text:resData.cateData.list[0].date
        },
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
              return formatStringWrap(value, 4);
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
            name:"总量("+resData.cateData.list[0].measure+")",
            showBackground: true,
          },
          {
            type: "line",
            name:'增速(%)',
            yAxisIndex: 1,
          },
        ],
      });
    },reject=>{
      setTimeout(()=>{
        this.$router.back();
      },2000)
    });
  },
};
</script>

<style lang="less" scoped>
.page-bar {
  display: flex;
  justify-content: space-between;
  padding: 0.0625rem;
  background: #fff;
  .title {
    font-size: 14px;
    font-weight: bold;
  }
}
</style>