<!--
 * @Author: Joy wang
 * @Date: 2021-05-05 19:22:29
 * @LastEditTime: 2021-05-31 04:31:54
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-header-bar">
    <div class="nav">
      <router-link to="/gdp" class="item link-item link-left">
        <div class="title">地区生产总值</div>
      </router-link>
      <router-link to="/gongye" class="item link-item link-left">
        <div class="title">工业经济</div>
      </router-link>
      <router-link to="/investment" class="item link-item link-left">
        <div class="title">固定资产投资</div>
      </router-link>
      <router-link to="/trade" class="item link-item link-left">
        <div class="title">外贸进出口</div>
      </router-link>
      <div class="item brand">
        <div class="bg">
          <img src="@/assets/images/nav-bg-line.png" alt="" srcset="" />
        </div>
        <div class="effect">
          <dv-decoration-3 style="width: 400px; height: 30px" />
        </div>
        <span class="brand-name">数字金湾政府数据深度分析系统</span>
      </div>
      <router-link to="/waishangtouzi" class="item link-item link-right">
        <div class="title">实际吸收外商投资</div>
      </router-link>
      <router-link to="/retail" class="item link-item link-right">
        <div class="title">社消零</div>
      </router-link>
      <router-link to="/finance" class="item link-item link-right">
        <div class="title">一般公共预算</div>
      </router-link>
      <router-link to="/transport" class="item link-item link-right">
        <div class="title">机场港口</div>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
.m-header-bar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 999;
  box-sizing: border-box;
  padding: 0 24px;
  height: .46875rem;
  background-color: rgba(0, 10, 25, 0.8);
}

.app-name {
  font-size: 48px;
}
.nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.nav .link-item {
  box-sizing: border-box;
  display: inline-block;
  width: 180px;
  height: 50px;
  line-height: 50px;
  background-color: #0852ae;
  text-align: center;
  color: #fff;
  font-size: 14px;
  /* transform: skew(-30deg); */
  text-decoration: none;
}
.link-left {
  transform: skew(30deg);
  border-left: 1px solid rgba(255, 255, 255, 0.4);
}
.link-right {
  transform: skew(-30deg);
  border-right: 1px solid rgba(255, 255, 255, 0.4);
}

.nav .link-item:hover {
  background-color: rgba(30, 90, 255, 0.7);
}
.nav .link-left .title {
  transform: skew(-30deg);
}
.nav .link-right .title {
  transform: skew(30deg);
}
.nav .brand {
  position: relative;
}
.nav .brand .brand-name {
  position: absolute;
  top: -5px;
  left: 0;
  width: 100%;
  height: 78px;
  z-index: 2;
  line-height: 78px;
  font-size: 36px;
  color: #fff;
}
.effect {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  text-align: center;
  width: 300px;
}
</style>
