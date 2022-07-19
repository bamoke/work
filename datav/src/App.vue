<!--
 * @Author: Joy wang
 * @Date: 2021-05-05 18:32:55
 * @LastEditTime: 2021-06-01 08:32:07
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
<<<<<<< HEAD
  <div id="app" :class="className">
    <router-view style="height: 100%" />
=======
  <div id="app" :class="[appTheme]">
    <div class="m-theme-box" style="display: none">
      <div class="theme-section">主题样式</div>
      <div class="theme-list">
        <div class="item" @click="handleChangeTheme('theme-default')">默认</div>
        <div class="item" @click="handleChangeTheme('theme-flat-light')">
          扁平浅色
        </div>
        <div class="item" @click="handleChangeTheme('theme-flat-dark')">
          扁平深色
        </div>
      </div>
    </div>
<<<<<<< HEAD
    <router-view
      style="width: 1920px; height: 1080px"
      :style="{
        transform: 'scale(' + zoomScale + ')',
        top: topOffset + 'px',
        left: leftOffset + 'px',
      }"
      class="bigscreen-box"
      v-if="isRouterAlive"
    />
=======
    <router-view style="height: 100%; position: relative" />
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
>>>>>>> 23d6d38042cc57823cacef462cf8fdc01e79e502
  </div>
</template>

<script>
// import HeadBar from "./components/common/header-bar.vue";
<<<<<<< HEAD
import { get_sys_date } from "@/api/main.js";
import "./theme-flat-light.less";
import "./theme-flat-dark.less";

import echartTheme from "@/config/echarts-theme.js";
=======

<<<<<<< HEAD
=======
import "./theme-flat-light.less";
import "./theme-flat-dark.less";

import echartTheme from "@/config/echarts-theme.js"
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
>>>>>>> 23d6d38042cc57823cacef462cf8fdc01e79e502
export default {
  name: "app",
  components: {},
  provide() {
    return {
      reload: this.reload,
    };
  },
  data() {
    return {
<<<<<<< HEAD
      zoomScale: 1,
      topOffset: 0,
      leftOffset: 0,
      isRouterAlive: false,
=======
<<<<<<< HEAD
      theme: "default",
    };
  },
  computed: {
    className() {
      return `theme-${this.theme}`;
    },
  },
  mounted() {},
=======
      key: "",
>>>>>>> 23d6d38042cc57823cacef462cf8fdc01e79e502
    };
  },
  computed: {
    appTheme() {
      return this.$store.state.theme.name;
    },
  },
  methods: {
    handleChangeTheme(name) {
      this.$store.commit("setTheme", name);

      window.location.reload();
    },
    reload() {
      this.isRouterAlive = false;
      this.$nextTick(function () {
        this.isRouterAlive = true;
      });
    },
    winResize() {
      var documentWidth = window.document.documentElement.clientWidth;
      var documentHeight = window.document.documentElement.clientHeight;
      var topOffset = 0;
      var leftOffset = 0;
      var zoomScale = 1;

      if (documentWidth * 1080 > documentHeight * 1920) {
        zoomScale = parseFloat(documentHeight / 1080);
        leftOffset = (documentWidth - 1920 * zoomScale) / 2;
      } else {
        zoomScale = parseFloat(documentWidth / 1920);
        topOffset = (documentHeight - 1080 * zoomScale) / 2;
      }
      this.zoomScale = zoomScale;
      this.topOffset = topOffset;
      this.leftOffset = leftOffset;
    },
  },

  mounted() {
    this.winResize();
    window.onresize = () => {
      return this.winResize();
    };

    get_sys_date().then((res) => {
      this.$store.commit("setCurDate", new Date(res.data.end));
      this.$store.commit("setMaxDate", new Date(res.data.end));
      this.$store.commit("setMinDate", new Date(res.data.start));
      this.isRouterAlive = true;
    });
  },
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
};
</script>

