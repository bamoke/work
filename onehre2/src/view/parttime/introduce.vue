<template>
        <div>
          <Row>
            <i-col :sm=6>显示状态：<span v-bind:class="[parttimeStatus.className]">{{parttimeStatus.name}}</span></i-col>
            <i-col :sm=6>项目状态：<span v-bind:class="parttimeStage.class">{{parttimeStage.name}}</span></i-col>
          </Row>
          <Row>
            <i-col :sm=6>薪资：{{detail.wage}}</i-col>
            <i-col :sm=6>工期：{{detail.work_day}}</i-col>
            <i-col :sm=6>工作地点：{{detail.work_addr}}</i-col>
            <i-col :sm=6>需求人数:{{detail.person_num}}</i-col>
          </Row>
          <Row>
            <i-col :sm=4>兼职要求:</i-col>
            <i-col :sm=18>{{detail.requirement}}</i-col>
          </Row>
          <Row>
            <i-col :sm=4>项目介绍:</i-col>
            <i-col :sm=18 v-html="detail.content"></i-col>
          </Row>
        </div>
</template>

<script>
import { getTableList, deleteDataOne, getDataOne } from "@/api/data";
export default {
  data() {
    return {
      detail: {stage:0},
      stageInfo:[{name:'',class:''}]
    };
  },
  computed: {
    parttimeStatus() {
      let obj;
      if (this.detail.status == 0) {
        obj = { name: "不显示", className: "s-text-warning" };
      } else {
        obj = { name: "显示", className: "s-text-info" };
      }
      return obj;
    },
    parttimeStage() {
      let curStage = this.stageInfo[this.detail.stage]
      return curStage;
    }
  },
  mounted() {
    const parttimeId = this.$route.params.id;
    this.parttimeId = parttimeId;
    getDataOne("Parttime/edit", { id: parttimeId }).then(res => {
      res.info.stage = parseInt(res.info.stage);
      this.detail = res.info;
      this.stageInfo = res.stageName;
    });
  }
};
</script>
