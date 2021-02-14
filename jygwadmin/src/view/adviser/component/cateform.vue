<template>
  <div>
    <Form
      ref="advisercateForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="顾问类别:" prop="title">
        <Input v-model.trim="formInfo.title" style="width:300px;" placeholder="请输入类别名称" />
      </FormItem>

      <FormItem label="缩略图片:">
        <ImgUpload
          :upload-url="thumbUploadUrl"
          :delete-url="thumbDeleteUrl"
          :initFileList="thumbList"
          @file-changed="handleFileChanged"
        />
      </FormItem>

      <FormItem label="特色标签:" prop="tags">
        <Input v-model.trim="formInfo.tags" placeholder="" />
      </FormItem>
      <FormItem label="分类描述">
          <Input type="textarea" :autosize="{minRows: 3,maxRows: 6}" v-model="formInfo.description" />
      </FormItem>

      <FormItem label="显示状态:">
        <i-switch v-model="formInfo.status" size="large" true-value="1" false-value="0">
          <span slot="open">启用</span>
          <span slot="close">禁用</span>
        </i-switch>
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
              @click="handleSubmit('advisercateForm')"
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
import ImgUpload from "_c/img-upload";
import axios from "@/libs/api.request";
import * as util from "@/libs/util";
export default {
  name: "advisercateForm",
  components: {ImgUpload },
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
        title: [{ required: true, message: "请输入类别名称" }],
        description: [{ required: true, message: "请填写类别描述" }]
      },
      formInfo: { status: "1"},
      thumbList: [],
      thumbUploadUrl: "/Uploads/save/f/thumb",
      thumbDeleteUrl: "/Uploads/delete"
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        this.formInfo = {status:"1"}
        this.thumbList =[]
        return
      }
      axios
        .request({
          url: `Adviser/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = res.data.info;
          this.thumbList = res.data.thumbList;
        });
    }
  },
  methods: {


    setFileList() {},
    handleFileChanged(data) {
      this.formInfo.thumb = data;
    },
    handleEditorChange(html, text) {
      this.newContent = html;
    },
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Adviser/save",
              data: { ...this.formInfo },
              method: "post"
            })
            .then(
              res => {
                this.$Message.success("Success!");
                this.$emit("form-saved", res);
                this.submitIng = false;
                this.$refs["advisercateForm"].resetFields();
              },
              reject => {
                this.$Message.error("系统错误");
                this.submitIng = false;
              }
            );
        } else {
          this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      // closeCurPage(this)
    this.$emit("on-cancel")
    this.$refs["advisercateForm"].resetFields();
    
    }
  },
  computed: {},
  mounted() {
  }
};
</script>
<style>
</style>
