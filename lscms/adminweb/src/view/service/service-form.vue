<template>
  <div>
    <Form
      ref="serviceForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="项目名称:" prop="title">
        <Input v-model.trim="formInfo.title" placeholder="请输入项目名称"/>
      </FormItem>

      <FormItem label="封面图片:">
        <ImgUpload
          :upload-url="thumbUploadUrl"
          :delete-url="thumbDeleteUrl"
          :initFileList="thumbList"
          @file-changed="handleThumbChanged"
        />
      </FormItem>

      <FormItem label="图标:">
        <ImgUpload
          :upload-url="thumbUploadUrl"
          :delete-url="thumbDeleteUrl"
          :initFileList="iconList"
          @file-changed="handleIconChanged"
        />
      </FormItem>

      <FormItem label="项目描述:" prop="description">
        <Input v-model.trim="formInfo.description" placeholder="64字符以内"/>
      </FormItem>

      <FormItem label="显示状态:">
        <i-switch v-model="formInfo.status" size="large" true-value="1" false-value="0">
          <span slot="open">启用</span>
          <span slot="close">禁用</span>
        </i-switch>
      </FormItem>
      <FormItem label="项目详情:">
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
            <Button @click="handleCancel" size="large" long>取消</Button>
          </i-col>
          <i-col span="8">
            <Button
              type="primary"
              size="large"
              @click="handleSubmit('serviceForm')"
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
import Editor from "_c/editor";
import ImgUpload from "_c/img-upload";
import axios from "@/libs/api.request";
export default {
  name: "serviceForm",
  components: { Editor, ImgUpload },
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
        title: [{ required: true, message: "请输入项目名称" }]

      },
      formInfo: {
        status: "1",
        description: '',
        thumb: '',
        icon: ''
      },
      thumbList: [],
      iconList: [],
      thumbUploadUrl: this.$config.uploadUrl + "/save",
      thumbDeleteUrl: this.$config.uploadUrl + "/delete",
      contentUploadUrl: this.$config.uploadUrl + "/save",
      newContent: ""
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      axios
        .request({
          url: `Service/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = res.data.info;
          this.thumbList = res.data.thumbList;
          this.iconList = res.data.iconList;
          this.newContent = res.data.info.content;
        });
    }
  },
  methods: {
 
    setFileList() {},
    handleThumbChanged(data) {
      this.formInfo.thumb = data;
    },
    handleIconChanged(data) {
      this.formInfo.icon = data;
    },
    handleEditorChange(html, text) {
      this.newContent = html;
    },
    handleSubmit(name) {
      if(this.newContent) {
        this.formInfo.content = this.newContent;
      }
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Service/save",
              data: { ...this.formInfo },
              method: "post"
            })
            .then(res => {
              this.$Message.success("Success!");
              this.$emit("form-saved", res);
              this.submitIng = false;
            });
        } else {
          this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      closeCurPage(this);
    }
  },
  computed: {},
  mounted() {}
};
</script>
<style>
</style>
