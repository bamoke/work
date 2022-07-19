<template>
  <div class="login-wrap">
    <div class="login-form-box">
      <div class="img"></div>
      <div class="form-info">
        <div class="login-bar">
          <div class="brand">数字金湾政府数据分析系统</div>
          <div class="title">用户登录</div>
        </div>
        <van-form @submit="onSubmit">
          <van-field
            v-model="username"
            name="用户名"
            label="用户名"
            placeholder="用户名"
            :rules="[{ required: true, message: '请填写用户名' }]"
          />
          <van-field
            v-model="password"
            type="password"
            name="密码"
            label="密码"
            placeholder="密码"
            :rules="[{ required: true, message: '请填写密码' }]"
          />
          <div style="margin-top:24px;">
            <van-button round block type="info" native-type="submit"
              >提交</van-button
            >
          </div>
        </van-form>
      </div>
    </div>
  </div>
</template>

<script>
import { do_login } from "@/api/main.js";
import Cookies from "js-cookie";
import { Toast } from "vant";
export default {
  data() {
    return {
      username: "",
      password: "",
    };
  },
  methods: {
    onSubmit(e) {
      let formData = { username: this.username, password: this.password };
      do_login(formData).then((res) => {
        var cookieExpires;
        Cookies.set("x-access-token", res.data.token, {
          expires: cookieExpires || 1,
        });
        Toast.success("登录成功");
        setTimeout(() => {
          this.$router.push({ name: "home" });
        }, 1000);
      });
    },
  },
};
</script>

<style lang="less" scoped>
.login-wrap {
  width: 100%;
  height: 100%;
  background-color: #0c43b7;
  background-image: url(/demo3/assets/img/main-footer-bg.png);
  background-position: center bottom;
  background-repeat: no-repeat;
  background-size: contain;
}
.login-form-box {
  position: fixed;
  left: 50%;
  top: 45%;
  display: flex;
  margin-left:-1.875rem;
  margin-top: -0.833333rem;

  width:3.75rem;
  height: 1.666667rem;
  // background-color: rgba(255, 255, 255, 1);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
  .img {
    flex: 0 0 auto;
    width:1.875rem;
    background-image: url(/demo3/assets/img/login-bg.jpg);
    background-position: center bottom;
    background-repeat: no-repeat;
    background-size: cover;
  }
  .form-info {
    width:1.875rem;
    padding: 0.125rem;
    background-color: rgba(255, 255, 255, 1);
    .brand {
      font-size: 24px;
      color: #0c43b7;
    }
    .title {
      padding-bottom: 12px;
      font-size: 16px;
      border-bottom: 1px solid #f8f8f8;
    }
  }
}
</style>