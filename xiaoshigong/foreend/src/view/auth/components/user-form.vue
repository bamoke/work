<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:28:46
 * @LastEditTime: 2021-02-27 10:10:08
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
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
          v-bind:disabled="actype==='edit'"
          placeholder="请输入用户名"
        />
      </FormItem>
      <FormItem label="称呼/昵称" prop="nickname">
        <Input v-model.trim="userFormInfo.nickname" placeholder="请输入称呼/昵称" />
      </FormItem>
      <FormItem label="密码" prop="password" v-if="actype==='add'">
        <Input type="password" password v-model.trim="userFormInfo.password" placeholder="请输入密码" />
      </FormItem>
      <FormItem label="角色" prop="role_id">
        <Select v-model="userFormInfo.role_id"  multiple  style="width:100%">
          <Option v-for="item in roleArr" :value="item.id" :key="item.id">{{ item.name }}</Option>
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
          style="width:40%"
        >提交</Button>
        <Button @click="handleCancel" size="large" style="width:40%;margin-left: 8px">取消</Button>
      </FormItem>
    </Form>
  </div>
</template>

<script>
import { saveUser, getUserInfo } from "@/api/admin_user";
import { getRoleList } from "@/api/admin_role";
const defaultFormData = {
  username: "",
  nickname: "",
  role_id: "",
  status: "1",
  password: ""
};
export default {
  props: {
    uid: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      submitIng: false,
      actype: "add",
      roleArr: [],
      userFormInfo: defaultFormData,
      ruleForm: {
        username: [{ required: true, message: "请输入用户名" }],
        nickname: [{ required: true, message: "请输入称呼或昵称" }],
        password: [{ required: true, message: "请输入密码" }]
      }
    };
  },
  watch: {
    uid: function(newValue, oldValue) {
      if (!newValue) {
        this.actype = "add";
        this.initForm()
        return;
      }
      this.actype = "eidt";
      getUserInfo(newValue).then(res => {
        this.userFormInfo = res.data.info;
      });
    }
  },
  methods: {
    //表单初始化
    initForm(){
        this.userFormInfo = defaultFormData;
        this.$refs["userForm"].resetFields();
    },
    //
    changeStatus(e) {
      this.userFormInfo.status = e;
    },
    //submit
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          saveUser(this.userFormInfo).then(res => {
            this.$Message.success("Success!");
            this.$emit("handle-submit", res.data.info);
            this.submitIng = false;
          });
        } else {
          // this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      this.initForm();
      this.$emit("handle-cancel");
    }
  },
  mounted() {
    getRoleList().then(res => {
      this.roleArr = res.data.list;
      // console.log(res)
    });
  }
};
</script>
