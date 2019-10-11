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
        <TabPane label="服务商信息" name="name2">
          <Row>
            <Col span="8">
              <CellGroup>
                <Cell title="服务商名称" :extra="orgInfo.title"></Cell>
                <Cell title="身份类别" :extra="orgInfo.typename"></Cell>
                <Cell title="建立日期" :extra="orgInfo.create_time"></Cell>
                <Cell title="合同开始日期" :extra="orgInfo.contract_start"></Cell>
                <Cell title="合同截至日期" :extra="orgInfo.contract_end"></Cell>
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
      orgInfo: {}
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
      this.orgInfo = res.data.org
    });
  }
};
</script>