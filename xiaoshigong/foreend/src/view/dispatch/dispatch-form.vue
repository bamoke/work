<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:28:46
 * @LastEditTime: 2021-03-04 08:55:04
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-form-wrap">
    <Form
      ref="introducerForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="left"
    >
      <FormItem label="劳工姓名：" prop="worker_name">
        <Input
          v-model.trim="formInfo.worker_name"
          placeholder="请选择劳工"
          @click="showDrawer('worker')"
        />
      </FormItem>

      <FormItem label="职位：" prop="jobname">
        <Input
          v-model.trim="formInfo.jobname"
          placeholder="请选择职位"
        />
      </FormItem>
      </FormItem>
      <FormItem label="提成比例：" prop="percentage">
        <Input v-model.trim="formInfo.percentage" placeholder="提成比例" >
        <span slot="append">%</span>
        </Input>
      </FormItem>
      <FormItem label="备注说明：">
        <Input
          v-model="formInfo.description"
          type="textarea"
          :autosize="{minRows: 2,maxRows: 5}"
          placeholder=""
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
          @click="handleSubmit('introducerForm')"
          :loading="submitIng"
          style="width:40%"
        >提交</Button>
        <Button @click="handleCancel" size="large" style="width:40%;margin-left: 8px">取消</Button>
      </FormItem>
    </Form>
    <Drawer title="Basic Drawer" :closable="false" v-model="showDrawer">
        <p>Some contents...</p>
        <p>Some contents...</p>
        <p>Some contents...</p>
    </Drawer>
  </div>
</template>

<script>
import { saveData, getDataOne } from "@/api/data";
const defaultFormData = {
  id:null,
  worker_name:"",
  workerid: null,
  comname:"",
  comid:null,
  jobname:"",
  jobid:null,
  revenue:0

};
export default {
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data() {
    const validatePercentage = (rule, val, callback)=>{
      var value = parseFloat(val)
      if(isNaN(value)) {
        return callback(new Error('必须为正整数或小数'))
      }
      if(value > 100) {
        return callback(new Error('数值超出限制'))
      }
      callback()
    } 
    return {
      showDrawer:false,
      submitIng: false,
      actype: "add",
      formInfo: defaultFormData,
      ruleForm: {
        workerid: [{ required: true, message: "请选择劳工" }],
        comid: [{ required: true, message: "请选择企业" }],
        jobid: [{required: true, message: "请选择职位"}]
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
      getDataOne('/Introducer/info',{id:newValue}).then(res => {
        this.formInfo = res.data.info;
      });
    }
  },
  methods: {
    //表单初始化
    initForm() {
      this.formInfo = defaultFormData;
      this.$refs["introducerForm"].resetFields();
    },
    //
    showDrawer(itemType){
      this.showDrawer = true
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
          saveData("Introducer/save",this.formInfo).then(res => {
            this.$Message.success("Success!");
            this.$emit("handle-submit", res.data.info);
            this.submitIng = false;
            this.initForm();
          },reject=>{
            this.submitIng = false;
          })
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
  mounted() {}
};
</script>
