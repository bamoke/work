<style lang="less">
@import "./login.less";
</style>

<template>
  <div class="login">
    <div class="u-bland" title>
      <a href="javascript:" class="img"></a>
    </div>
    <div class="login-con">
      <Card icon="log-in" :title="title" :bordered="false">
        <div class="form-con">
          <login-form @on-success-valid="handleSubmit"></login-form>
          <p class="login-tip"></p>
        </div>
      </Card>
    </div>
  </div>
</template>

<script>
// import config from "@/config";
import LoginForm from '_c/login-form'
import { mapActions } from 'vuex'
export default {
  components: {
    LoginForm
  },
  data () {
    return {
      title: `欢迎登录`
    }
  },
  methods: {
    ...mapActions(['handleLogin']),
    handleSubmit ({ userName, password }) {
      this.handleLogin({ userName, password }).then(
        res => {
          this.$router.push({
            name: this.$config.homeName
          })
        },
        reject => {}
      )
    }
  }
}
</script>

<style>
</style>
