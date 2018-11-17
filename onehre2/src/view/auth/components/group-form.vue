<template>
  <div>
      <Form ref="groupForm" :model="formInfo" :label-width="80" :rules="ruleForm" label-position="left">
        <FormItem label="名称" prop="name">
            <Input v-model.trim="formInfo.name" placeholder="请输入用户组名称"/>
        </FormItem>
        <FormItem label="备注">
            <Input v-model="formInfo.description" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="用户组描述"/>
        </FormItem>
        <FormItem>
            <Button type="primary" size="large" @click="handleSubmit('groupForm')" :loading="submitIng" style="width:40%">提交</Button>
            <Button @click="handleCancel" size="large" style="width:40%;margin-left: 8px">取消</Button>
        </FormItem>
      </Form>
  </div>
</template>

<script>
import { saveData } from "@/api/data";
export default {
  name: "GroupForm",
  props: {
    formInfo: {
      type: Object,
      default() {
        return {
          name: "",
          description: ""
        };
      }
    }
  },
  data() {
    return {
      submitIng: false,
      ruleForm: {
        name: [{ required: true, message: "请输入用户组名称" }]
      },
      apiUrl: 'Groups/save'
    };
  },
  methods: {
   handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          saveData(this.apiUrl, this.formInfo).then(res => {
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
  mounted() {}
};
</script>
