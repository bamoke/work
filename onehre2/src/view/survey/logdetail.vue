<template>
  <Card>
        <div slot="title">
          <p class="u-survey-title"><span class="">《{{surveyInfo.title}}》</span>记录详情</p>
          <div class="">提交时间：{{logInfo.create_time}}</div>
        </div>
        <div class="m-list-box">
          <div class="" v-for="(item,index) in list" :key="index">
              <div class="question-item">
                <span class="nu">{{index+1}}.</span>
                <span class="title">{{item.question.ask}}</span>
                <span class="type" v-if="item.question.type==2">[多选]</span>
              </div>
              <div class="selected-list" v-if="item.question.type !=3">
                <div class="selected-item" v-for="(opt,i) in item.selected" :key="i">
                  <div class="nu">({{i+1}})</div>
                  <div>{{opt.content}}</div>
                </div>
              </div>
              <div class="fill-box" v-else>{{item.fill.content}}</div>
          </div>
        </div>
  </Card>
</template>
<style>
.u-survey-title {margin-bottom:12px;font-size:16rpx;font-weight: bold;}
.question-item .title {font-weight: bold;}
.question-item .nu {font-weight: bold;}
.selected-list,.fill-box {padding:10px;}
.selected-list .selected-item {
  display: flex;
  padding-bottom:10px;
}
.selected-list .selected-item .nu {
  width:40px;
  flex-shrink:0;
  flex-grow:0;
}
</style>

<script>
import { getDataOne } from "@/api/data";
export default {
  data() {
    return {
      curId: null,
      surveyInfo: {},
      logInfo: {},
      list: []
    };
  },
  mounted() {
    // 获取详情
    const curId = this.$route.params.id;
    this.curId = curId;
    getDataOne("/SurveyLog/logdetail", { id: curId }).then(res => {
      if (res.code == 200) {
        if (!res) return;
        this.list = res.data.list;
        this.surveyInfo = res.data.surveyInfo;
        this.logInfo = res.data.logInfo;
      }
    });
  }
};
</script>
