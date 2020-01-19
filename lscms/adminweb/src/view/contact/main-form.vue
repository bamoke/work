<template>
  <div>
    <Form
      ref="contactForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="称呼:" prop="name">
        <Input v-model.trim="formInfo.name" placeholder="请输入联系人称呼" />
      </FormItem>
      <FormItem label="电话:" prop="tel">
        <Input v-model.trim="formInfo.tel" placeholder="请输入联系人电话" />
      </FormItem>
      <FormItem label="手机:" prop="phone">
        <Input v-model.trim="formInfo.phone" placeholder="请输入联系人手机" />
      </FormItem>
            <FormItem label="邮箱:" prop="email">
        <Input v-model.trim="formInfo.email" placeholder="请输入联系人邮箱"/>
      </FormItem>
      <FormItem label="形象头像:">
        <ImgUpload
          :upload-url="thumbUploadUrl"
          :delete-url="thumbDeleteUrl"
          :initFileList="avatarList"
          @file-changed="handleAvatarChanged"
        />
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
              @click="handleSubmit('contactForm')"
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
export default {
  name: "contactForm",
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
        name: [{ required: true, message: "请输入联系人称呼" }],
        tel: [{ required: true, message: "请输入联系人电弧" }],
        phone: [{ required: true, message: "请输入联系人手机" }],
        email: [{ required: true, message: "请输入联系人邮箱" }]
      },
      formInfo: {
        status: "1",
        tel: "",
        phone: "",
        email: "",
        avatar: ""
      },
      avatarList: [],
      thumbUploadUrl: this.$config.uploadUrl + "/save",
      thumbDeleteUrl: this.$config.uploadUrl + "/delete",
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      axios
        .request({
          url: `Contact/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = res.data.info;
          this.avatarList = res.data.avatarList;
        });
    }
  },
  methods: {
    handleAvatarChanged(data) {
      this.formInfo.avatar = data;
    },
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Contact/save",
              data: { ...this.formInfo },
              method: "post"
            })
            .then(res => {
              this.$Message.success("Success!");
              this.$emit("form-saved", res);
              this.submitIng = false;
            });
        } else {
          // this.$Message.error("Error!");
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
