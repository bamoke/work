<template>
  <div>
    <Row :gutter="20">
      <i-col
        span="6"
        v-for="(infor, i) in inforCardData"
        :key="`infor-${i}`"
        style="height: 120px;"
      >
        <infor-card shadow :color="infor.color" :icon="infor.icon" :icon-size="64">
          <p>{{ infor.title }}</p>
          <count-to :end="infor.count" count-class="count-style" />
        </infor-card>
      </i-col>
    </Row>
    <Row :gutter="20" style="margin-top: 20px;">
      <i-col span="8">
        <Card shadow>
          <chart-pie style="height: 300px;" :value="pieData" text="企业所在地区来源"></chart-pie>
        </Card>
      </i-col>
      <i-col span="16">
        <Card shadow>
          <chart-bar style="height: 300px;" :value="barData" text="月份销售金额" />
        </Card>
      </i-col>
    </Row>
  </div>
</template>

<script>
import InforCard from "_c/info-card";
import CountTo from "_c/count-to";
import { ChartPie, ChartBar } from "_c/charts";
import Example from "./example.vue";
export default {
  name: "home",
  components: {
    InforCard,
    CountTo,
    ChartPie,
    ChartBar,
    Example
  },
  data() {
    return {
      inforCardData: [
        {
          title: "服务商数量",
          icon: "ios-apps",
          count: 803,
          color: "#E91E63"
        },
        { title: "企业数量", icon: "ios-albums", count: 23432, color: "#19be6b" },
        {
          title: "产品数量",
          icon: "ios-basket",
          count: 142,
          color: "#ff9900"
        },
        {
          title: "销售总量",
          icon: "ios-podium",
          count: 657,
          color: "#ed3f14"
        }
      ],
      pieData: [
        { value: 335, name: "华南" },
        { value: 310, name: "华东" },
        { value: 234, name: "华北" },
        { value: 135, name: "中南" },
        { value: 1548, name: "西南" }
      ],
      barData: {
        "2018-11": 1340,
        "2019-12": 5643,
        "2019-01": 1322,
        "2019-02": 1324,
        "2019-03": 1324,
        "2019-04": 1324,
        "2019-05": 1324,
        "2019-06": 13253,
        "2019-07": 34235,
        "2019-08": 26321,
        "2019-09": 12340,
        "2019-10": 24643
      }
    };
  },
  mounted() {
    //
  }
};
</script>

<style lang="less">
.count-style {
  font-size: 36px;
}
</style>
