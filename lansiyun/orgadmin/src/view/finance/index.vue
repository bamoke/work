<template>
  <Card title="账户总览">
    <div class="base">
      <div class="title">账户余额</div>
      <div class="balance s-text-error">￥200.09</div>
      <div>
        <Button type="error" style="width:80px">充值</Button>
        <Button type="error" ghost style="width:80px">提现</Button>
      </div>
    </div>
    <Divider />
    <div class="total-info"></div>
    <chart-bar style="height: 300px;" :value="barData" text="近12个月收支趋势" subtext="单位:元" />
  </Card>
</template>
<script>
import { ChartBar } from "_c/charts";
export default {
  components: { ChartBar },
  data() {
    return {
      barData: {
        "2018-10": 1324,
        "2018-11": 1324,
        "2018-12": 1324,
        "2019-01": 13253,
        "2019-02": 34235,
        "2019-03": 26321,
        "2019-04": 12340,
        "2019-05": 24643,
        "2019-06": 1322,
        "2019-07": 1324,
        "2019-08": 1324,
        "2019-09": 1324
      }
    };
  }
};
</script>
<style>
.base .title {
  /* font-size:16px; */
  font-weight: bold;
}
.base .balance {
  padding:12px 0;
  font-size:24px;
  line-height: 1;
}
</style>