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
      <van-icon
        :name="rate >= 0 ? 'arrow-up' : 'arrow-down'"
        class="trend-icon"
      />
      <span class="rate-num">{{ rate }}%</span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    upColor: {
      type: String,
      default: "#fd653c",
    },
    downColor: {
      type: String,
      default: "#00eb5e",
    },
    size: {
      type: Number,
      default: 14,
    },
    rate: {
      type: [String, Number],
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
  // display: flex;
  // align-items: c;
  padding-left: 6px;
  .trend-icon {
    margin-right: 4px;
    // font-size: 24px;
  }
}
</style>
