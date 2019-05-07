<template>
  <div>
    <div v-if="isReleased === false" style="padding-bottom:20px;">
      <Button type="primary" icon="plus" @click="handleAddQuestion">添加问题</Button>
    </div>
    <div class="m-question-list">
      <div class="item" v-for="(item,index) in questionList" :key="item.id">
        <div class="ask">
          <div class="ask-title">
            <span class="index-nu">{{index+1}}.</span>
            {{item.question.ask}}
          </div>
          <div class="handle-box" v-if="isReleased===false">
            <Button
              v-if="item.question.type != 3"
              @click="handleOptionAdd(index)"
              icon="ios-plus"
            >添加选项</Button>
            <Button @click="handleQuestionEdit(index)" icon="ios-compose">编辑问题</Button>
            <Poptip confirm title="确认要删除？" placement="left" @on-ok="handleQuestionDel(index)">
              <Button icon="ios-trash">删除</Button>
            </Poptip>
            <Button @click="handleSort(index,'up')">上移</Button>
            <Button @click="handleSort(index,'down')">下移</Button>
          </div>
        </div>
        <div class="answer-list" v-if="item.question.type != 3">
          <div class="opt" v-for="(opt,i) in item.opt" :key="opt.id">
            <div>
              <span class="index-nu">({{i+1}})</span>
              <span>{{opt.content}}</span>
            </div>
            <div class="handle-box" v-if="isReleased === false">
              <Button
                class="opt-btn"
                size="small"
                type="primary"
                @click="handleOptionEdit(index,i)"
              >编辑</Button>
              <Poptip confirm title="确认要删除此选项？" placement="left" @on-ok="handleOptionDel(index,i)">
                <Button class="opt-btn" size="small" type="primary">删除</Button>
              </Poptip>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Modal v-model="showQuestionModal" width="640">
      <p slot="header">
        <Icon type="information-circled"></Icon>
        <span>{{modalActName}}</span>
      </p>
      <div>
        <Form
          ref="questionForm"
          :model="questionDetail"
          :label-width="80"
          :rules="questionFormRule"
        >
          <FormItem label="标题:" prop="ask">
            <Input type="textarea" v-model="questionDetail.ask" placeholder="请输入问答标题"/>
          </FormItem>
          <FormItem label="类型:" prop="type">
            <Select v-model="questionDetail.type" style="width:200px">
              <Option
                v-for="(item,index) in questionTypeArr"
                v-bind:key="index"
                :value="(index+1).toString()"
              >{{item}}</Option>
            </Select>
          </FormItem>
          <FormItem>
            <Row :gutter="16">
              <i-col span="6">
                <Button size="large" long @click="showQuestionModal=false">取消</Button>
              </i-col>
              <i-col span="12">
                <Button
                  type="primary"
                  size="large"
                  :loading="questionSubmiting"
                  long
                  @click="handleSaveQuestion"
                >保存</Button>
              </i-col>
            </Row>
          </FormItem>
        </Form>
      </div>
      <div slot="footer" style="margin-left:80px;"></div>
    </Modal>
    <Modal v-model="showOptionModal" width="640">
      <p slot="header">
        <Icon type="information-circled"></Icon>
        <span>选项</span>
      </p>
      <div>
        <Form ref="optionForm" :model="optionDetail" :label-width="80" :rules="optionFormRule">
          <FormItem label="选项内容:" prop="content">
            <Input type="textarea" v-model="optionDetail.content" placeholder="请输入选项内容"/>
          </FormItem>
          <FormItem>
            <Row :gutter="16">
              <i-col span="6">
                <Button size="large" long @click="showOptionModal=false">取消</Button>
              </i-col>
              <i-col span="12">
                <Button
                  type="primary"
                  size="large"
                  :loading="optionSubmiting"
                  long
                  @click="handleSaveOption"
                >保存</Button>
              </i-col>
            </Row>
          </FormItem>
        </Form>
      </div>
      <div slot="footer" style="margin-left:80px;"></div>
    </Modal>
  </div>
