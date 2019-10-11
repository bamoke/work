<template>
  <div>
    <Form
      ref="mokuaiForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="模块名称:" prop="name">
        <Input v-model.trim="formInfo.name" placeholder="请输入模块名称" />
      </FormItem>
      <FormItem label="模块价格:" prop="price" v-if="pid !== 0">
        <Input v-model.trim="formInfo.price" placeholder="请输入模块价格">
          <span slot="append">每年</span>
        </Input>
      </FormItem>
      <FormItem label="模块描述:" prop="description">
        <Input v-model.trim="formInfo.description" type="textarea" :rows="2" />
      </FormItem>
      <FormItem label="排序:" prop="sort">
        <InputNumber :max="999" :min="1" v-model="formInfo.sort"></InputNumber>
      </FormItem>

      <FormItem label="显示状态:">
        <i-switch v-model="formInfo.status" size="large" true-value="1" false-value="0">
          <span slot="open">启用</span>
          <span slot="close">禁用</span>
        </i-switch>
      </FormItem>

      <FormItem>
        <Row :gutter="16">
          <i-col span="8">
            <Button @click="handleCancel" size="large" long>取消</Button>
          </i-col>
          <i-col span="8">
            <Button
              type="primary"
              size="large"
              @click="handleSubmit('mokuaiForm')"
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
  name: "mainform",
  props: {
    id: {
      type: Number,
      default: null
    },
    pid: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      submitIng: false,
      ruleForm: {
        name: [{ required: true, message: "请输入模块名称" }]
      },
      formInfo: { status: "1", pid: 0 }
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      axios
        .request({
          url: `Mokuai/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = res.data.info;
        });
    },
    pid: function(newValue) {
      if (newValue) {
        this.formInfo.pid = newValue;
      }
    }
  },
  methods: {
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Mokuai/save",
              data: { ...this.formInfo },
              method: "post"
            })
            .then(res => {
              this.$Message.success("Success!");
              this.$emit("form-saved", res);
              this.submitIng = false;
              this.formInfo = { status: "1" };
            });
        } else {
          // this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      this.$emit("form-cancel");
    }
  },
  computed: {},
  mounted() {}
};
</script>
<style>
</style>
