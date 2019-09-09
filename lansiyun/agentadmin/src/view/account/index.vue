<template>
  <div>
    <Card>
      <div slot="title">账号信息</div>
      <Row>
        <Col span="2">
          <Avatar shape="square" icon="ios-person" size="large" />
        </Col>
        <Col span="18">
          <div>登录账号：admin</div>
          <div>注册时间：2019-08-02 12:34:56</div>
          <div>最后登录：2019-08-30 12:34:56</div>
          <div>
            <Button type="error" :to="{name:'account_reset'}" @click="handleReset">修改密码</Button>
          </div>
        </Col>
      </Row>
    </Card>
    <Card>
      <div slot="title">代理信息</div>
      <Row>

        <Col span="18">
          <div>代理商名称：实打实打算</div>
          <div>建立日期：2019-08-02</div>
          <div>到期日期：2020-08-02 </div>
        </Col>
      </Row>
    </Card>
  </div>
</template>

<script>
import Main from "@/components/main";
export default {
  components: {},
  methods:{
    handleReset(){
      console.log("reset")
    }
  }
};
</script>