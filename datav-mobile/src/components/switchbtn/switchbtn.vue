<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 17:44:02
 * @LastEditTime: 2021-05-17 18:02:36
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-swtich-btn">
    <div class="item active">全区</div>
    <div class="item">金湾直属</div>
    <div class="item">开发区</div>
  </div>
</template>

<script>
export default {
    
};
</script>

<style lang="less" scoped>
.m-swtich-btn {
    display: flex;
    background:#040d2e;
    .item {
        padding:0 8px;
        height: .125rem;
        line-height: .125rem;
        cursor: pointer;
    }
    .item:hover {
        opacity: .6;
        color:#0388f0
    }
    .active {
        background-color:#0388f0;
    }
    .active:hover {
        color:#fff;
         opacity: 1
    }
}
</style>