<style lang="less">
html {
  height: 100%;
  font-size: 192px;
  background: #000;
}
body {
  width: 100%;
  height: 100%;
}
* {
  box-sizing: border-box;
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  position: relative;
  text-align: center;

<<<<<<< HEAD
  width: 100%;
  height: 100%;
  overflow: hidden;
  background-color: #000;
}
.bigscreen-box {
  position: absolute;
  transform-origin: left top;
=======
<<<<<<< HEAD
  width: 100%;
  height: 100%;
=======
  width: 1920px;
  height: 1080px;
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
>>>>>>> 23d6d38042cc57823cacef462cf8fdc01e79e502
  overflow: hidden;
}
.l-row {
  display: flex;
  align-items: center;
}
.l-row-bt {
  justify-content: space-between;
}
<<<<<<< HEAD
=======
.m-theme-box {
  position: fixed;
  top: 0;
  right: -100px;
  z-index: 9999;
  display: flex;
  width: 120px;
  font-size: 12px;
  transition: all 0.2s;
  .theme-section {
    flex: 0 0 auto;
    padding: 6px 4px;
    width: 24px;
    color: #fff;
    background-color: royalblue;

    cursor: pointer;
    border-right: 1px solid rgba(255, 255, 255, 0.3);
  }
  .theme-list {
    flex: 1 1 auto;
  }
  .item {
    flex: 0 1 auto;
    padding: 4px 12px;
    text-align: left;
    // background-color: rgba(0, 0, 0, 0.2);
    background-color: royalblue;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    cursor: pointer;
  }
  .item:hover {
    opacity: 0.8;
  }
}
.m-theme-box:hover {
  right: 0;
}
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3

/**iview table */

.ivu-table {
<<<<<<< HEAD
  color: rgba(255, 255, 255, .8) !important;
=======
  color: rgba(255, 255, 255, 0.8) !important;
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
  background-color: transparent !important;
}
.ivu-table:before {
  display: none;
}
.ivu-table td,
.ivu-table th {
  border: none !important;
}
.ivu-table th {
  background-color: rgba(3, 53, 129, 0.6) !important;
  color: #fff;
}
.ivu-table td {
  background-color: transparent !important;
}
.ivu-table-stripe .ivu-table-body tr:nth-child(2n) td,
.ivu-table-stripe .ivu-table-fixed-body tr:nth-child(2n) td {
  background-color: rgba(3, 53, 129, 0.3) !important;
}

.ivu-spin-fix {
  background: rgba(0, 0, 0, 0.6);
}
.demo-spin-icon-load {
  animation: ani-demo-spin 1s linear infinite;
}
@keyframes ani-demo-spin {
  from {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(180deg);
  }
  to {
    transform: rotate(360deg);
  }
}
/*** */
.ivu-row {
  width: 100%;
}
/**button */
.theme-default {
  .ivu-btn {
    color: #0388f0;
    background-color: #142564;
    border-color: transparent;
  }
  .ivu-btn-primary {
    color: #fff;
  }
}

/**主题 */
.theme-default {
  color: #2c3e50;
  // header bar
  .m-header-bar {
    background-color: transparent !important;
    .nav .link-item {
      background-color: rgba(0, 0, 0, 0.2);
    }
    .nav .router-link-exact-active {
      background-color: rgba(30, 90, 255, 0.7);
    }
  }
  //
  .main-bg {
    width: 100%;
    height: 100%;
    display: none;
  }
  // 主内容框架
  .content-wrap {
    position: absolute;
    left: 0;
<<<<<<< HEAD
    top:0;
=======
    top: 0;
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
    z-index: 1;
    display: flex;
    justify-content: space-between;
    padding: 12px;
    padding-top: 90px;
    box-sizing: border-box;
    width: 100%;
    height: 100%;
    overflow: hidden;
    .item-wrap {
<<<<<<< HEAD
      margin-bottom: 0.083333rem;
=======
      margin-bottom: 16px;
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
    }
    .row-side {
      perspective: 3000px;
      width: 29.25%;
    }
    .row-big {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding-top: 0.333333rem;
      width: 49%;
    }
    .m-child-nav-box {
      display: flex;
      justify-content: center;
      align-items: center;
      .child-nav-item {
        margin-right: 12px;
        width: 240px;
        height: 72px;
        line-height: 72px;
        text-align: center;
        color: #fff;
        font-size: 18px;
        text-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
        background-image: url(./assets/images/child-nav-bg-2.png);
        background-repeat: no-repeat;
        background-position: center;
        cursor: pointer;
      }
      .child-nav-item-active {
        background-image: url(./assets/images/child-nav-bg-1.png);
      }
      .child-nav-item:hover {
        background-image: url(./assets/images/child-nav-bg-1.png);
      }
    }
  }
<<<<<<< HEAD
}
// 中间底部内容区
.m-middle-slider-wrap {
  .slider-btn-bar {
    display: flex;
    // justify-content: space-between;
    margin-bottom: 12px;
    padding: 12px 0;
    font-size: 18px;
    color: #fff;
    line-height: 1;
    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    .item {
      position: relative;
      margin-right: 24px;
      padding: 0 12px;
      height: 32px;
      line-height: 32px;
      background-color: rgba(0, 0, 0, 0.2);
      cursor: pointer;
    }
    .item::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      width: 12px;
      height: 12px;
      border-left: 2px solid rgba(255, 255, 255, 0.6);
      border-top: 2px solid rgba(255, 255, 255, 0.6);
    }
    .item::after {
      content: "";
      position: absolute;
      width: 12px;
      height: 12px;
      right: 0;
      bottom: 0;
      border-right: 2px solid rgba(255, 255, 255, 0.6);
      border-bottom: 2px solid rgba(255, 255, 255, 0.6);
    }
    .current {
      background-color: #2a3c54;
      color: #1cfafc;
    }
    .current::before {
      border-color: #1cfafc;
    }
    .current::after {
      border-color: #1cfafc;
    }
  }
}
=======

