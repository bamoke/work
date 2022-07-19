<!--
 * @Author: Joy wang
 * @Date: 2021-05-26 04:10:53
 * @LastEditTime: 2021-05-26 15:47:36
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="circle-wrap">
    <div class="bg-out"></div>
    <div class="bg-inside"></div>
    <slot></slot>
  </div>
</template>

<script>
export default {};
</script>

<style lang="less" scoped>
.circle-wrap {
  width: 100%;
  height: 100%;
  overflow: hidden;
  position: relative;
  .bg-out {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 1;
    width: 100%;
    height: 100%;
    background: url(/bi/assets/images/data-bg-2.png);
    background-repeat: no-repeat;
    background-position: bottom center;
    background-size: contain;
    animation:changeleft 8s linear infinite;
  }
  .bg-inside {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 2;
    width: 100%;
    height: 100%;
    background: url(/bi/assets/images/data-bg-3.png);
    background-repeat: no-repeat;
    background-position: bottom center;
    background-size: contain;
    animation:changeright 8s linear infinite;
  }
}

@keyframes changeright {
  0% {
    -webkit-transform: rotate(0deg);
  }

  50% {
    -webkit-transform: rotate(180deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
  }
}
@keyframes changeleft {
  0% {
    -webkit-transform: rotate(0deg);
  }

  50% {
    -webkit-transform: rotate(-180deg);
  }

  100% {
    -webkit-transform: rotate(-360deg);
  }
}
</style>