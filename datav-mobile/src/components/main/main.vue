<!--
 * @Author: Joy wang
 * @Date: 2021-05-06 12:30:09
 * @LastEditTime: 2021-06-01 10:48:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div style="width: 100%; height: 100%">
    <HeadBar></HeadBar>
    <router-view></router-view>
  </div>
</template>

<script>
import HeadBar from "@/components/main/header-bar.vue";
export default {
  name: "Main",
  components: {
    HeadBar,
  },
  data() {
    return {
      key: "value",
    };
  },
  computed: {

  },
  mounted() {},
};
</script>

<style lang="less">
*:before,
*:after {
  box-sizing: border-box;
}
</style>