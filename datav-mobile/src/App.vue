<!--
 * @Author: Joy wang
 * @Date: 2021-05-05 18:32:55
 * @LastEditTime: 2021-06-01 08:32:07
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div id="app" :class="[appStyleTheme]">
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
    <router-view
      style="height: 100%; position: relative"
      v-if="isRouterAlive"
    />
  </div>
</template>

<script>
// import HeadBar from "./components/common/header-bar.vue";

// import "./theme-flat-light.less";
// import "./theme-flat-dark.less";

import echartTheme from "@/config/echarts-theme.js";
export default {
  name: "app",
  provide() {
    return {
      reload: this.reload,
    };
  },

  components: {},
  data() {
    return {
      isRouterAlive: true,
    };
  },
  computed: {
    appStyleTheme() {
      return this.$store.state.theme.name;
    },
  },
  methods: {
    reload() {
      this.isRouterAlive = false;
      this.$nextTick(function () {
        this.isRouterAlive = true;
      });
    },
    handleChangeTheme(name) {
      this.$store.commit("setTheme", name);

      window.location.reload();
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
  width: 100%;
  height: 100%;
  background-color: #000;
}
* {
  box-sizing: border-box;
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}
#app {
  padding-top: 0.291667rem;
  padding-left: 0.666667rem;
  // font-family: "Avenir", Helvetica, Arial, sans-serif;
  width: 100%;
  height: 100%;
  font-size: 12px;
  color: #232323;
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

.ivu-input {
  font-size: 12px !important;
}
.ivu-radio-wrapper {
  font-size: 12px !important;
}
/**iview table */

// .ivu-table {
//   color: rgba(255, 255, 255, 0.8) !important;
//   background-color: transparent !important;
// }
// .ivu-table:before {
//   display: none;
// }
// .ivu-table td,
// .ivu-table th {
//   border: none !important;
// }
// .ivu-table th {
//   background-color: rgba(3, 53, 129, 0.6) !important;
//   color: #fff;
// }
// .ivu-table td {
//   background-color: transparent !important;
// }
// .ivu-table-stripe .ivu-table-body tr:nth-child(2n) td,
// .ivu-table-stripe .ivu-table-fixed-body tr:nth-child(2n) td {
//   background-color: rgba(3, 53, 129, 0.3) !important;
// }

/*** */
.ivu-row {
  width: 100%;
}
/**button */
.theme-default {
  // .ivu-btn {
  //   color: #0388f0;
  //   background-color: #142564;
  //   border-color: transparent;
  // }
  // .ivu-btn-primary {
  //   color: #fff;
  // }
}

/**主题 */
.theme-default {
  background: #cee0e4;
  // header bar

  //
  .main-bg {
    width: 100%;
    height: 100%;
    display: none;
  }
  // 主内容框架
  .content-wrap {
    padding: 12px;
    box-sizing: border-box;
    width: 100%;
    height: 100%;
    overflow-y: auto;
    .item-wrap {
      margin-bottom: 12px;
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
  }
  .m-table {
    margin: 0;
    padding: 0;
    width: 100%;
    tr:last-child td {
      border-bottom: 1px solid #dfedf6;
    }
    tr:nth-child(2n + 1) td {
      background-color: #f2f9fe;
    }
    th {
      padding: 0.0625rem;
      text-align: left;
      border-left: 1px solid #dfedf6;
      border-top: 1px solid #dfedf6;
      background-color: #e2f3fe;
    }
    th:last-child {
      border-right: 1px solid #dfedf6;
    }
    td {
      padding: 6px 12px;
      text-align: left;
      border-left: 1px solid #dfedf6;
      border-top: 1px solid #dfedf6;
    }
    td:last-child {
      border-right: 1px solid #dfedf6;
    }
  }

  /** */
  .module-slider-wrap {
    width:100%;
    overflow: hidden;
    .module-slider-content {
      display: flex;
      transition: all 0.3s;
      width: 200%;
      height: 100%;

      .table-box {
        flex: 0 0 auto;
        width: 50%;
        height: 100%;
        overflow-y: auto;
      }
      .chart-box {
        flex: 0 0 auto;
        width: 50%;
        height: 100%;
      }
    }
    .show-chart {
      transform: translateX(0);
    }
    .show-table {
      transform: translateX(-50%);
    }
  }
}
/***子菜单 */
.m-child-nav-box {
  position: fixed;
  top: 0.291667rem;
  left: 0;
  bottom: 0;
  width: 0.666667rem;
  background-color: #1b305c;
  .child-nav-item {
    display: block;
    padding: 0.0625rem;
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }
  .router-link-exact-active {
    background-color: rgba(0, 0, 0, 0.2);
    color: rgba(255, 255, 255, 1);
  }
}
</style>
