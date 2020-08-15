<template>
  <div class="m-form-wrap">
    <Form
      ref="couponForm"
      :model="couponFormInfo"
      :label-width="80"
      :rules="ruleForm"
      label-position="left"
    >
      <FormItem label="优惠金额" prop="title">
        <InputNumber :max="1000" :min="1" v-model="couponFormInfo.title" style="width:50%" />
      </FormItem>
      <FormItem label="使用说明" prop="description">
        <Input v-model.trim="couponFormInfo.description" type="textarea" placeholder="优惠券使用说明" />
      </FormItem>
      <FormItem label="开始日期:" prop="start_date">
        <DatePicker
          type="date"
          v-model="couponFormInfo.start_date"
          format="yyyy-MM-dd"
          placeholder="请选择"
          @on-change="handleCheckDate"
        ></DatePicker>
      </FormItem>
      <FormItem label="截至日期:" prop="end_date">
        <DatePicker
          v-model="couponFormInfo.end_date"
          type="date"
          format="yyyy-MM-dd"
          placeholder="请选择"
          @on-change="handleCheckDate"
        ></DatePicker>
      </FormItem>

      <FormItem label="发放数量" prop="num">
        <InputNumber :max="1000" :min="5" v-model="couponFormInfo.num" style="width:50%" />
      </FormItem>
      <FormItem label="状态">
        <i-switch
          v-model="couponFormInfo.status"
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
          @click="handleSubmit('couponForm')"
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
    formData: {
      type: Object,
      default:{}
    },
    businessId: {
      type: Number
    }
  },
  data() {
    return {
      submitIng: false,
      couponFormInfo: {},
      ruleForm: {
        title: [
          {
            required: true,
            type: "integer",
            max: 500,
            min: 1,
            message: "优惠金额必须是1-1000之间的整数"
          }
        ],
        description: [{ required: true, message: "请填写使用说明" }],
        start_date: [{ required: true, message: "有效期开始日期" }],
        end_date: [{ required: true, message: "有效期截至" }],
        num: [
          {
            required: true,
            type: "integer",
            max: 10000,
            min: 5,
            message: "必须是5-10000之间的整数"
          }
        ]
      }
    };
  },
  methods: {
    //
    changeStatus(e) {
      this.couponFormInfo.status = e;
    },
    handleCheckDate() {},
    //submit
    handleSubmit(name) {
      this.$refs[name].validate(valid => {
        if (valid) {
          this.submitIng = true;
          this.couponFormInfo.b_id = this.businessId;
          axios
            .request({
              url: "Coupon/save",
              data: { ...this.couponFormInfo },
              method: "post"
            })
            .then(
              res => {
                this.$Message.success("Success!");
                this.$emit("form-saved", res);
                this.submitIng = false;
                this.$refs["couponForm"].resetFields();
              },
              reject => {
                this.$Message.error("系统错误");
                this.submitIng = false;
              }
            );
        } else {
          this.$Message.error("信息填写错误!");
          console.log(this.couponFormInfo);
        }
      });
    },
    handleCancel() {
      this.$refs["couponForm"].resetFields();
      this.$emit("handle-cancel");
    }
  },
  watch: {
    formData: function(newVal) {
        this.couponFormInfo = newVal
    }
  },
  computed: {
    iseditor: function() {
      return this.actype == "edit";
    }
  },
  mounted() {
      
  }
};
</script>
