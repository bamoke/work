<!--
 * @Author: Joy wang
 * @Date: 2021-05-06 23:35:53
 * @LastEditTime: 2021-05-29 07:15:07
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-module-card-wrap">
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
  background-color: #fff;
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