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
        :to="{ name: 'business_waimao' }"
        class="child-nav-item"
      >
        <div class="nav-name">外贸进出口</div>
      </router-link>

      <router-link
        :to="{ name: 'business_waishang' }"
        class="child-nav-item"
      >
        <div class="nav-name">实际吸收外商投资</div>
      </router-link>
      <router-link
        :to="{ name: 'business_xiaofei' }"
        class="child-nav-item"
      >
        <div class="nav-name">社会消费品零售总额</div>
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
