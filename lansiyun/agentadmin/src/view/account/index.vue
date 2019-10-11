<template>
  <div>
    <Card>
      <Tabs value="name1" :animated="false">
        <TabPane label="账号信息" name="name1">
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
        </TabPane>
        <TabPane label="代理信息" name="name2">
          <Row>
            <Col span="8">
              <CellGroup>
                <Cell title="代理商名称" :extra="agentInfo.name"></Cell>
                <Cell title="代理类别" :extra="agentInfo.catename"></Cell>
                <Cell title="代理区域" :extra="agentInfo.agent_area"></Cell>
                <Cell title="建立日期" :extra="agentInfo.create_time"></Cell>
                <Cell title="合同开始日期" :extra="agentInfo.contract_start"></Cell>
                <Cell title="合同截至日期" :extra="agentInfo.contract_end"></Cell>
              </CellGroup>
            </Col>
          </Row>
        </TabPane>
      </Tabs>
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
    axios.request({
      url:'Account/index'
    }).then(res => {
      this.accountInfo = res.data.account
      this.agentInfo = res.data.agent
    });
  }
};
</script>