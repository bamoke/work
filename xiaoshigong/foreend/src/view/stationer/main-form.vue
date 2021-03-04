<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:28:46
 * @LastEditTime: 2021-02-28 18:20:47
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="m-form-wrap">
    <Form
      ref="stationerForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="left"
    >
      <FormItem label="员工姓名：" prop="name">
        <Input
          v-model.trim="formInfo.name"
          v-bind:disabled="actype==='edit'"
          placeholder="请输入企业名称"
        />
      </FormItem>

      <FormItem label="电话：" prop="telphone">
        <Input v-model.trim="formInfo.telphone" placeholder="请输入联系电话" />
      </FormItem>     
      <FormItem label="备注说明：">
        <Input v-model="formInfo.description" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="员工备注" />
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
          @click="handleSubmit('stationerForm')"
          :loading="submitIng"
          style="width:40%"
        >提交</Button>
        <Button @click="handleCancel" size="large" style="width:40%;margin-left: 8px">取消</Button>
      </FormItem>
    </Form>
  </div>
</template>

<script>
import { saveStationerData, getStationerInfo } from "@/api/stationer";
const defaultFormData = {
  name: "",
  telphone: "",
  description:'',
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
      formInfo: defaultFormData,
      ruleForm: {
        name: [{ required: true, message: "请输入员工姓名" }],
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
      getStationerInfo(newValue).then(res => {
        this.formInfo = res.data.info;
      });
    }
  },
  methods: {
    //表单初始化
    initForm() {
      this.formInfo = defaultFormData;
      this.$refs["stationerForm"].resetFields();
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
          saveStationerData(this.formInfo).then(res => {
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
