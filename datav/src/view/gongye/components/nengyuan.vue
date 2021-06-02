<!--
 * @Author: Joy wang
 * @Date: 2021-06-02 07:13:45
 * @LastEditTime: 2021-06-02 07:50:19
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="wrap">
    <div class="item">
      <div class="section">能源品种实物量消费情况</div>
      <div class="chart-box">
        <Table
          size="small"
          height="280"
          stripe
          :columns="nyxfData.column"
          :data="nyxfData.data"
        />
      </div>
    </div>
    <div class="item">
      <div class="section">能源品种标准量消费情况</div>
      <div class="chart-box">
        <Table
          size="small"
          height="280"
          stripe
          :columns="nyxfData.column"
          :data="nyxfData.data"
        />
      </div>
    </div>
    <div class="item">
      <div class="section">各区社会用电量比较</div>
      <div class="">
        <ChartCompareCounty
          :height="220"
          :mode="compareCountyData.mode"
          :title="compareCountyData.title"
          :chart-data="compareCountyData.data"
        ></ChartCompareCounty>
      </div>
    </div>
    <div class="item">
      <div class="section">工业企业用电量排名前60企业</div>
      <div class="chart-box">
        <Table
          size="small"
          height="280"
          stripe
          :columns="ydljcData.column"
          :data="ydljcData.data"
        />
      </div>
    </div>
  </div>
</template>


<script>
import chartMixin from "@/libs/chart-mixin.js";
import * as Api from "@/api/index";
export default {
  mixins: [chartMixin],
  data() {
    return {
      nyxfData: {
        column: [
          {
            title: "实物量(当量值)",
            key: "title",
            fixed: "left",
            width: "120",
          },
          {
            title: "计量单位",
            key: "measure",
            width: "100",
          },
          {
            title: "总量",
            key: "jw_total",
            sortable: true,
            width: "100",
          },
          {
            title: "同比增长",
            key: "jw_rise",
            sortable: true,
            width: "80",
          },
        ],

        data: [
          {
            title: "原煤",
            measure: "吨",
            jw_total: 1258917,
            jw_rise: 47.3,
          },
          {
            title: "焦炭",
            measure: "吨",
            jw_total: 352495,
            jw_rise: 52.9,
          },
          {
            title: "高炉煤气",
            measure: "吨",
            jw_total: 159424,
            jw_rise: 53.5,
          },
          {
            title: "转炉煤气",
            measure: "万立方米",
            jw_total: 11769,
            jw_rise: 23.3,
          },
          {
            title: "天然气",
            measure: "万立方米",
            jw_total: 40331,
            jw_rise: 73.0,
          },
          {
            title: "液化天然气",
            measure: "万立方米",
            jw_total: 6135,
            jw_rise: 21.3,
          },
          {
            title: "汽油",
            measure: "吨",
            jw_total: 594,
            jw_rise: -18.1,
          },
        ],
      },
      ydljcData: {
        column: [
          {
            title: "企业名称",
            key: "title",
            fixed: "left",
            width: "200",
          },
          {
            title: "所属镇街",
            key: "area",
            width: "100",
          },
          {
            title: "消费量(万千瓦时)",
            key: "total",
            sortable: true,
            width: "120",
          },
          {
            title: "同比增长",
            key: "rise",
            sortable: true,
            width: "100",
          },
        ],

        data: [
          {
            title: "珠海粤裕丰钢铁有限公司",
            area: "南水",
            total: 8059.21,
            rise: 7.11,
          },
          {
            title: "珠海盈德气体有限公司",
            area: "南水",
            total: 6401.16,
            rise: 6.75,
          },
          {
            title: "珠海经济特区广珠发电有限责任公司",
            area: "南水",
            total: 6318.36,
            rise: 74.8,
          },
          {
            title: "珠海碧辟化工有限公司",
            area: "南水",
            total: 4868.74,
            rise: 8.18,
          },
          {
            title: "广东珠海金湾发电有限公司",
            area: "南水",
            total: 4424.51,
            rise: 52.09,
          },
          {
            title: "珠海恩捷新材料科技有限公司",
            area: "南水",
            total: 2795,
            rise: 62.75,
          },
          {
            title: "广东龙丰精密铜管有限公司",
            area: "红旗",
            total: 2694.78,
            rise: 73.23,
          },
        ],
      },
    };
  },
  mounted() {
    /***各区指标对比 */
    Api.jjzb.get_county({ params: { cate: "financeincome" } }).then((res) => {
      this.compareCountyData = {
        mode: "gross",
        title: {},
        data: res.data,
      };
    });
  },
};
</script>

<style lang="less" scoped>
.wrap {
  width: 1800px;
  display: flex;
  justify-content: space-between;
  color: #fff;
  .item {
    margin-bottom: 24px;
    width: 23%;
    .section {
      margin-bottom: 12px;
      font-size: 18px;
    }
  }
}
.chart-box {
  height: 320px;
}
</style>
