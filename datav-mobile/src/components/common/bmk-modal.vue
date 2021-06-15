<!--
 * @Author: Joy wang
 * @Date: 2021-05-29 20:18:57
 * @LastEditTime: 2021-05-31 09:07:36
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="modal-wrap">
    <div class="modal-title">tttttt</div>
    <div class="modal-content">
      <slot></slot>
    </div>
    <div class="model-bt" @click="handleGoback">返回</div>
  </div>
</template>

<script>
export default {

  data() {
    return {
      show: false,
    };
  },
  watch: {
    title(newValue, oldValue) {
        console.log("ssss");
    },
  },
  methods: {
    handleGoback() {
        this.$router.back()
    },
  },
};
</script>

<style lang="less" scoped>
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
  background-image: url(../../assets/images/child-bg.jpg);
  background-size: cover;
  .modal-title {
    margin-bottom: 12px;
    font-size: 24px;
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
