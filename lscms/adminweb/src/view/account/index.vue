<template>
  <div>
    <Card title="账号信息">
      <Row>
        <Col span="8">
          <CellGroup>
            <Cell title="登录账号" :extra="accountInfo.username"></Cell>
            <Cell title="创建时间" :extra="accountInfo.create_time"></Cell>
            <Cell title="最后登录" extra="2019-08-30 12:34:56"></Cell>
            <Cell title="操作">
              <Button
                type="info"
                slot="extra"
                :to="{name:'account_reset'}"
                @click="handleReset"
              >修改密码</Button>
            </Cell>
          </CellGroup>
        </Col>
      </Row>
    </Card>
  </div>
</template>

<script>
import axios from "@/libs/api.request";
export default {
  components: {},
  data() {
    return {
      accountInfo: {},
      agentInfo: {}
    };
  },
  methods: {
    handleReset() {
      console.log("reset");
    }
  },
  mounted() {
    axios
      .request({
        url: "Account/index"
      })
      .then(res => {
        this.accountInfo = res.data.account;
      });
  }
};
</script>