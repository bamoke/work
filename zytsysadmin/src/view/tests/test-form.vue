<template>
  <div>
    <Form
      ref="testForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="查询项目名称:" prop="title">
        <Input v-model.trim="formInfo.title" placeholder="请输入查询项目名称"/>
      </FormItem>
      <FormItem label="发布状态">
        <RadioGroup v-model="formInfo.is_released">
          <Radio label="0">未发布</Radio>
          <Radio label="1">已发布</Radio>
        </RadioGroup>
      </FormItem>
      <FormItem label="人才政策">
        <Select v-model="formInfo.policy" style="width:300px">
          <Option v-for="item in policyInfo" :value="item.id" :key="item.id">{{ item.title }}</Option>
        </Select>
      </FormItem>
      <FormItem label="申报流程">
        <Select v-model="formInfo.process" style="width:300px">
          <Option v-for="item in processInfo" :value="item.id" :key="item.id">{{ item.title }}</Option>
        </Select>
      </FormItem>

      <FormItem label="描述说明:">
        <Input v-model.trim="formInfo.description" placeholder="请输入简短描述，30字符以内，参看前端效果"/>
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
              @click="handleSubmit('testForm')"
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
import { saveData, getDataOne } from "@/api/data";
import { closeCurPage } from "@/libs/util";
export default {
  name: "testForm",
  props: {
    id: {
      type: Number,
      default: null
    },
    operateType: String,
    default: "0"
  },
  data() {
    return {
      courseId: null,
      submitIng: false,
      ruleForm: {
        title: [{ required: true, message: "请填写查询项目名称" }]
      },
      policyInfo: [],
      processInfo: [],
      formInfo: {
        course_id: null,
        status: "1",
        is_released: "0",
        policy: null,
        process: null
      },
      apiUrl: "Tests/save"
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      getDataOne(`Tests/edit/id/${newValue}`).then(res => {
        this.formInfo = res.data.info;
      });
    }
  },
  methods: {
    handleEditorChanged(data) {},
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          saveData(this.apiUrl, this.formInfo).then(
            res => {
              if (res) {
                this.$Message.success("Success!");
                this.$emit("form-saved", res.info);
              }
              this.submitIng = false;
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
      closeCurPage(this);
    }
  },
  computed: {
    canEdit() {
      // return this.formInfo.stage > 0;
    }
  },
  mounted() {
    getDataOne(`Tests/selection`).then(res => {
      this.policyInfo = res.data.policy;
      this.processInfo = res.data.process;
    });
  }
};
</script>