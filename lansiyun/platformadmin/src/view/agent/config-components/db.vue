<template>
  <Row :gutter="16">
    <i-col span="18">
      <Form ref="dbForm" :model="configDetail" :rules="configFormRules" :label-width="160">
        <FormItem label="主机名称:" prop="db_host">
          <Input v-model="configDetail.db_host" placeholder="请输入主机名" />
        </FormItem>
        <FormItem label="数据库名称:" prop="db_name">
          <Input v-model="configDetail.db_name" placeholder="请输入数据库名称" />
        </FormItem>
        <FormItem label="数据库用户名:" prop="db_user">
          <Input v-model="configDetail.db_user" placeholder="请输入用户名" />
        </FormItem>
        <FormItem label="数据库密码:" prop="db_password">
          <Input v-model="configDetail.db_password" placeholder="请输入数据库密码" />
        </FormItem>
        <FormItem label="数据表前缀:" prop="db_prefix">
          <Input v-model="configDetail.db_prefix" placeholder="请输入数据表前缀" />
        </FormItem>

        <FormItem>
          <Row :gutter="16">
            <i-col span="8">
              <Button type="primary" long :loading="submitIng" @click="handleSave('dbForm')">保存</Button>
            </i-col>
          </Row>
        </FormItem>
      </Form>
    </i-col>
  </Row>
</template>
<script>
import axios from "@/libs/api.request";
export default {
  name: "",
  props: {
    mainData: {
      type: Object,
      default: {}
    }
  },
  data() {
    return {
      agentId: null,
      configDetail: this.mainData,
      submitIng: false,
      configFormRules: {
        db_host: [{ required: true, message: "请输入主机名" }],
        db_name: [{ required: true, message: "请输入数据库名称" }],
        db_user: [{ required: true, message: "请输入数据库用户名" }],
        db_password: [{ required: true, message: "请输入数据库密码" }],
        db_prefix: [{ required: true, message: "请输入表前缀" }]
      }
    };
  },
  watch: {
    mainData:function(newVal){
      this.configDetail = newVal
    }
  },
  methods: {
    handleSave(formName) {
      this.submitIng = true;
      this.$refs[formName].validate(valid => {
        if (valid) {
          if (!this.configDetail.agent_id) {
            this.configDetail.agent_id = this.agentId;
          }
          axios
            .request({
              url: "AgentConfig/save",
              data: { ...this.configDetail },
              method: "post"
            })
            .then(res => {
              this.$Message.success("Success!");
              this.configDetail = res.data.info;
              this.submitIng = false;
              this.$emit("on-saved", res.data.info);
            });
        } else {
          // this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {}
  },
  mounted() {
    this.agentId = parseInt(this.$route.params.agentid);
  }
};
</script>