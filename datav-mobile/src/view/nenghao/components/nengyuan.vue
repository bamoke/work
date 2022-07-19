<!--
 * @Author: Joy wang
 * @Date: 2021-06-02 07:13:45
 * @LastEditTime: 2021-06-02 07:50:19
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="item-wrap">
      <ModuleCard title="工业能源消费总量" class="">
        <template v-slot:extra>单位:({{ nenghaoInfo.measure }})</template>
        <div class="nengyuanxiaofei">
          <div class="content-row">
            <div class="item">
              <div class="val">{{ nenghaoInfo.jw_gross }}</div>
              <div class="section">本期数</div>
            </div>
            <div class="item">
              <div class="val">{{ nenghaoInfo.jw_prev_gross }}</div>
              <div class="section">同期数</div>
            </div>
            <div class="item">
              <div class="val">{{ nenghaoInfo.jw_rise }}</div>
              <div class="section">增长(%)</div>
            </div>
          </div>
        </div>
      </ModuleCard>
    </div>

    <div class="item-wrap">
      <ModuleCard title="规上工业增加值、用电量、综合能源消费量的趋势" class="">
        <div style="height: 240px" id="chart-risecompare"></div>
      </ModuleCard>
    </div>

    <div class="l-row l-row-bt m-content-row">
      <div class="item-wrap">
        <ModuleCard
          title="能源品种实物量消费情况"
          style="min-height: 100%"
          class=""
        >
          <Table
            size="small"
            height="280"
            stripe
            :columns="swlTableInfo.columns"
            :data="swlTableInfo.list"
          />
        </ModuleCard>
      </div>
      <div class="item-wrap">
        <ModuleCard title="能源品种标准量消费情况">
          <Table
            size="small"
            height="280"
            stripe
            :columns="bzlTableInfo.columns"
            :data="bzlTableInfo.list"
          />
        </ModuleCard>
      </div>
    </div>
  </div>
</template>


<script>
import * as Api from "@/api/index";
export default {
  mixins: [],
  data() {
    return {
      nenghaoInfo: {},
      swlTableInfo: { columns: [], list: [] },
      bzlTableInfo: { columns: [], list: [] },
      echartInstance:null
    };
  },
  mounted() {
    const echart = this.$echarts;
    const appTheme = this.$store.state.theme;
    this.echartInstance = echart.init(
      document.getElementById("chart-risecompare"),
      appTheme.echartTheme
    );

    /***能耗 */
    Api.nenghao
      .get_nenghao({ params: { cate: "规上工业能源消费总量" } })
      .then((res) => {
        this.nenghaoInfo = res.data;
      });

    /***能源消费 */
    Api.nenghao.get_nengyuan_use().then((res) => {
      this.swlTableInfo = res.data.swl;
      this.bzlTableInfo = res.data.bzl;
    });

    /***增速比较 */
    Api.nenghao.get_rise_compare().then((res) => {
      this.echartInstance.setOption({
        dataset: { source: res.data },
        title: this.title,
        tooltip: { trigger: "axis" },
        grid: {
          top: 20,
        },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            formatter: function (value) {
              return value;
              // return value.substring(5);
            },
          },
        },
        yAxis: [
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
            type: "line",
            areaStyle: {},
            label: {
              fontWeight: "100",
            },
          },
          {
            type: "line",
          },
          {
            type: "line",
          },
        ],
      });
    });
  },
};
</script>

<style lang="less" scoped>
.chart-box {
  height: 320px;
}
.gdp-nenghao {
  display: flex;
  justify-content: space-between;
  align-items: center;

  .item {
    flex: 0 0 auto;
    width: 40%;
    text-align: center;
    padding: 12px 0;
    border: 1px solid rgba(0, 0, 0, 0.1);
    .val {
      font-size: 16px;
      font-weight: bold;
    }
    .down {
      color: #00cc99;
    }
    .up {
      color: #ff3300;
    }
  }
}
.nengyuanxiaofei {
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
      width: 114px;
      height: 114px;
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
