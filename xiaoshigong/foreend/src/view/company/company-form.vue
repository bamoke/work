<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:28:46
 * @LastEditTime: 2021-02-28 17:37:53
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-form-wrap">
    <Form
      ref="comForm"
      :model="comFormInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="left"
    >
      <FormItem label="企业名称：" prop="name">
        <Input
          v-model.trim="comFormInfo.name"
          v-bind:disabled="actype==='edit'"
          placeholder="请输入企业名称"
        />
      </FormItem>
      <FormItem label="区域" prop="area">
        <Select v-model="comFormInfo.area" style="width:100%">
          <Option v-for="item in areaArr" :value="item.id" :key="item.id">{{ item.name }}</Option>
        </Select>
      </FormItem>
      <FormItem label="所在地址：" prop="address">
        <Input v-model.trim="comFormInfo.address" placeholder="请输入企业地址" />
      </FormItem>
      <FormItem label="联系人：" prop="contact">
        <Input v-model.trim="comFormInfo.contact" placeholder="请输入企业联系人" />
      </FormItem>
      <FormItem label="联系电话：" prop="telphone">
        <Input v-model.trim="comFormInfo.telphone" placeholder="请输入联系电话" />
      </FormItem>
       <FormItem label="驻厂员工" prop="stationer">
        <Select v-model="comFormInfo.stationer" style="width:100%">
          <Option v-for="item in stationerArr" :value="item.id" :key="item.id">{{ item.name }}</Option>
        </Select>
      </FormItem>     
      <FormItem label="备注说明：">
        <Input v-model="comFormInfo.description" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="企业备注" />
      </FormItem>

      <FormItem label="状态">
        <i-switch
          v-model="comFormInfo.status"
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
          @click="handleSubmit('comForm')"
          :loading="submitIng"
          style="width:40%"
        >提交</Button>
        <Button @click="handleCancel" size="large" style="width:40%;margin-left: 8px">取消</Button>
      </FormItem>
    </Form>
  </div>
</template>

<script>
import { saveCompanyData, getCompanyInfo } from "@/api/company";
const defaultFormData = {
  name: "",
  area: "",
  address: "",
  contact: "",
  telphone: "",
  stationer:'',
  status: "1"
};
export default {
  props: {
    id: {
      type: Number,
      default: 0
    },
    areaArr:{
      type:Array,
      default:function(){
        return []
      }
    },
    stationerArr:{
      type:Array,
      default:function(){
        return []
      }
    }
  },
  data() {
    return {
      submitIng: false,
      actype: "add",
      comFormInfo: defaultFormData,
      ruleForm: {
        name: [{ required: true, message: "请输入用户名" }],
        area: [{ required: true, message: "请选择所在区域" }],
        address: [{ required: true, message: "请输入企业地址" }],
        contact: [{ required: true, message: "请输入联系人" }],
        telphone: [{ required: true, message: "请输入联系电话" }]
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
      getCompanyInfo(newValue).then(res => {
        this.comFormInfo = res.data.info;
      });
    }
  },
  methods: {
    //表单初始化
    initForm() {
      this.comFormInfo = defaultFormData;
      this.$refs["comForm"].resetFields();
    },
    //
    changeStatus(e) {
      this.comFormInfo.status = e;
    },
    //submit
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          saveCompanyData(this.comFormInfo).then(res => {
            this.$Message.success("Success!");
            this.$emit("handle-submit", res.data.info);
            this.submitIng = false;
            this.initForm();
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
  }
};
</script>
