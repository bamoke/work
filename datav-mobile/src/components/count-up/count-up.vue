<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 20:29:01
 * @LastEditTime: 2021-05-17 20:58:46
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
    <div class="m-count-up">
        <div class="item" v-for="(num,index) in dNumber.toString()" :key="index">{{num}}</div>
    </div>
</template>

<script>
    export default {
        props: {
            dNumber: {
                type: Number,
                default: 0
            },
        },
        data() {
            return {
                numberString: ["0","0","0","0"]
            }
        },
 
    }
</script>

<style lang="less" scoped>
.m-count-up {
    display: inline-block;
    .item {
        display: inline-block;
        margin-right:4px;
        padding: 0 6px;
        height: .25rem;
        line-height: .25rem;
        background: #040d2e;
        color:#fff;
        font-size:.166667rem;
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    }
}
</style>