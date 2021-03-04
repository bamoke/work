<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:28:46
 * @LastEditTime: 2021-03-04 00:18:30
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-form-wrap">
    <Form
      ref="jobForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="left"
    >
      <FormItem label="职位名称：" prop="title">
        <Input
          v-model.trim="formInfo.title"
          v-bind:disabled="actype==='edit'"
          placeholder="请输入职位名称"
        />
      </FormItem>
      <FormItem label="公司名称：" prop="comid">
        <Select v-model="formInfo.comid" style="width:100%">
          <Option v-for="com in comList" :value="com.id" :key="com.id">{{ com.name }}</Option>
        </Select>
      </FormItem>
      <FormItem label="职位性质：" prop="type">
        <Select v-model="formInfo.type" style="width:100%">
          <Option v-for="type in typeArr" :value="type.id" :key="type.id">{{ type.name }}</Option>
        </Select>
      </FormItem>
      <FormItem label="工资待遇：" prop="wage">
        <Input v-model.trim="formInfo.wage" placeholder="请输入工资待遇，如：20元/时" />
      </FormItem>

      <FormItem label="备注说明：">
        <Input
          v-model="formInfo.description"
          type="textarea"
          :autosize="{minRows: 2,maxRows: 5}"
          placeholder
        />
      </FormItem>

      <FormItem label="状态">
        <i-switch
          v-model="formInfo.status"
          size="large"
          true-value="1"
          false-value="0"
          @on-change="changeStatus"
        >
          <span slot="open">可用</span>
          <span slot="close">禁用</span>
        </i-switch>
      </FormItem>
      <FormItem>
        <Button
          type="primary"
          size="large"
          @click="handleSubmit('jobForm')"
          :loading="submitIng"
          style="width:40%"
        >提交</Button>
        <Button @click="handleCancel" size="large" style="width:40%;margin-left: 8px">取消</Button>
      </FormItem>
    </Form>
  </div>
</template>

<script>
import { saveData, getDataOne } from "@/api/data";
const defaultFormData = {
  title: "",
  wage: "",
  description: "",
  status: "1"
};
export default {
  props: {
    id: {
      type: Number,
      default: 0
    },
    typeArr: {
      type: Array,
      default: function() {
        return [];
      }
    }
  },
  data() {
    const validatePercentage = (rule, val, callback) => {
      var value = parseFloat(val);
      if (isNaN(value)) {
        return callback(new Error("必须为正整数或小数"));
      }
      if (value > 100) {
        return callback(new Error("数值超出限制"));
      }
      callback();
    };
    return {
      submitIng: false,
      actype: "add",
      formInfo: defaultFormData,
      comList: [],
      ruleForm: {
        title: [{ required: true, message: "请输入职位名称" }],
        wage: [{ required: true, message: "请输入薪资待遇" }],
        comid: [{ required: true, message: "请选择所属企业" }],
        type: [{ required: true, message: "请选择工作性质" }]
      }
    };
  },
  watch: {
    id: function(newValue, oldValue) {
      if (!newValue) {
        this.actype = "add";
        this.initForm();
        return;
      }
      this.actype = "eidt";
      getDataOne("/Job/info", { id: newValue }).then(res => {
        this.formInfo = res.data.info;
      });
    }
  },
  methods: {
    //表单初始化
    initForm() {
      this.formInfo = defaultFormData;
      this.$refs["jobForm"].resetFields();
    },
    //
    changeStatus(e) {
      this.formInfo.status = e;
    },
    //submit
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          saveData("Job/save", this.formInfo).then(
            res => {
              this.$Message.success("Success!");
              this.$emit("handle-submit", res.data.info);
              this.submitIng = false;
              this.initForm();
            },
            reject => {
              this.submitIng = false;
            }
          );
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
    getDataOne("/Company/get_all_list").then(res => {
      this.comList = res.data.list;
    });
  }
};
</script>
