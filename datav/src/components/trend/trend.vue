<!--
 * @Author: Joy wang
 * @Date: 2021-05-11 18:39:28
 * @LastEditTime: 2021-05-26 06:03:52
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div style="display: inline-block">
    <div class="trend-wrap" :style="style">
      <span>{{ rate }}%</span>
      <Icon
        :type="rate >= 0 ? 'md-arrow-dropup' : 'md-arrow-dropdown'"
        class="trend-icon"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    upColor: {
      type: String,
      default: "#f72268",
    },
    downColor: {
      type: String,
      default: "#00eb5e",
    },
    size: {
      type: Number,
      default: 16,
    },
    rate: {
      type: Number,
      default: 0,
    },
    fill: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      key: "",
    };
  },
  computed: {
    style() {
      var fontSize, color, backgroundColor;
      if (this.fill) {
        fontSize = `${this.size}px`;
        color = "#fff";
        backgroundColor = this.rate > 0 ? this.upColor : this.downColor;
        return { fontSize, color, backgroundColor };
      } else {
        fontSize = `${this.size}px`;
        color = this.rate > 0 ? this.upColor : this.downColor;
        return { fontSize, color };
      }
    },
  },
};
</script>

<style lang="less" scoped>
.trend-wrap {
  display: flex;
  align-items: flex-end;
  padding-left: 6px;
  .trend-icon {
    width: 0.125rem;
    height: 0.125rem;
    font-size: 24px;
  }
}
</style>
