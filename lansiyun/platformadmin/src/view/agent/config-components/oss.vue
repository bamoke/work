<template>
  <Row :gutter="16">
    <i-col span="18">
      <Form ref="ossForm" :model="configDetail" :rules="configFormRules" :label-width="160">
        <FormItem label="Access ID:" prop="oss_id">
          <Input v-model="configDetail.oss_id" placeholder />
        </FormItem>
        <FormItem label="Access Key:" prop="oss_key">
          <Input v-model="configDetail.oss_key" placeholder />
        </FormItem>
        <FormItem label="Endpoint:" prop="oss_endpoint">
          <Input v-model="configDetail.oss_endpoint" placeholder />
        </FormItem>
        <FormItem label="Bucket:" prop="oss_bucket">
          <Input v-model="configDetail.oss_bucket" placeholder />
        </FormItem>

        <FormItem>
          <Row :gutter="16">
            <i-col span="8">
              <Button type="primary" long :loading="submitIng" @click="handleSave('ossForm')">保存</Button>
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
        oss_id: [{ required: true, message: "请输入Access ID" }],
        oss_key: [{ required: true, message: "请输入Access KEY" }],
        oss_endpoint: [{ required: true, message: "请输入 ENDPOINT" }],
        oss_bucket: [{ required: true, message: "请输入 BUCKET" }]
      }
    };
  },
  watch: {
    mainData: function(newVal) {
      this.configDetail = newVal;
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