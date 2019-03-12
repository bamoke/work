<template>
    <div class="m-form-wrap">
        <Form ref="userForm" :model="userFormInfo" :label-width="80" :rules="ruleForm" label-position="left">
        <FormItem label="用户名" prop="username">
            <Input v-model.trim="userFormInfo.username" v-bind:disabled="iseditor" placeholder="请输入用户名"/>
        </FormItem>
        <FormItem label="称呼" prop="realname">
            <Input v-model.trim="userFormInfo.realname" placeholder="请输入称呼" />
        </FormItem>
        <FormItem label="密码" prop="password" v-if="!iseditor">
          <Input type="password" v-model.trim="userFormInfo.password" placeholder="请输入密码" />
        </FormItem>
        <FormItem label="群组" prop="group_id">
            <Select v-model="userFormInfo.group_id" style="width:100px">
                <Option v-for="item in groupsArr" :value="item.id" :key="item.id">{{ item.name }}</Option>
            </Select>
        </FormItem>
        <FormItem label="状态">
            <i-switch v-model="userFormInfo.status" size="large" true-value="1" false-value="0" @on-change="changeStatus">
                <span slot="open">启用</span>
                <span slot="close">禁用</span>
            </i-switch>
        </FormItem>
        <FormItem>
            <Button type="primary" size="large" @click="handleSubmit('userForm')" :loading="submitIng" style="width:40%">提交</Button>
            <Button @click="handleCancel" size="large" style="width:40%;margin-left: 8px">取消</Button>
        </FormItem>
        </Form>
    </div>
</template>

<script>
import { getUserGroups, saveUser } from "@/api/admin_user";
export default {
  props: {
    actype: {
      type: String
    },
    groupsArr: {
      type: Array
    },
    userFormInfo: {
      type: Object,
      default: function() {
        return {
          username: "",
          realname: "",
          group_id: 0,
          status: "1",
          password: ""
        };
      }
    }
  },
  data() {
    return {
      submitIng: false,
      ruleForm: {
        username: [{ required: true, message: "请输入用户名" }],
        realname: [{ required: true, message: "请输入姓名" }],
        password: [{ required: true, message: "请输入密码" }]
      }
    };
  },
  methods: {
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
            this.$emit("handle-submit", res.info);
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
    }
  },
  computed: {
    iseditor: function() {
      return this.actype == "edit";
    }
  },
  mounted() {}
};
</script>
