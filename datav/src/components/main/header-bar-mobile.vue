<!--
 * @Author: Joy wang
 * @Date: 2021-05-05 19:22:29
 * @LastEditTime: 2021-05-31 04:31:54
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-header-bar">
    <router-link to="/" class="brand-box">
      <div class="brand-name">数字金湾政府数据分析系统</div>
      <!-- <div class="sub-name">工业经济</div> -->
    </router-link>
    <div class="nav">
      <router-link to="/home" class="item link-item link-left">
        <div class="title">经济总览</div>
      </router-link>
      <router-link to="/gdp" class="item link-item link-left">
        <div class="title">地区生产总值</div>
      </router-link>
      <router-link to="/gongye" class="item link-item link-left">
        <div class="title">工业指标</div>
      </router-link>
      <router-link to="/investment" class="item link-item link-left">
        <div class="title">固定资产投资</div>
      </router-link>
      <router-link to="/trade" class="item link-item link-left">
        <div class="title">商务指标</div>
      </router-link>
      <router-link to="/finance" class="item link-item link-right">
        <div class="title">财政预算</div>
      </router-link>
      <router-link to="/transport" class="item link-item link-right">
        <div class="title">机场港口</div>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      curNav: "",
    };
  },
  mounted() {},
};
</script>

<style lang="less" scoped>
.m-header-bar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 999;
  box-sizing: border-box;
  display: flex;
  align-items: center;
  padding: 0 24px;
  height:.291667rem;
  background-color: rgba(0, 50, 200, 0.8);
  .brand-name {
    white-space: nowrap;
    color: #fff;
    font-size: 0.09375rem;
  }
  .sub-name {
    display: inline-block;
    padding: 4px 12px;
    color:#fff;
    line-height: 1;
    background-color:#0066ff;
    border-radius:6px;
  }
}


.nav {
  margin-left:.125rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  width:100%;
  flex-shrink: 1;
}
.nav .link-item {
  box-sizing: border-box;
  display: inline-block;
  text-align: center;
  font-size: 14px;
  color: #fff;
  text-decoration: none;
}
</style>
