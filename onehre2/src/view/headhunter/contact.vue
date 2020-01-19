<template>
  <Card title="猎头联系方式">
    <Form
      ref="contactForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="联系人:" prop="contacts">
        <Input v-model.trim="formInfo.contacts" placeholder="请输入联系人称呼" />
      </FormItem>
      <FormItem label="联系电话:" prop="tel">
        <Input v-model.trim="formInfo.tel" placeholder="请输入联系电话" />
      </FormItem>
      <FormItem label="简历接受邮箱:" prop="email">
        <Input v-model.trim="formInfo.email" placeholder="请输入邮箱地址" />
      </FormItem>

      <FormItem label="推荐说明:">
        <Editor
          v-model="formInfo.content"
          :cache="false"
          :menus="editorMenus"

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
              @click="handleSubmit('contactForm')"
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
import { closeCurPage } from "@/libs/util";
export default {
  name: "headhunterForm",
  components: { Editor },
  props: {
    id: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
      editorMenus: [
        "head",
        "bold",
        "italic",
        "underline",
        "justify",
        "list",
        "undo",
        "redo"
      ],
      submitIng: false,
      ruleForm: {
        contacts: [{ required: true, message: "请填写联系人" }],
        tel: [{ required: true, message: "请填写联系电话" }],
        email: [{ required: true, message: "请填写Email" }]
      },
      formInfo: { },
    };
  },

  methods: {
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios.request({
            url:'Headhunter/save_contact',
            data: this.formInfo,
            method: 'post'
          }).then(res=>{
            this.$Message.success("Success!");
            this.submitIng = false;
          })
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

  mounted() {
    axios
      .request({
        url: "Headhunter/contact",
        method: "get"
      })
      .then(res => {
        this.formInfo = res.data.info;
      });
  }
};
</script>