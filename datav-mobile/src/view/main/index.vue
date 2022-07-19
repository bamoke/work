<template>
  <div class="wrap">
    <div class="top-bar">
      <div class="brand">数字金湾政府数据分析系统</div>
      <div class="logout-btn" @click="handleLogout">
        <van-icon name="user-circle-o" />退出账号
      </div>
    </div>
    <div class="list-wrap">
      <template>
        <div v-for="item of navList" :key="item.title" class="item">
          <a :href="item.simpleUrl" class="simple-box" v-if="item.simpleUrl"
            >大屏简版</a
          >
          <router-link
            :to="{ name: item.url }"
            v-if="item.url"
            class="link-btn"
          >
            <van-icon :name="item.icon" size="76" />
            <div class="title">{{ item.title }}</div>
          </router-link>
          <div v-else>
            <van-icon :name="item.icon" size="76" />
            <div class="title">{{ item.title }}</div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import { get_sys_date, get_sys_nav } from "@/api/main.js";
import Cookies from "js-cookie";
import config from '@/config'
const webBaseUrl = config.webBaseUrl
export default {
  data() {
    return {
      navList: [],
    };
  },
  methods: {
    handleLogout() {
      Cookies.set("x-access-token", null);
      window.location.href = `${webBaseUrl}/login`
    },
  },
  mounted() {
    get_sys_date().then((res) => {
      Cookies.set("curDate", new Date(res.data.end), { expires: 1 });
      Cookies.set("maxDate", new Date(res.data.end), { expires: 1 });
      Cookies.set("minDate", new Date(res.data.start), { expires: 1 });
    });

    get_sys_nav().then((res) => {
      this.navList = res.data.nav;
    });
  },
};
</script>

<style lang="less" scoped>
.wrap {
  height: 100%;
  width: 100%;
  padding-bottom: 0.666667rem;
  background-color: #0c43b7;
  background-image: url(/screen/demo3/assets/img/main-footer-bg.png);
  background-position: center bottom;
  background-repeat: no-repeat;
  background-size: contain;
  .top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 0.0625rem;
    height: 0.25rem;
    line-height: 1;
    border-bottom: 1px solid rgba(255, 255, 255, 0.6);
  }
  .brand {
    color: #fff;
    font-weight: bold;
    font-size: 18px;
  }
  .logout-btn {
    color: #fff;
  }
  .logout-btn:hover {
    opacity: 0.8;
    cursor: pointer;
  }
}
.list-wrap {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  padding: 0.0625rem;
  .item {
    flex: 0 0 auto;
    position: relative;
    margin-bottom: 0.0625rem;
    padding: 0.0625rem;
    width: 32%;
    text-align: center;
    background-color: rgba(255, 255, 255, 1);
    border-radius: 4px;
    overflow: hidden;
    .simple-box {
      position: absolute;
      top: 8px;
      right: -30px;
      z-index: 1;
      width: 120px;
      height: 32px;
      line-height: 32px;
      background-color: #ee3300;
      color: #fff;
      transform: rotate(45deg);
      opacity: 0.8;
    }
    .simple-box:hover {
      opacity: 0.6;
    }
    .link-btn {
      display: block;
      width: 100%;
      height: 100%;
    }
    .title {
      font-size: 16px;
      font-weight: bold;
    }
  }
}
</style>