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
      <router-link :to="{ name: 'gdp' }" class="item link-item link-left">
        <div class="title">地区生产总值</div>
      </router-link>
      <router-link
        :to="{ name: 'gongye_zjz' }"
        class="item link-item link-left"
      >
        <div class="title">工业指标</div>
      </router-link>
      <router-link
        :to="{ name: 'investment' }"
        class="item link-item link-left"
      >
        <div class="title">固定资产投资</div>
      </router-link>
      <router-link :to="{ name: 'trade' }" class="item link-item link-left">
        <div class="title">外贸进出口</div>
      </router-link>
      <div class="item brand">
        <div class="bg">
          <img src="@/assets/images/nav-bg-line.png" alt="" srcset="" />
        </div>
<<<<<<< HEAD
        <a href="http://61.145.230.14:10801/screen/home" class="brand-name">
          数字金湾政府数据分析系统
        </a>
        <div class="date-box">
          <span>数据所属：</span>
          <span class="year">{{ sysDataDate.year }}年</span>
          <span class="month">{{ sysDataDate.month }}</span>
          <span class="subtext">月</span>
        </div>
=======
<<<<<<< HEAD
        <div class="effect">
          <dv-decoration-3 style="width: 400px; height: 30px" />
        </div>
        <span class="brand-name">数字金湾政府数据深度分析系统</span>
=======
        <router-link to="/" class="brand-name">
          数字金湾政府数据深度分析系统
        </router-link>
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
>>>>>>> 23d6d38042cc57823cacef462cf8fdc01e79e502
      </div>
      <router-link
        :to="{ name: 'waishangtouzi' }"
        class="item link-item link-right"
      >
        <div class="title">实际吸收外商投资</div>
      </router-link>
      <router-link :to="{ name: 'retail' }" class="item link-item link-right">
        <div class="title">社消零</div>
      </router-link>
      <router-link :to="{ name: 'finance' }" class="item link-item link-right">
        <div class="title">一般公共预算</div>
      </router-link>
      <router-link
        :to="{ name: 'transport' }"
        class="item link-item link-right"
      >
        <div class="title">机场港口</div>
      </router-link>
    </div>
  </div>
</template>

<script>
<<<<<<< HEAD
export default {};
=======
export default {
  data() {
    return {
      curNav: "",
      sysDataDate: "",
    };
  },
  mounted() {
    setTimeout(() => {
      var currentDate = new Date(this.$store.state.curDate);
      var year = currentDate.getFullYear();
      var month = currentDate.getMonth() + 1;
      var newMonth = month > 9 ? `${month}` : `0${month}`;
      this.sysDataDate = {
        year,
        month: newMonth,
      };
    }, 1000);
  },
};
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
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
<<<<<<< HEAD
  height: .46875rem;
=======
  height: 0.46875rem;
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
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
.date-box {
  display: flex;
  justify-content: center;
  align-items: baseline;
  color: #fff;
  line-height: 1;
  font-size: 18px;
}

.date-box .month {
  margin:0 6px;
  font-size: 36px;
  font-weight: bold;
}
.date-box .month .subtext {
  font-weight: normal;
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
  overflow: hidden;
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
