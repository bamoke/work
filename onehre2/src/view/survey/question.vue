<template>
  <div>
    <Button @click="handleAddQuestion">添加题目</Button>
    <div class="" v-for="item in questionList" :key="item.id">
      <div class="ask">{{item.ask}}</div>
      <div class="answer-list">
        <div class="opt" v-for="(opt,i) in item.opt" :key="i">
          <div></div>
          <div>{{opt}}</div>
        </div>
      </div>
    </div>
    
    <Modal v-model="showDetailModal" width="640">
        <p slot="header">
            <Icon type="information-circled"></Icon>
            <span>{{questionActType == 'add'?'添加题目':'修改题目'}}</span>
        </p>
        <div>
          <Form ref="questionForm" :model="questionDetail" :label-width="80" :rules="formRule">
            <FormItem  label="标题:" prop="ask">
              <Input type="textarea" v-model="questionDetail.ask" placeholder="请输入问答标题" />
            </FormItem>
            <FormItem label="类型:" prop="type">
              <Select v-model="questionDetail.type" style="width:200px">
                  <Option value="1">单选</Option>
                  <Option value="2">多选</Option>
                  <Option value="3">填空</Option>
              </Select>
            </FormItem>
            <div v-if="questionDetail.type != 3">
              <div></div>
              <FormItem 
              :label="'选项'+(index+1)" 
              v-for="(item,index) in questionDetail.opt" 
              v-bind:key="index" 
              :rules="{required:true,message:'选项内容不能为空',trigger: 'blur'}" 
              :prop="'opt.'+ index + '.value'"
              >
                <Row>
                  <i-col span="18">
                    <Input type="text" v-model="item.value" placeholder="请输入选项内容"/>
                  </i-col>
                  <i-col span="6" v-if="index > 1"><Button type="text" icon="minus" @click="handleDelOpt(index)">删除</Button></i-col>
                </Row>
              </FormItem>
                <Row style="margin-left:80px;">
                  <i-col><Button type="success" icon="plus" v-on:click="handleAddOpt">添加选项</Button></i-col>
                </Row>
            </div>
          </Form>
        </div>
        <div slot="footer" style="margin-left:80px;">
          <Row :gutter="16">
            <i-col span="6">
              <Button size="large" long>取消</Button>
            </i-col>
            <i-col span="12">
              <Button type="primary" size="large" long :loading="modal_loading" @click="handleSubmitQuestion">保存</Button>
            </i-col>
          </Row>
        </div>
    </Modal>

  </div>
</template>
<style>
.opt-item {
  margin-bottom: 12px;
}
</style>

<script>
import { getTableList, deleteDataOne, getDataOne } from "@/api/data";
export default {
  name: "question",
  data() {
    return {
      surveyId: null,
      showDetailModal: false,
      modal_loading: false,
      questionActType: "add",
      questionList:[],
      questionDetail: {
        type: "",
        ask: "",
        opt: [
          {
            id: null,
            value: ""
          },
          {
            id: null,
            value: ""
          }
        ]
      },
      formRule: {
        ask: [{ required: true, message: "题目内容不能为空" }],
        type: [{ required: true, message: "请选择题目类型" }]
      }
    };
  },
  methods: {
    handleAddQuestion() {
      this.showDetailModal = true;
    },
    handleAddOpt() {
      let curOptList = this.questionDetail.opt;
      if (curOptList.length >= 10) return false;
      curOptList.push({ id: null, value: "" });
      // vm.$set(questionDetail,opt,curOptList)
    },
    handleDelOpt(index) {
      console.log(index);
      let curOptList = this.questionDetail.opt;
      curOptList.splice(index, 1);
    },
    handleSubmitQuestion() {
      this.$refs["questionForm"].validate(valid => {
        if (valid) {
          this.submitIng = true;
          saveData("/SurveyQuestion/save", this.formInfo).then(res => {
            this.$Message.success("Success!");
            this.$emit("question-saved", res.info);
            this.submitIng = false;
          });
        }
      });
    }
  },
  computed: {
  },
  watch:{
  },
  mounted() {
    this.surveyId = this.$route.params.id;
    getDataOne("/SurveyQuestion/index", { sid: this.surveyId }).then(res => {
      if (res.code == 200) {
        this.questionList = res.data.list;
      }
    })
  }
};
</script>
