<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:50:57
 * @LastEditTime: 2021-05-30 10:46:30
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div style="width: 100%; height: 100%">
    <div class="m-child-nav-box">
      <router-link
        :to="{ name: 'finance_imcome' }"
        class="child-nav-item"
      >
        <div class="nav-name">一般公共预算收入</div>
      </router-link>

      <router-link
        :to="{ name: 'finance_expend' }"
        class="child-nav-item"
      >
        <div class="nav-name">一般公共预算支出</div>
      </router-link>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import { formatStringWrap } from "@/libs/tools.js";

export default {
  data() {
    return {};
  },
  methods: {},
  mounted() {},
};
</script>

<style lang="less" scoped>
</style>
