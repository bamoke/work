<template>
  <div>
    <h3>{{questionInfo.title}}</h3>
    <p>{{questionInfo.content}}</p>
    <Divider />
    <Form
      ref="questionVerifyForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="显示状态:">
        <i-switch v-model="formInfo.verify_status" size="large" true-value="1" false-value="0">
          <span slot="open">显示</span>
          <span slot="close">不显示</span>
        </i-switch>
      </FormItem>

      <FormItem label="不显示原因" prop="verify_reason">
        <Input
          type="textarea"
          :autosize="{minRows: 3,maxRows: 6}"
          v-model="formInfo.verify_reason"
        />
      </FormItem>

      <FormItem>
        <Row :gutter="16">
          <i-col span="8">
            <Button @click="handleCancel" size="large" long>取消</Button>
          </i-col>
          <i-col span="8">
            <Button
              type="primary"
              size="large"
              @click="handleSubmit('questionVerifyForm')"
              :loading="submitIng"
              long
            >提交</Button>
          </i-col>
        </Row>
      </FormItem>
    </Form>
  </div>
</template>

<script>
import axios from "@/libs/api.request";
export default {
  name: "questionVerifyForm",
  props: {
    id: {
      type: Number,
      default: null
    }
  },
  data() {
    const validateReason = (rule, value, callback) => {
      if (value === "" && this.formInfo.verify_status == "0") {
        callback(new Error("请填写原因"));
      }
      callback()
    };
    return {
      submitIng: false,
      ruleForm: {
        verify_reason: [{ validator: validateReason, trigger: "blur" }]
      },
      formInfo: { verify_status: "1" },
      questionInfo: {}
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        this.formInfo = { verify_status: "1" };
        this.questionInfo = {};
        return;
      }
      axios
        .request({
          url: `AdviserQuestion/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = {
            id: newValue,
            verify_status: res.data.info.verify_status,
            verify_reason: res.data.info.verify_reason
          };
          this.questionInfo = res.data.info;
        });
    }
  },
  methods: {
    handleSubmit(name) {
      //   this.submitIng = true;
      this.$refs[name].validate(valid => {
          if (valid) {
          axios
            .request({
              url: "AdviserQuestion/save",
              data: { ...this.formInfo },
              method: "post"
            })
            .then(
              res => {
                this.$Message.success("Success!");
                this.$emit("form-saved", res);
                this.submitIng = false;
                this.$refs["questionVerifyForm"].resetFields();
              },
              reject => {
                this.$Message.error("系统错误");
                this.submitIng = false;
              }
            );
        } else {
        //   this.$Message.error(valid);
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      // closeCurPage(this)
      this.$emit("on-cancel");
      this.$refs["questionVerifyForm"].resetFields();
    }
  },
  computed: {},
  mounted() {}
};
</script>
<style>
</style>
