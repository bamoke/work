<template>
  <div class="m-base-total item-wrap">
    <div class="item item-gross">
      <van-icon name="points" size="56" class="icon" />
      <div class="info">
        <div class="val">{{ total.gross }}</div>
        <div class="section">{{ total.title }}({{ total.measure }})</div>
      </div>
    </div>
    <div class="item item-rise">
      <van-icon name="chart-trending-o" size="56" class="icon" />
      <div class="info">
        <div class="val" :style="colorStyle">{{ total.rise }}%</div>
        <div class="section">同比增长</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    total: {
      type: Object,
      default: function () {
        return {};
      },
    },
  },
  computed: {
    colorStyle() {
      var color;
      var rise = Number(this.total.rise);

      if (isNaN(rise)) {
        color = "#969696";
      } else {
        if (rise >= 0) {
          color = "#dd2416";
        } else {
          color = "#00cc66";
        }
      }
      return { color };
    },
  },
};
</script>

<style lang="less" scoped>
.m-base-total {
  display: flex;
  justify-content: space-between;
  .item {
    box-sizing: border-box;
    flex: 0 0 auto;
    padding: 0.0625rem;
    width: 49.25%;
    display: flex;
    align-items: center;
    background: #fff;
    line-height: 1;
    .icon {
      flex: 0 0 auto;
      margin-right: 12px;
      opacity: 0.6;
    }
  }
  .item-gross {
    .val {
      margin-bottom: 4px;
      color: #ff3300;
    }
  }
  .item-rise {
    .val {
      margin-bottom: 4px;
      color: #dd2416;
    }
  }
  .val {
    margin-top: 8px;
    font-weight: 500;
    font-size: 24px;
    font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
  }
}
</style>