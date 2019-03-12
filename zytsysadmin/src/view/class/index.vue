<template>
    <div class="m-class-nav">
      <div class="item-row">
        <div v-on:click="showPage('class_member')" data-to="class_member" class="item">
          <Icon type="person-stalker" size="48" class="icon"></Icon>
          <span class="caption">班级成员</span>
        </div>
        <div v-on:click="showPage('class_notes')" data-to="class_notes" class="item">
          <Icon type="compose" size="48" class="icon"></Icon>
          <span class="caption">课程笔记</span>
        </div>
        <div v-on:click="showPage('class_tests_list')" data-to="class_tests" class="item">
          <Icon type="clock" size="48" class="icon"></Icon>
          <span class="caption">作业考试</span>
        </div>
        <div v-on:click="showPage('class_discuss')" data-to="class_discuss" class="item">
          <Icon type="chatboxes" size="48" class="icon"></Icon>
          <span class="caption">讨论组</span>
        </div>
      </div>
      <div class="item-row">
        <div v-on:click="showPage('class_remark')" data-to="class_remark" class="item">
          <Icon type="star" size="48" class="icon"></Icon>
          <span class="caption">课程点评</span>
        </div>
        <div v-on:click="showPage('class_survey')" data-to="class_survey" class="item">
          <Icon type="clipboard" size="48" class="icon"></Icon>
          <span class="caption">问卷调查</span>
        </div>
        <div v-on:click="showPage('class_dynamic')" data-to="class_dynamic" class="item">
          <Icon type="help-buoy" size="48" class="icon"></Icon>
          <span class="caption">班级动态</span>
        </div>
      </div>
    </div>
</template>
<style>
.m-class-nav .item-row{
  display: flex;
}
.m-class-nav .item {
  display: -webkit-flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-right: 20px;
  margin-bottom:20px;
  width: 160px;
  height: 160px;
  border: 1px solid #f1f1f1;
  text-align: center;
  cursor:pointer;
  transition: all .2s;
}
.m-class-nav .item .caption {
  display: block;
  text-align: center;
  font-size:16px;
}
.m-class-nav .item .icon {
  display: block;
  /* color: #9c9c9c; */
}
.m-class-nav .item:hover {
  color:#fff;
  background-color:#2D8cF0;
}
</style>
<script>
import { getDataOne } from "@/api/data";
import { routeReplace } from "@/libs/util";
export default {
  data() {
    return {
      courseId: null
    };
  },
  methods: {
    showPage(routeName) {
      this.$router.push({ name: routeName });
    }
  },
  mounted() {
    this.courseId = this.$route.params.courseid;
  }
};
</script>
