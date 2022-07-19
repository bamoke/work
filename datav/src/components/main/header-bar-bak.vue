<!--
 * @Author: Joy wang
 * @Date: 2021-05-05 19:22:29
 * @LastEditTime: 2021-05-28 15:41:14
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-header-bar" ref="headerbar">
    <div class="nav">
      <router-link to="/gdp" class="item link-item link-left" :style="{backgroundColor:itemBgColor}">
        <div class="title">DEMO-3D浅色</div>
      </router-link>
      <router-link to="/gongye" class="item link-item link-left" :style="{backgroundColor:itemBgColor}">
        <div class="title">DEMO-3D深色</div>
      </router-link>
      <router-link to="/investment" class="item link-item link-left" :style="{backgroundColor:itemBgColor}">
        <div class="title">DEMO-扁平深色</div>
      </router-link>
      <div to="/trade" class="item link-item link-left" :style="{backgroundColor:itemBgColor}">
        <div class="title">外贸进出口</div>
      </div>
      <div class="item brand">
        <div class="bg">
          <img src="@/assets/images/nav-bg-line.png" alt="" srcset="" />
        </div>
        <div class="effect">
          <dv-decoration-3 style="width: 400px; height: 30px" />
        </div>
        <span class="brand-name">数字金湾政府数据深度分析系统</span>
      </div>
      <div to="/waishangtouzi" class="item link-item link-right" :style="{backgroundColor:itemBgColor}">
        <div class="title">外商投资</div>
      </div>
      <div to="/retail" class="item link-item link-right" :style="{backgroundColor:itemBgColor}">
        <div class="title">社消零</div>
      </div>
      <div to="/finance" class="item link-item link-right" :style="{backgroundColor:itemBgColor}">
        <div class="title">一般公共预算</div>
      </div>
      <div to="/transport" class="item link-item link-right" :style="{backgroundColor:itemBgColor}">
        <div class="title">机场港口</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    itemBgColor: {
      type: String,
      default: "#0852ae"
    },
  },
};
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
  /* background-color: rgba(0, 10, 25, 0.8); */
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
  /* background-color: #0852ae; */
  background-color: rgba(0, 0, 0, 0.2);
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
  /* background-color: rgba(30, 90, 255, 0.7); */
  background-color: rgba(0, 0, 0, 0.3);
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
