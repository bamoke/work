<!--
 * @Author: Joy wang
 * @Date: 2021-05-06 23:35:53
 * @LastEditTime: 2021-05-29 07:15:07
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-page-card-wrap">
    <div class="bar" v-if="title">
      <div class="title">
        <!-- <Icon type="md-podium" size="24" /> -->
        <span class="text">{{ title }}</span>
      </div>
      <div class="extra">
        <slot name="extra"></slot>
      </div>
    </div>

    <div class="content" ref="ref-page-content">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "PageCard",
  props: {
    title: String,
    icon: String,
  },
  computed: {},
  data() {
    return {};
  },
};
</script>

<style lang="less" scoped>
.m-page-card-wrap {
  position: relative;
  width: 100%;
  height:100%;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  .bar {
    flex:0 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom:12px;
    padding:8px 12px;
    text-align: left;
    border-bottom: 1px solid rgba(0,0,0,.06);
    .text {
      margin-left: 4px;
      font-size: 14px;
      font-weight: bold;
    }
  }
  .content {
    flex-grow: 1;
    padding:0 12px 12px;
  }

}
</style>