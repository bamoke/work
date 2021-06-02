<!--
 * @Author: Joy wang
 * @Date: 2021-05-06 23:35:53
 * @LastEditTime: 2021-05-29 07:15:07
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-module-card-wrap">
    <div class="corner corner-top-left"></div>
    <div class="corner corner-top-right"></div>
    <div class="corner corner-bottom-left"></div>
    <div class="corner corner-bottom-right"></div>
    <div class="bar" v-if="title">
      <div class="title">
        <Icon type="md-podium" size="24" />
        <span class="text">{{ title }}</span>
      </div>
      <div class="extra">
        <slot name="extra"></slot>
      </div>
    </div>
    <div class="total" v-if="totalInfo.num">
      <div class="total-num-box">
        <span class="num">{{ totalInfo.num }}</span
        >({{ totalInfo.measure }})
      </div>
      <div class="trend-box" v-if="totalInfo.rise">
        <span>同比</span>
        <Trend :rate="totalInfo.rise" />
      </div>
    </div>
    <div class="content">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "ModuleCard",
  props: {
    title: String,
    icon: String,
    totalInfo: {
      type: Object,
      default: function () {
        return {};
      },
    },
  },
  computed: {},
  data() {
    return {};
  },
};
</script>

<style lang="less" scoped>
.m-module-card-wrap {
  position: relative;
  
  width: 100%;
  background-color: rgba(10, 20, 60, 0.7);
  // background-color: #09153d;
  border: 1px solid rgba(104, 179, 253, 0);
  color: #2a7ac1;
  .corner {
    position: absolute;
    z-index: 1;
    width: 24px;
    height: 24px;
    border: 1px solid #2a7ac1;
    // border: 1px solid rgba(160, 220, 255, 0.9);
    // border: 1px solid rgba(51, 153, 255, 1);
  }
  .corner-top-left {
    top: -1px;
    left: -1px;
    border-bottom-color: transparent;
    border-right-color: transparent;
  }
  .corner-top-right {
    top: -1px;
    right: -1px;
    border-bottom-color: transparent;
    border-left-color: transparent;
  }
  .corner-bottom-left {
    bottom: -1px;
    left: -1px;
    border-top-color: transparent;
    border-right-color: transparent;
  }
  .corner-bottom-right {
    bottom: -1px;
    right: -1px;
    border-top-color: transparent;
    border-left-color: transparent;
  }
  .bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom:12px;
    padding:8px 12px;
    text-align: left;
    color: #fff;
    .text {
      margin-left: 4px;
      font-size: 18px;
    }
  }
  .content {
    padding:0 12px 12px;
  }
  .total {
    display: flex;
    justify-content: flex-start;
    align-items: flex-end;
    padding-right: 16px;
    padding-left:16px;
    padding-bottom:16px;
    .total-num-box {
      margin-right: 0.125rem;
      .num {
        margin-right: 6px;
        font-size: 24px;
        color: #fff;
        // color: #1af2ff;
        font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
      }
    }
    .trend-box {
      display: flex;
      align-items: center;
    }
  }
}
</style>