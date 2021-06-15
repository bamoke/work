<!--
 * @Author: Joy wang
 * @Date: 2021-05-05 18:32:55
 * @LastEditTime: 2021-06-01 08:32:07
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div id="app" :class="[appTheme]">
    <div class="m-theme-box" style="display:none">
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
    <router-view style="height: 100%; position: relative" />
  </div>
</template>

<script>
// import HeadBar from "./components/common/header-bar.vue";

import "./theme-flat-light.less";
import "./theme-flat-dark.less";

import echartTheme from "@/config/echarts-theme.js"
export default {
  name: "app",
  components: {},
  data() {
    return {
      key: "",
    };
  },
  computed: {
    appTheme() {
      console.log(this.$store.state.theme);
      return this.$store.state.theme.name;
    },
  },
  methods: {
    handleChangeTheme(name) {
      this.$store.commit("setTheme", name);

      window.location.reload()
    },
  },

  mounted() {
    // const echartThemName = this.$store.state.theme.echartTheme;
    // this.$echarts.registerTheme(echartThemName, echartTheme[echartThemName]);

  },
};
</script>

<style lang="less">
html {
  height: 100%;
  font-size: 192px;
}
body {
  width: 1920px;
  height: 1080px;
}
* {
  box-sizing: border-box;
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;

  width: 1920px;
  height: 1080px;
  overflow: hidden;
}
.l-row {
  display: flex;
  align-items: center;
}
.l-row-bt {
  justify-content: space-between;
}
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

/**iview table */

.ivu-table {
  color: rgba(255, 255, 255, 0.8) !important;
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
    top: 0;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    padding: 12px;
    padding-top: 90px;
    box-sizing: border-box;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-image: url(./assets/images/map-bg-3d-1.png);
    background-position: center 200px;
    background-repeat: no-repeat;
    background-size: auto 560px;
    .item-wrap {
      margin-bottom: 16px;
    }
    .row-side {
      perspective: 3000px;
      width: 29.25%;
    }
    .row-big {
      position: absolute;
      left: 25.5%;
      top: 90px;
      z-index: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      width: 49%;
    }
    .m-child-nav-box {
      display: flex;
      justify-content: center;
      align-items: center;
      .child-nav-item {
        margin-right: 12px;
        width: 240px;
        height: 80px;
        line-height: 80px;
        text-align: center;
        color: #fff;
        font-size: 18px;
        text-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
        background-image: url(./assets/images/child-nav-bg-2.png);
        background-repeat: no-repeat;
        background-position: center;
      }
      .child-nav-item:hover {
        background-image: url(./assets/images/child-nav-bg-1.png);
      }
    }
  }


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
