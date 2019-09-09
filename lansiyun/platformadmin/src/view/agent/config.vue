<template>
  <div>
    <Card>
      <div slot="title">
        <Tabs :animated="false" value="db">
          <TabPane label="数据库" name="db">
            <DataBase :main-data="configInfo" @on-saved="handleSaved"></DataBase>
          </TabPane>
          <TabPane label="OSS" name="oss">
            <Oss :main-data="configInfo" @on-saved="handleSaved"></Oss>
          </TabPane>
          <TabPane label="服务器" name="server">服务器-待整理资料</TabPane>
          <TabPane label="微信小程序" name="wxmp">小程序-待整理资料</TabPane>
        </Tabs>
      </div>
    </Card>
  </div>
</template>
<script>
import DataBase from "./config-components/db";
import Oss from "./config-components/oss";
import axios from "@/libs/api.request";
export default {
  name: "",
  components: { DataBase, Oss },
  data() {
    return {
      agentId: null,
      configInfo: {}
    };
  },
  methods: {
    handleSaved(data){
      this.configInfo = data
    }
  },
  mounted() {
    const agentId = parseInt(this.$route.params.agentid)
    this.agentId = agentId
    axios
      .request({
        url: "AgentConfig/index",
        params:{agentid:agentId},
        method: "get"
      })
      .then(res => {
        if(res.data.info) {
          this.configInfo = res.data.info;
        }
      });
  }
};
</script>
