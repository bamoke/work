<template>
  <div class="m-form-wrap">
    <Form
      ref="userForm"
      :model="userFormInfo"
      :label-width="80"
      :rules="ruleForm"
      label-position="left"
    >
      <FormItem label="用户名" prop="username">
        <Input
          v-model.trim="userFormInfo.username"
          v-bind:disabled="iseditor"
          placeholder="请输入用户名"
        />
      </FormItem>
      <FormItem label="称呼/昵称" prop="nickname">
        <Input
          v-model.trim="userFormInfo.nickname"
          placeholder="请输入称呼/昵称"
        />
      </FormItem>
      <FormItem label="密码" prop="password" v-if="!iseditor">
        <Input
          type="password"
          v-model.trim="userFormInfo.password"
          placeholder="请输入密码"
        />
      </FormItem>
      <FormItem label="权限组" prop="role_id">
        <Select v-model="userFormInfo.role_id" multiple >
          <Option v-for="item in roleList" :value="item.id" :key="item.id">{{
            item.name
          }}</Option>
        </Select>
      </FormItem>
      <FormItem label="状态">
        <i-switch
          v-model="userFormInfo.status"
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
          @click="handleSubmit('userForm')"
          :loading="submitIng"
          style="width: 40%"
          >提交</Button
        >
        <Button
          @click="handleCancel"
          size="large"
          style="width: 40%; margin-left: 8px"
          >取消</Button
        >
      </FormItem>
    </Form>
  </div>
</template>

<script>
import { getUserRoles,getDetail, saveUser } from "@/api/users";
export default {
  props: {
    actype: {
      type: String,
    },
    id:{
      type:Number,
      default:0,
    }
  },
  data() {
    return {
      submitIng: false,
      roleList: [],
      userFormInfo: {
        id:null,
        username: "",
        nickname: "",
        role_id: null,
        status: "1",
        password: "",
      },
      ruleForm: {
        username: [{ required: true, message: "请输入用户名" }],
        nickname: [{ required: true, message: "请输入称呼/昵称" }],
        password: [{ required: true, message: "请输入密码" }],
        role_id: [{ required: true, message: "请选择用户组" }],
      },
    };
  },
  methods: {
    //
    changeStatus(e) {
      this.userFormInfo.status = e;
    },
    // submit
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate((valid) => {
        if (valid) {
          saveUser(this.userFormInfo).then((res) => {
            this.$Message.success("Success!");
            this.$emit("handle-submit", res.data.info);
            this.submitIng = false;
            this.$refs[name].resetFields()
          },reject=>{
            this.submitIng = false;
          });
        } else {
          // this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      this.$emit("handle-cancel");
    },
  },

  watch: {
    id(newValue, oldValue) {
      if (newValue) {
        getDetail(newValue).then(res => {
          this.userFormInfo = res.data.info
        });
      }
    },
  },

  computed: {
    iseditor: function () {
      return this.actype == "edit";
    },
  },
  mounted() {
    getUserRoles().then((res) => {
      this.roleList = res.data.list;
    });
  },
};
</script>
