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
          <count-to :end="infor.count" count-class="count-style"/>
        </infor-card>
      </i-col>
    </Row>
    <Row :gutter="20" style="margin-top: 20px;">
      <i-col span="8">
        <Card shadow>
          <chart-pie style="height: 300px;" :value="pieData" text="用户访问来源"></chart-pie>
        </Card>
      </i-col>
      <i-col span="16">
        <Card shadow>
          <chart-bar style="height: 300px;" :value="barData" text="每周用户活跃量"/>
        </Card>
      </i-col>
    </Row>
  </div>
</template>

<script>
import axios from "@/libs/api.request";
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
        { title: "讲师数量", icon: "university", count: 0, color: "#E91E63" },
        { title: "课程数量", icon: "easel", count: 0, color: "#19be6b" },
        {
          title: "学员数量",
          icon: "person-stalker",
          count: 0,
          color: "#ff9900"
        },
        {
          title: "评论统计",
          icon: "chatbox-working",
          count: 0,
          color: "#ed3f14"
        }
      ],
      pieData: [
        { value: 335, name: "直接访问" },
        { value: 310, name: "邮件营销" },
        { value: 234, name: "联盟广告" },
        { value: 135, name: "视频广告" },
        { value: 1548, name: "搜索引擎" }
      ],
      barData: {
        Mon: 13253,
        Tue: 34235,
        Wed: 26321,
        Thu: 12340,
        Fri: 24643,
        Sat: 1322,
        Sun: 1324
      }
    };
  },
  mounted() {
      const myAjax = axios.request({
          url: "Index/home",
          method: "get"
        })
      myAjax.then(res => {
        const newInfoCard = this.inforCardData
        newInfoCard[0].count = res.data.teahcerNum
        newInfoCard[1].count = res.data.courseNum
        newInfoCard[2].count = res.data.memberNum
        newInfoCard[3].count = res.data.commentNum
        this.inforCardData = newInfoCard
      });
  }
};
</script>

<style lang="less">
.count-style {
  font-size: 36px;
}
</style>
