<template>
  <div>
    <Form
      ref="verifyForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="用户姓名:">
        <Input :value="talentInfo.realname" readonly />
      </FormItem>

      <FormItem label="审核结果:" prop="status">
        <Select v-model="formInfo.status" style="width:200px" @on-change="handleChangeStatus">
          <Option v-for="item in virifyArr" :value="item.status" :key="item.status">{{ item.name }}</Option>
        </Select>
      </FormItem>

      <FormItem label="原因:" v-if="curVerifyStatus=== 2 || curVerifyStatus === 5" key="reason" prop="reason" :rules="{required: true, message: '未通过原因不能为空', trigger: 'blur'}">
        <Input v-model.trim="formInfo.reason" type="textarea" placeholder="请输入未通过原因" />
      </FormItem>

      <template  v-if="curVerifyStatus == 6">
        <FormItem label="人才卡号:" key="card_no" prop="card_no" :rules="{required: true, message: '人才卡号不能为空', trigger: 'blur'}">
          <Input v-model.trim="formInfo.card_no" type="text" placeholder="请输入人才卡号" />
        </FormItem>
        <FormItem label="开始日期:" key="start_date" prop="start_date" :rules="{required: true, message: '请填写开始日期', trigger: 'blur'}">
          <Input v-model.trim="formInfo.start_date" type="text" placeholder="" />
        </FormItem>
        <FormItem label="截至日期:" key="end_date" prop="end_date" :rules="{required: true, message: '请填写截至日期', trigger: 'blur'}">
          <Input v-model.trim="formInfo.end_date" type="text" placeholder="" />
        </FormItem>
        <FormItem label="人才级别:">
          <Input v-model.trim="formInfo.level" type="text" placeholder="" />
        </FormItem>
        <FormItem label="人才积分:">
          <Input v-model.trim="formInfo.score" type="text" placeholder="" />
        </FormItem>
        <FormItem label="爱心值:">
          <Input v-model.trim="formInfo.love" type="text" placeholder="" />
        </FormItem>
      
      </template>

      <FormItem>
        <Row :gutter="16">
          <i-col span="8">
            <Button @click="handleCancel" size="large" long>取消</Button>
          </i-col>
          <i-col span="8">
            <Button
              type="primary"
              size="large"
              @click="handleSubmit('verifyForm')"
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
import axios from "@/libs/api.request";
export default {
  name: "verifyForm",
  props: {
    talentInfo: {
      type: Object,
      default: {}
    }
  },
  data() {
    return {
      submitIng: false,
      ruleForm: {
        status: [{ required: true, message: "请选择审核结果" }]
      },
      formInfo: {},
      curVerifyStatus: 0,
      virifyArr: [
        {
          status: 2,
          name: "平台审核未通过"
        },
        {
          status: 3,
          name: "平台审核通过"
        },
        {
          status: 5,
          name: "政府审核未通过"
        },
        {
          status: 6,
          name: "审核通过"
        }
      ]
    };
  },
  methods: {
    initializationData(){
      this.curVerifyStatus =0;
      this.formInfo ={}
      this.$refs["verifyForm"].resetFields();
    },
    handleChangeStatus(e){
      this.curVerifyStatus = parseInt(e)
    },
    handleSubmit(name) {
      this.formInfo.id = this.talentInfo.id;
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Talent/verify",
              data: { ...this.formInfo },
              method: "post"
            })
            .then(
              res => {
                this.$Message.success("Success!");
                this.$emit("form-saved", res);
                this.submitIng = false;
                this.initializationData()
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
      this.initializationData()
      this.$emit("form-cancel")
    }
  },
  computed: {},
  mounted() {}
};
</script>
<style>
</style>
