<template>
  <div class="m-form-wrap">
    <Form
      ref="accountForm"
      :model="curFormData"
      :label-width="120"
      :rules="ruleForm"
      label-position="left"
    >
      <FormItem label="姓名/昵称" prop="realname">
        <Input v-model.trim="curFormData.realname" :maxlength="12" />
      </FormItem>
      <FormItem label="用户名" prop="username">
        <Input v-model.trim="curFormData.username" :maxlength="12" :readonly="acType=='edit'" />
      </FormItem>
      <FormItem label="所属类别" prop="special">
        <Select v-model="curFormData.special" multiple>
          <Option v-for="item in cateList" :value="item.id" :key="item.id">{{ item.title }}</Option>
        </Select>
      </FormItem>
      <template v-if="acType == 'add'">
        <FormItem label="登录密码" prop="password">
          <Input v-model.trim="curFormData.password" type="password" placeholder="请输入密码6-12个字符" />
        </FormItem>
        <FormItem label="确认密码" prop="rpassword">
          <Input v-model.trim="curFormData.rpassword" type="password" placeholder />
        </FormItem>
      </template>
      <FormItem label="新密码" key="newpassword" prop="newpassword" v-else>
        <Input v-model.trim="curFormData.newpassword" type="password" placeholder="不改密码无需填写" />
      </FormItem>

      <FormItem label="状态">
        <i-switch
          v-model="curFormData.status"
          size="large"
          true-value="1"
          false-value="0"
          @on-change="changeStatus"
        >
          <span slot="open">启用</span>
          <span slot="close">禁用</span>
        </i-switch>
      </FormItem>
      <FormItem>
        <Button
          type="primary"
          size="large"
          @click="handleSubmit('accountForm')"
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
  props: {
    id: {
      type: Number
    }
  },
  data() {
    const validatePass = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("请输入密码"));
      } else {
        if (this.curFormData.rpassword !== "") {
          // 对第二个密码框单独验证
          this.$refs.accountForm.validateField("rpassword");
        }
        callback();
      }
    };
    const validatePassCheck = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("请确认密码"));
      } else if (value !== this.curFormData.password) {
        callback(new Error("两次密码不一致"));
      } else {
        callback();
      }
    };
    return {
      submitIng: false,
      curFormData: { status: "1" },
      acType: "add",
      cateList:[],
      ruleForm: {
        realname: [
          {
            required: true,
            type: "string",
            min: 3,
            max: 12,
            message: "请输入姓名或昵称3-12字符"
          }
        ],
        username: [
          {
            required: true,
            type: "string",
            min: 6,
            max: 12,
            message: "用户名必须在6-12个字符之间"
          }
        ],
        special: [
          {
            required: true,
            message: "请选择所属类别"
          }
        ],
        password: [
          {
            required: true,
            min: 6,
            max: 12,
            message: "密码长度必须为6-12个字符"
          },
          { validator: validatePass }
        ],
        rpassword: [
          { required: true, message: "请确认密码" },
          { validator: validatePassCheck }
        ],
        realname: [{ required: true, message: "请输入姓名" }],
        newpassword: [
          {
            min: 6,
            max: 12,
            message: "密码长度必须为6-12个字符"
          }
        ]
      }
    };
  },
  methods: {
    changeStatus(e) {
      // this.curFormData.status = e;
    },

    handleCheckDate() {},
    //submit
    handleSubmit(name) {
      this.$refs[name].validate(valid => {
        if (valid) {
          this.submitIng = true;
          axios
            .request({
              url: "AdviserUser/save",
              data: { ...this.curFormData },
              method: "post"
            })
            .then(
              res => {
                this.$Message.success("Success!");
                this.$emit("form-saved", res);
                this.submitIng = false;
                this.curFormData = { status: "1" };
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
  watch: {
    id: function(newValue) {
      if (!newValue) {
        this.curFormData = { status: "1" };
        this.acType = "add";
        return;
      }
      this.acType = "edit";
      axios
        .request({
          url: `AdviserUser/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.curFormData = res.data.info;
        });
    }
  },
  computed: {},
  mounted() {
    axios
      .request({
        url: `AdviserUser/getCateList`,
        method: "get"
      })
      .then(res => {
        this.cateList = res.data.list;
      });
  }
};
</script>