<<<<<<< HEAD
=======

}
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
  // 中间底部内容区
  .m-middle-slider-wrap {
    .slider-btn-bar {
      display: flex;
      // justify-content: space-between;
      margin-bottom: 12px;
      padding: 12px 0;
      font-size: 18px;
      color: #fff;
      line-height: 1;
      border-bottom: 1px solid rgba(0, 0, 0, 0.2);
      .item {
        position: relative;
        margin-right: 24px;
        padding: 0 12px;
        height: 32px;
        line-height: 32px;
        background-color: rgba(0, 0, 0, 0.2);
        cursor: pointer;
      }
      .item::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 12px;
        height: 12px;
        border-left: 2px solid rgba(255, 255, 255, 0.6);
        border-top: 2px solid rgba(255, 255, 255, 0.6);
      }
      .item::after {
        content: "";
        position: absolute;
        width: 12px;
        height: 12px;
        right: 0;
        bottom: 0;
        border-right: 2px solid rgba(255, 255, 255, 0.6);
        border-bottom: 2px solid rgba(255, 255, 255, 0.6);
      }
      .current {
        background-color: #2a3c54;
        color: #1cfafc;
      }
      .current::before {
        border-color: #1cfafc;
      }
      .current::after {
        border-color: #1cfafc;
      }
    }
  }
<<<<<<< HEAD
}
=======
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
>>>>>>> 23d6d38042cc57823cacef462cf8fdc01e79e502

.theme-default .m-module-card-wrap {
  background-color: rgba(0, 0, 0, 0.2) !important;
  color: #fff !important;
}
.theme-default .m-module-card-wrap .corner {
  display: none;
  border-color: rgba(255, 255, 255, 0.4);
}
.theme-default .m-module-card-wrap .corner-top-right {
  border-left-color: transparent;
  border-bottom-color: transparent;
}
.theme-default .m-module-card-wrap .corner-top-left {
  border-right-color: transparent;
  border-bottom-color: transparent;
}
.theme-default .m-module-card-wrap .corner-bottom-right {
  border-left-color: transparent;
  border-top-color: transparent;
}
.theme-default .m-module-card-wrap .corner-bottom-left {
  border-right-color: transparent;
  border-top-color: transparent;
}
.theme-default .m-module-card-wrap .bar {
  background-color: rgba(0, 0, 0, 0.2);
}

.theme-default .row-side .bt-shadow {
  // padding-bottom:48px;
  width: 100%;
  height: 64px;
  background: url(./assets/images/side-shadow.png);

  background-repeat: no-repeat;
  background-size: contain;
}
.theme-default .row-side:last-child .bt-shadow {
  background-position: right bottom;
}
.theme-default .row-side:first-child .bt-shadow {
  background-position: left bottom;
  transform: rotateX(150deg);
}
.theme-default .row-side:first-child .transform-box {
  transform: rotateY(30deg);
  transform-origin: left center;
}
.theme-default .row-side:last-child .transform-box {
  transform: rotateY(-30deg);
  transform-origin: right center;
}
.theme-default .row-side .item-wrap:last-child {
  margin: 0;
}
</style>