</template>
<script>
import axios from "@/libs/api.request";
export default {
  name: "question_list",
  props: {
    curSurveyId: {
      type: Number
    },
    isReleased: {
      type: Boolean
    },
    questionList: {
      type: Array,
      default: []
    }
  },
  data() {
    return {
      showQuestionModal: false,
      questionDetail: {},
      curUpdateQuestionIndex: 0,
      questionTypeArr: ["单选", "多选", "填空"],
      modalActName: "",
      questionFormRule: {
        ask: [{ required: true, message: "题目内容不能为空" }],
        type: [{ required: true, message: "请选择题目类型" }]
      },
      showOptionModal: false,
      curUpdateOptionIndex: 0,
      optionAcType: "",
      optionDetail: {},
      optionFormRule: {
        content: [{ required: true, message: "选项内容内容不能为空" }]
      },
      optionSubmiting: false,
      questionSubmiting: false
    };
  },
  methods: {
    handleAddQuestion() {
      this.showQuestionModal = true;
      this.modalActName = "添加问题";
      this.questionDetail = {};
    },
    handleQuestionEdit(index) {
      this.curUpdateQuestionIndex = index;
      let curQuestion = this.questionList[index]["question"];
      this.questionDetail = Object.assign({}, curQuestion);
      this.showQuestionModal = true;
      this.modalActName = "编辑问题";
    },
    handleQuestionDel(index) {
      const curQuestion = this.questionList[index]["question"]
      axios.request({
        url:"/SurveyQuestion/deleteone",
        params:{id:curQuestion.id},
        method:"get"
      }).then(res=>{
        this.questionList.splice(index,1)
      })
    },
    // option handle
    handleOptionAdd(index) {
      this.optionDetail = {
        question_id: this.questionList[index]["question"].id,
        sort: 0,
        content: ""
      };
      this.showOptionModal = true;
      this.optionAcType = "add";
      this.curUpdateQuestionIndex = index;
    },
    handleOptionEdit(index, optindex) {
      this.curUpdateQuestionIndex = index;
      this.curUpdateOptionIndex = optindex;
      this.optionDetail = Object.assign(
        {},
        this.questionList[index]["opt"][optindex]
      );
      this.showOptionModal = true;
      this.optionAcType = "edit";
    },
    handleOptionDel(index, optindex) {
      const answerId = this.questionList[index]["opt"][optindex].id;
      axios
        .request({
          url: "/SurveyAnswer/delone",
          params: { id: answerId },
          method: "get"
        })
        .then(res => {
          if (res) {
            this.questionList[index]["opt"].splice(optindex, 1);
          }
        });
    },
    handleSaveQuestion() {
      this.$refs["questionForm"].validate(valid => {
        if (valid) {
          if (this.questionSubmiting) return;
          this.questionSubmiting = true;
          if (this.modalActName == "添加问题") {
            let postData = Object.assign({}, this.questionDetail);
            postData.s_id = this.curSurveyId;
            axios
              .request({
                url: "/SurveyQuestion/doadd",
                data: postData,
                method: "post"
              })
              .then(
                res => {
                  if (res) {
                    this.$Message.success("Success!");
                    this.questionSubmiting = false;
                    this.showQuestionModal = false;
                    this.questionList.push(res.data.info);
                  }
                },
                reject => {
                  this.questionSubmiting = true;
                }
              );
          } else {
            axios
              .request({
                url: "/SurveyQuestion/update",
                data: this.questionDetail,
                method: "post"
              })
              .then(
                res => {
                  let index = this.curUpdateQuestionIndex;
                  this.$Message.success("Success!");
                  this.questionSubmiting = false;
                  this.showQuestionModal = false;
                  this.questionList[index]["question"] = res.data.info;
                },
                reject => {
                  this.questionSubmiting = true;
                }
              );
          }
        }
      });
    },
    handleSaveOption() {
      this.$refs["optionForm"].validate(valid => {
        if (valid) {
          if (this.optionSubmiting) return;
          this.questionSubmiting = true;
          let apiUrl =
            this.optionAcType == "add"
              ? "/SurveyAnswer/insert"
              : "/SurveyAnswer/update";
          axios
            .request({ url: apiUrl, data: this.optionDetail, method: "post" })
            .then(
              res => {
                let index = this.curUpdateQuestionIndex;
                let optIndex = this.curUpdateOptionIndex;
                this.$Message.success("Success!");
                this.optionSubmiting = false;
                this.showOptionModal = false;
                if (this.optionAcType == "add") {
                  this.questionList[index]["opt"].push(res.data.info);
                } else {
                  this.questionList[index]["opt"][optIndex] = res.data.info;
                }
              },
              reject => {
                this.optionSubmiting = true;
              }
            );
        }
      });
    },
    handleSort(curIndex, type) {
      let questionList = this.questionList;
      let newIndex;
      if (type === "up") {
        if (curIndex === 0) return;
        newIndex = curIndex - 1;
      } else {
        if (curIndex === questionList.length - 1) return;
        newIndex = curIndex + 1;
      }
      let curItem = questionList.splice(curIndex, 1)[0];
      questionList.splice(newIndex, 0, curItem);
      let newQuestionId = [];
      questionList.forEach((item, index) => {
        newQuestionId.push({
          questionid: item.question.id,
          sort: index
        });
      });
      console.log(newQuestionId)
      axios.request({
        url: "/SurveyQuestion/resort",
        data: {data:JSON.stringify(newQuestionId)},
        method: "post"
      });
    }
  }
};
</script>
