<style lang="less">
  @import './login.less';
</style>

<template>
  <div class="login" id="js-login-box">
    <div class="login-con">
      <div class="logo"></div>
      <Card icon="log-in" :bordered="false">
        <div class="log-title" slot="title">代理商登录</div>
        <div class="form-con">
          <login-form @on-success-valid="handleSubmit"></login-form>
          <p class="login-tip"></p>
        </div>
      </Card>
    </div>
  </div>
</template>

<script>
import config from '@/config'
import Wonder from '@/plugin/canvas-eff/point-line'
import LoginForm from '_c/login-form'
import { mapActions } from 'vuex'
export default {
  components: {
    LoginForm
  },
  data(){
    return {
      title: `欢迎登录${config.title}`
    }
  },
  methods: {
    ...mapActions([
      'handleLogin'
    ]),
    handleSubmit ({ userName, password }) {
      this.handleLogin({ userName, password }).then(res => {
          this.$router.push({
            name: this.$config.homeName
          })
      },reject=>{})
    }
  },
  mounted(){
        new Wonder({
        el: "#js-login-box",
        dotsNumber: 100,
        lineMaxLength: 300,
        dotsAlpha: .5,
        speed: 1.5,
        clickWithDotsNumber: 5
      })
  }
}
</script>

<style>

</style>
