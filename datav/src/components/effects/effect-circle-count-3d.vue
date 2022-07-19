<!--
 * @Author: Joy wang
 * @Date: 2021-05-29 18:58:17
 * @LastEditTime: 2021-05-29 19:50:42
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
<<<<<<< HEAD
  <div class="wrap">
=======
  <div class="effect-circle-wrap">
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
    <div class="info-box">
      <div class="title">{{ data.title }}</div>
      <div class="count">
        <span class="num">{{ data.num }}</span><span class="measure">{{ data.measure }}</span>
      </div>
      <div class="rise">同比<Trend :rate="data.rise" /></div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    data: {
      type: Object,
      default: function () {
        return {};
      },
    },
  },
};
</script>

<style lang="less" scoped>
<<<<<<< HEAD
.wrap {
=======
.effect-circle-wrap {
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
  display:flex;
  flex-direction: column;
  justify-content: flex-end;
  padding-bottom:60px;
  width: 320px;
  height: 200px;
  color: #fff;
  background-image:url(../../assets/icon/rotate-effect.png);
  background-position: center 80px ;
  background-repeat: no-repeat;
  .title {
      font-size: 18px;
  }
    .num {
        font-size: 42px;
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    }
    .measure {
        color:rgba(255,255,255,.7)
    }
}

</style>
