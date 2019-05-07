<template>
  <div>
    <Form
      ref="questionForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="问题：" prop="ask">
        <Input type="textarea" v-model.trim="formInfo.ask" placeholder="请输入问题内容"/>
      </FormItem>

      <FormItem label="类型：" prop="type">
        <Select v-model="formInfo.type" style="width:200px">
          <Option value="1">单选</Option>
          <Option value="2">多选</Option>
          <Option value="3">判断</Option>
        </Select>
      </FormItem>
      <FormItem
        v-for="(item, index) in formInfo.answer"
        :key="index"
        :label="'选项' + (index+1)+'：'"
        :prop="'answer.' + index"
        :rules="{required: true, message: '选项' + (index+1) +' 不能为空', trigger: 'blur'}"
      >
        <Row>
          <i-col span="18">
            <Input type="text" v-model="formInfo.answer[index]" placeholder="请输入答案选项"/>
          </i-col>
          <i-col span="4" offset="1" v-if="index >1">
            <Button type="ghost" @click="handleRemoveOpt(index)">删除</Button>
          </i-col>
        </Row>
      </FormItem>
      <FormItem>
        <Row>
          <i-col span="12">
            <Button type="dashed" long @click="handleAddOpt" icon="plus-round">增加选项</Button>
          </i-col>
        </Row>
      </FormItem>
      <FormItem label="正确答案：" prop="correct">
<!--         <RadioGroup v-model="formInfo.correct" v-if="formInfo.type !='2'">
          <Radio :label="index" v-for="(item,index) in formInfo.answer" :key="formInfo.type+'_'+index">选项{{index+1}}</Radio>
        </RadioGroup> -->
        <CheckboxGroup v-model="formInfo.correct">
          <Checkbox :label="index" v-for="(item,index) in formInfo.answer" :key="formInfo.type+'_'+index">选项{{index+1}}</Checkbox>
        </CheckboxGroup>
      </FormItem>

      <FormItem label="加入题库：" >
        <i-switch v-model="formInfo.is_lib" true-value="1" false-value="0" size="large">
          <span slot="open">是</span>
          <span slot="close">否</span>
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
              @click="handleSubmit('questionForm')"
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
  name: "questionForm",
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
        ask: [{ required: true, message: "请填写问题内容" }],
        type: [{ required: true, message: "请选择类型" }],
        correct: [{ required: true, message: "请设置正确答案" }]
      },
      formInfo: { test_id: null,type:"1", status: "1", is_lib: "1", answer: ["", ""],correct:[] },
      apiUrl: "TestsQuestion/save"
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      getDataOne(`TestsQuestion/edit/id/${newValue}`).then(res => {
        this.formInfo = res.data.info;
      });
    }
  },
  methods: {
    isSelected(val){
      // console.log(this.formInfo.correct.indexOf(val))
      return this.formInfo.correct.indexOf(val)>= 0
    },
    handleAddLib(data) {
      console.log(data);
      console.log(this.formInfo);
    },
    handleAddOpt() {
      if(this.formInfo.answer.length > 6) return
      this.formInfo.answer.push("")
    },
    handleRemoveOpt(index) {
      this.formInfo.answer.splice(index,1)
    },
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          let postData = Object.assign({},this.formInfo)
          saveData(this.apiUrl, JSON.stringify(this.formInfo)).then(
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
    if (this.$route.params.testid) {
      this.formInfo.test_id = this.$route.params.testid;
    }
  }
};
</script>