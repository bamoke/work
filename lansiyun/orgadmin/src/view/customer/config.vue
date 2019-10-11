<template>
  <Card :title="pageTitle" icon="ios-options">
    <div>
      <ConfigDetail :config-id="configId" v-if="configId"></ConfigDetail>
      <ConfigForm :page-loaded="showPage" @on-success="handleConfigAdd" v-else></ConfigForm>
    </div>
  </Card>
</template>
<script>
import ConfigForm from "./config-components/config-form";
import ConfigDetail from "./config-components/config-detail";
import axios from "@/libs/api.request";

export default {
  components: { ConfigForm, ConfigDetail },
  data() {
    return {
      showPage: false,
      configId: 0,
      curComName:""
    };
  },
  computed: {
    pageTitle(){
      return "服务配置  ["+this.curComName +"]"
    }
  },
  methods:{
    handleConfigAdd(id){
      this.configId = id
    }
  },
  mounted() {
    const comId = parseInt(this.$route.params.comid);
    this.comId = comId;
    axios
      .request({
        url: "CustomerConfig/index",
        params: { comid: comId },
        method: "get"
      })
      .then(res => {
        this.showPage = true
        this.configId = res.data.configid;
        this.curComName = res.data.comname;
      });
  }
};
</script>