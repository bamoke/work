<template>
  <div class="m-form-wrap">
    <Form
      ref="importForm"
      :model="curFormData"
      :label-width="120"
      :rules="ruleForm"
      label-position="left"
    >
      <FormItem label="名单文件" prop="file">
        <input type="hidden" v-model.trim="curFormData.file" />
        <Upload type="drag" action="//jsonplaceholder.typicode.com/posts/">
          <div style="padding: 20px 0">
            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
            <p>选择文件或拖拽上传文件</p>
          </div>
        </Upload>
      </FormItem>

      <FormItem label="人才卡类型" prop="type">
        <Select v-model="curFormData.type">
          <Option v-for="item in cateList" :value="item.key" :key="item.key">{{ item.name }}</Option>
        </Select>
      </FormItem>
      <FormItem>
        <Button
          type="primary"
          size="large"
          @click="handleSubmit('importForm')"
          :loading="submitIng"
          style="width:40%"
        >提交</Button>
        <Button @click="handleCancel" size="large" style="width:40%;margin-left: 8px">取消</Button>
      </FormItem>
    </Form>
  </div>
</template>

<script>
import axios from "@/libs/api.request";
export default {
  data() {
    return {
      cateList: [],
      curFormData: {},
      submitIng: false,
      ruleForm: {
        type: [
          {
            required: true,
            message: "请选择所属类型"
          }
        ]
      }
    };
  },
  methods: {
    //submit
    handleSubmit(name) {
      this.curFormData.filename = 'yiliao1102.xlsx';
      this.$refs[name].validate(valid => {
        if (valid) {
          this.submitIng = true;
          axios
            .request({
              url: "TalentPool/save",
              data: { ...this.curFormData },
              method: "post"
            })
            .then(
              res => {
                this.$Message.success("Success!");
                this.$emit("form-saved", res);
                this.submitIng = false;
                this.$refs["accountForm"].resetFields();
              },
              reject => {
                this.$Message.error("系统错误");
                this.submitIng = false;
              }
            );
        } else {
          this.$Message.error("信息填写错误!");
        }
      });
    },
    handleCancel() {
      this.$refs["accountForm"].resetFields();
      this.$emit("on-cancel");
    }
  },
  mounted() {
    axios
      .request({
        url: `TalentPool/getTypeList`,
        method: "get"
      })
      .then(res => {
        this.cateList = res.data.typeCate;
      });
  }
};
</script>

<style>
</style>