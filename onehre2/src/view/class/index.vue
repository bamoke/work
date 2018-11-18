<template>
    <div class="m-class-nav">
      <router-link :to="{name:'class_member'}" class="item">
        <span class="caption">班级成员</span>
      </router-link>
      <router-link :to="{name:'class_member'}" class="item">
        <span class="caption">课程笔记</span>
      </router-link>
      <router-link :to="{name:'class_member'}" class="item">
        <span class="caption">作业考试</span>
      </router-link>
      <router-link :to="{name:'class_member'}" class="item">
        <span class="caption">讨论组</span>
      </router-link>
      <router-link :to="{name:'class_member'}" class="item">
        <span class="caption">课程点评</span>
      </router-link>
      <router-link :to="{name:'class_member'}" class="item">
        <span class="caption">问卷调查</span>
      </router-link>
      <router-link :to="{name:'class_member'}" class="item">
        <span class="caption">班级动态</span>
      </router-link>
    </div>
</template>
<style>
.m-class-nav {
  display: flex;
}
.m-class-nav .item {
  margin-right: 20px;
  width: 100px;
  height: 100px;
  border: 1px solid #f1f1f1;
  text-align: center;
}
</style>
<script>
import { getDataOne } from '@/api/data'
export default {
  data () {
    return {
      courseId: null
    }
  },
  mounted () {
    console.log(this.$route.params)
  }
}
</script>
