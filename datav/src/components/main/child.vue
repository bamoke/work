<!--
 * @Author: Joy wang
 * @Date: 2021-05-29 20:31:22
 * @LastEditTime: 2021-06-01 19:21:26
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>

    <div class="modal-wrap">
      <div class="modal-title">{{title}}</div>
      <div class="modal-content">
        <router-view></router-view>
      </div>
      <div class="model-bt" @click="handleGoback">返回</div>
    </div>

</template>

<script>
import HeadBar from "@/components/main/header-bar.vue";
export default {
  components: {HeadBar},
  data() {
      return {
          title: ""
      }
  },
  methods: {
    handleGoback() {
      this.$router.back();
    },
  },
  mounted () {
      console.log(this.$route);
      this.title = this.$route.meta.title
  },
};
</script>

<style lang="less">
// ::-webkit-scrollbar {
//   width: 12px;
//   height: 12px;
//   background-color: transparent;
// }

// /*定义滚动条轨道 内阴影+圆角*/
// ::-webkit-scrollbar-track {
//   -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
//   border-radius: 10px;
//   background-color: #040d2e;
// }

// /*定义滑块 内阴影+圆角*/
// ::-webkit-scrollbar-thumb {
//   border-radius: 6px;
//   -webkit-box-shadow: inset 0 0 4px rgba(0, 0, 0, 5);
//   background-color: #4695ee;
// }

.modal-wrap {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9999;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.5);
  background-image: url(/demo2/assets/img/theme-defualt-bg.jpg);
  background-size: cover;
  .modal-title {
    margin-bottom: 12px;
    font-size: 32px;
    color: #fff;
  }
  .modal-content {
    padding: 24px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: -webkit-linear-gradient(
      top,
      rgba(255, 255, 255, 0.1) 0%,
      rgba(255, 255, 255, 0) 100%
    );
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  }
  .model-bt {
      margin-top:48px;
      background: rgba(255, 255, 255, 1);
      width:320px;
      height: 48px;
      line-height: 48px;
      border-radius: 24px;
      font-size:18px;
      text-align: center;
      cursor: pointer;
      color:#000;
      border:1px solid rgba(255, 255, 255, 1);
      transition: opacity .2s;
  }
  .model-bt:hover {
      opacity:.8;
  }
}
</style>
