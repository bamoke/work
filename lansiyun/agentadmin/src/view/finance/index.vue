<template>
  <Card>
    <div class slot="title">账户总览</div>
    <div class="total-info"></div>
    <chart-bar style="height: 300px;" :value="barData" text="近12个月消费趋势" subtext="单位:元" />
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