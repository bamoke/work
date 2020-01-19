<template>
  <Card>
    <p slot="title">公司介绍</p>
    <Form
      ref="singleForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="内容详情:">
        <Editor
          v-model="formInfo.content"
          :cache="false"
          :upload-url="contentUploadUrl"
          @on-change="handleEditorChange"
        />
      </FormItem>
      <FormItem>
        <Row :gutter="16">
          <i-col span="8">
            <Button
              type="primary"
              size="large"
              @click="handleSubmit('singleForm')"
              :loading="submitIng"
              long
            >提交</Button>
          </i-col>
        </Row>
      </FormItem>
    </Form>
  </Card>
</template>

<script>
import Editor from "_c/editor";
import axios from "@/libs/api.request";
export default {
  name: "company",
  components: { Editor },
  props: {
    id: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
      submitIng: false,
      ruleForm: {
        title: [{ required: true, message: "请输入活动标题" }]
      },
      formInfo: { content: "" },
      newContent: "",
      contentUploadUrl: this.$config.uploadUrl + '/save'
    };
  },
  methods: {
    handleEditorChange(html, text) {
      this.newContent = html;
    },
    handleSubmit(name) {
      if(this.newContent){
        this.formInfo.content = this.newContent;
      }
      this.submitIng = true;
      if (this.formInfo.content != '') {
        axios
          .request({
            url: "Single/update",
            data: { ...this.formInfo },
            method: "post"
          })
          .then(res => {
            this.$Message.success("Success!");
            this.submitIng = false;
          });
      } else {
        this.$Message.error("内容不能为空!");
        this.submitIng = false;
      }
    }
  },
  computed: {},
  mounted() {
    axios
      .request({
        url: "/Single/company",
        method: "get"
      })
      .then(res => {
        this.formInfo = res.data.info;
      });
  }
};
</script>
<style>
</style>
