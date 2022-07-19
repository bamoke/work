<!--
 * @Author: Joy wang
 * @Date: 2021-05-05 19:22:29
 * @LastEditTime: 2021-05-31 04:31:54
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-header-bar">
    <div class="brand-box">
      <router-link :to="{ name: 'home' }" class="brand-name"
        >数字金湾政府数据分析系统</router-link
      >
      <div class="l-row l-row-bt bt">
        <div class="sub-name">经济统计</div>
        <div class="data-box" @click="showDatepicker = true">
          <span class="month-text">{{ selectedDateText }}</span>
          <van-icon name="arrow-down" />
        </div>
      </div>
    </div>
    <div class="nav">
      <router-link class="item link-item" :to="{ name: 'overview' }"
        >经济总览</router-link
      >
      <router-link
        :to="realPath(item)"
        class="item link-item"
        v-for="(item, index) in routerList[0].children"
        :class="{ 'router-link-active': checkNav(item.name) }"
        :key="index"
      >
        <div class="title">{{ item.meta.title }}</div>
      </router-link>
    </div>
    <div class="setting">
      <van-icon name="expand-o" />
      <div @click="hanldleFullScreen">全屏切换</div>
    </div>
    <van-popup v-model="showDatepicker">
      <van-datetime-picker
        v-model="currentDate"
        type="year-month"
        title="选择年月"
        :min-date="minDate"
        :max-date="maxDate"
        :formatter="formatterPickerDate"
        @confirm="handleSelectedDate"
        @cancel="showDatepicker = false"
        class="date-picker"
      />
    </van-popup>
  </div>
</template>

<script>
import routerList from "@/router/routers";
import { Toast } from "vant";
import Cookies from "js-cookie";

export default {
  inject: ["reload"],
  data() {
    return {
      routerList,
      showDatepicker: false,
      curNav: "",
      fullScreen: false,
    };
  },
  computed: {
    minDate() {
      return new Date(Cookies.get("minDate"));
    },
    maxDate() {
      return new Date(Cookies.get("maxDate"));
    },
    currentDate: {
      get() {
        // return new Date("2021-07-28");
        return new Date(Cookies.get('curDate'))
      },
      set(value) {
        Cookies.set("curDate", value, { expires: 1 });
      },
    },
    selectedDateText() {
      var date = new Date(Cookies.get('curDate'));
      var year = date.getFullYear();
      var month = date.getMonth() + 1;
      var newMonth = month > 9 ? `${month}月` : `0${month}月`;
      return `${year}年${newMonth}`;
    },
  },
  methods: {
    checkNav(navName) {
      // console.log(navName)
      var curnavName = this.$route.name;
      if (curnavName.match(navName)) {
        return true;
      } else {
        return false;
      }
    },
    hanldleFullScreen() {
      if (!this.fullScreen) {
        this.fullScreen = true;
        var element = document.documentElement;
        if (element.requestFullscreen) {
          element.requestFullscreen();
        } else if (element.msRequestFullscreen) {
          element.msRequestFullscreen();
        } else if (element.mozRequestFullScreen) {
          element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
          element.webkitRequestFullscreen();
        }
      } else {
        this.fullScreen = false;
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        }
      }
    },
    realPath(item) {
      if (item.children && item.children.length > 0) {
        return item.children[0].path;
      } else {
        return item.path;
      }
    },

    formatterPickerDate(type, val) {
      if (type === "year") {
        return `${val}年`;
      } else if (type === "month") {
        if (val == 1) {
          return;
        }
        return `${val}月`;
      }
      return val;
    },

    handleSelectedDate(e) {
      var date = e;
      var month = e.getMonth();
      if (month == 0) {
        Toast.fail("请选择有效月份");
        return;
      }
      this.showDatepicker = false;

      Cookies.set("curDate", date, { expires: 1 });

      // 重载
      this.reload();
    },
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
  padding: 0 12px;
  height: 0.291667rem;
  background-color: rgba(0, 50, 200, 0.8);
  .brand-name {
    white-space: nowrap;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
  }
  .data-box {
    color: #fff;
  }
  .sub-name {
    display: inline-block;
    // padding: 4px 12px;
    color: #fff;
    line-height: 1;
    // background-color: #0066ff;
    // border-radius: 6px;
  }
  .date-picker {
    width: 1.5625rem;
  }
  .setting {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 120px;
    height: 0.291667rem;
    border-left: 1px solid rgba(255, 255, 255, 0.1);
    color: #fff;
  }
}

.nav {
  margin-left: 0.125rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  flex-shrink: 1;
  .link-item {
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 14.285%;
    padding: 0 2px;
    height: 0.291667rem;
    // line-height: 0.291667rem;
    font-size: 12px;
    color: #fff;
    text-align: center;
    text-decoration: none;
    border-left: 1px solid rgba(255, 255, 255, 0.1);
  }
  .router-link-active {
    background-color: rgba(0, 0, 0, 0.4);
  }
}
@media screen and (max-width:768px) {
  .m-header-bar .setting {
    display: none;
  }
}
</style>
