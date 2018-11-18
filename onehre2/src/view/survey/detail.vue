<template>
  <Card>
    <Tabs @on-click="switchTab" value="question">
        <TabPane name='question' label="题目管理" icon="android-desktop">
          <div class="m-question-list">
            <div class="item" v-for="(item,index) in questionList" :key="item.id">
              <div class="ask">
                <div>
                  <span class="index-nu">{{index+1}}.</span>
                  {{item.question.ask}}
                </div>
                <div class="handle-box">
                  <Button v-if="item.question.type != 3" @click="handleOptionAdd(index)" icon="ios-plus">添加选项</Button>
                  <Button @click="handleQuestionEdit(index)" icon="ios-compose">编辑问题</Button>
                  <Button @click="handleQuestionDel(index)" icon="ios-trash">删除</Button>
                </div>
              </div>
              <div class="answer-list" v-if="item.question.type != 3">
                <div class="opt" v-for="(opt,i) in item.opt" :key="opt.id">
                  <div>
                    <span class="index-nu">({{i+1}})</span>
                    <span>{{opt.content}}</span>
                  </div>
                  <div class="handle-box">
                    <Button class="opt-btn" size="small" type="text" @click="handleOptionEdit(index,i)">编辑</Button>
                    <Poptip
                        confirm
                        title="确认要删除此选项？"
                        placement="left"
                        @on-ok="handleOptionDel(index,i)">
                        <Button class="opt-btn" size="small" type="text">删除</Button>
                    </Poptip>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          <Modal v-model="showQuestionModal" width="640">
              <p slot="header">
                  <Icon type="information-circled"></Icon>
                  <span>编辑问题</span>
              </p>
              <div>
                <Form ref="questionForm" :model="questionDetail" :label-width="80" :rules="questionFormRule">
                  <FormItem  label="标题:" prop="ask">
                    <Input type="textarea" v-model="questionDetail.ask" placeholder="请输入问答标题" />
                  </FormItem>
                  <FormItem label="类型:" prop="type">
                    <Select v-model="questionDetail.type" style="width:200px">
                        <Option v-for="(item,index) in questionTypeArr" v-bind:key="index" :value="(index+1).toString()">{{item}}</Option>
                    </Select>
                  </FormItem>
                  <FormItem>
                    <Row :gutter="16">
                      <i-col span="6">
                        <Button size="large" long @click="showQuestionModal=false">取消</Button>
                      </i-col>
                      <i-col span="12">
                        <Button type="primary" size="large" :loading="questionSubmiting" long @click="handleSaveQuestion">保存</Button>
                      </i-col>
                    </Row>
                  </FormItem>
                </Form>
              </div>
              <div slot="footer" style="margin-left:80px;">

              </div>
            </Modal>
            <Modal v-model="showOptionModal" width="640">
              <p slot="header">
                  <Icon type="information-circled"></Icon>
                  <span>选项</span>
              </p>
              <div>
                <Form ref="optionForm" :model="optionDetail" :label-width="80" :rules="optionFormRule">
                  <FormItem  label="选项内容:" prop="content">
                    <Input type="textarea" v-model="optionDetail.content" placeholder="请输入选项内容" />
                  </FormItem>
                  <FormItem>
                    <Row :gutter="16">
                      <i-col span="6">
                        <Button size="large" long @click="showOptionModal=false">取消</Button>
                      </i-col>
                      <i-col span="12">
                        <Button type="primary" size="large" :loading="optionSubmiting" long @click="handleSaveOption">保存</Button>
                      </i-col>
                    </Row>
                  </FormItem>
                </Form>
              </div>
              <div slot="footer" style="margin-left:80px;">

              </div>
            </Modal>
        </TabPane>
        <!--statistics-->
        <TabPane name='statistics' label="结果统计" icon="android-time" wx:if="surveyInfo.is_released == 1">
          <div class="m-question-list">
            <div class="item" v-for="(item,index) in statistics" :key="item.id">
              <div class="ask">
                <div>
                  <span class="index-nu">{{index+1}}.</span>
                  <span>{{item.question.ask}}</span>
                  <span class="type">[{{questionTypeArr[item.question.type-1]}}]</span>
                </div>
              </div>
              <div class="answer-list" v-if="item.question.type != 3">
                <div class="opt" v-for="(opt,i) in item.opt" :key="opt.id">
                  <div class="opt-content">
                    <span>{{opt.content}}</span>
                  </div>
                  <div class="poll-num">{{opt.poll}}</div>
                  <div class="opt-progress"><Progress :percent="pollPercent(index,i)"></Progress></div>
                </div>
              </div>
              <div v-else>
                <div class="m-fill-box" v-if="item.fill.list.length">
                  <div class="fill-item" v-for="(fill,j) in item.fill.list" :key="fill.id">
                    <div>{{j+1}}.</div>
                    <div class="content">{{fill.content}}</div>
                  </div>
                </div>
                <Button type="info" @click="viewMoreFill(item.question.id)" v-if="item.fill.hasMore">查看更多</Button>
              </div>
            </div>
          </div>
        </TabPane>
        <!--logs-->
        <TabPane name='logs' label="详细记录" icon="android-clipboard" wx:if="surveyInfo.is_released == 1">
          <Table :columns="logsColumn" :data="logs"></Table>
          <div class="m-paging-wrap">
            <Page :total="logsTotal" :current="logsPage" :page-size="20" @on-change="changeLogsPage" v-show="logsTotal > 20"></Page>
          </div>
        </TabPane>
    </Tabs>
  </Card>
</template>
<style>
.m-question-list .item {
  padding-bottom: 10px;
  margin-bottom: 10px;
  border-bottom: 1px solid #ddd;
}
.m-question-list .item .ask {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
}
.m-question-list .item .ask .type {font-weight: 100;color:#9c9c9c;}
.m-question-list .item .opt {
  display: flex;
  justify-content: space-between;
  align-items:flex-start;
  min-height: 40px;
}
.m-question-list .index-nu {
  margin-right: 10px;
  flex-shrink: 0;
  flex-grow: 0;
  width: auto;
}
.m-question-list .opt {
  padding: 5px 10px;
}
.m-question-list .opt .handle-box {
  flex-shrink: 0;
  flex-grow: 0;
  margin-left:20px;
  width: 120px;
  text-align: right;
}
.m-question-list .opt .opt-content {
  width:100%;
  flex-shrink: 1;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.m-question-list .opt .poll-num {
  flex-shrink: 0;
  flex-grow: 0;
  margin-left:20px;
  width:100px;
  text-align: center;
}
.m-question-list .opt .opt-progress {
  flex-shrink: 0;
  flex-grow: 0;

  width:300px;
}
.m-question-list .opt .opt-btn {display: none;}
.m-question-list .opt:hover {
  background-color:#f7f7f7;
}
.m-question-list .opt:hover .opt-btn{display: inline-block;}
.m-fill-box .fill-item {
  display: flex;
}
</style>

<script>
import { getTableList, deleteDataOne, getDataOne,saveData } from "@/api/data";
import Question from "./question";
export default {
  components: { Question },
  data() {
    return {
      test: "",
      curTab: "question",
      curId: null,
      surveyInfo:{},
      showQuestionModal:false,
      questionList: [],
      questionDetail:{},
      curUpdateQuestionIndex:0,
      questionTypeArr:['单选','多选','填空'],
      modalActName:'',
      questionFormRule: {
        ask: [{ required: true, message: "题目内容不能为空" }],
        type: [{ required: true, message: "请选择题目类型" }]
      },
      showOptionModal:false,
      curUpdateOptionIndex:0,
      optionAcType:'',
      optionDetail:{},
      optionFormRule: {
        content: [{ required: true, message: "选项内容内容不能为空" }],
      },
      optionSubmiting:false,
      questionSubmiting:false,
      fillPage:1,
      logs: [],
      logsHasmore:false,
      logsPage:1,
      logsTotal:0,
      logsColumn: [
        {
          type: 'index',
          width:60,
          align: 'center'
        },
        {
          title: "时间",
          key: "create_time"
        },
        {
          title: "操作",
          key: "handle",
          render: (h, params) => {
            return h("Button", {on:{click:()=>this.showlogsDetail(params)}},"查看详情");
          }
        }
      ],
      statistics: []
    };
  },
  methods: {
    switchTab(name) {
      this.curTab = name;
      const curSurveyId = this.curId;
      let apiUrl;
      if (name == "logs" && this.logs.length === 0) {
        apiUrl = "/SurveyLog/vlist";
        getTableList(apiUrl, { sid: curSurveyId }).then(res => {
          if (!res) return;
          this.logs = res.data.list
          this.logsHasmore = res.data.hasMore
          this.logsPage = res.data.page
          this.logsTotal = parseInt(res.data.total)
        });
      }else if(name == "statistics" && this.statistics.length === 0){
        getDataOne("/SurveyLog/statistics", { sid: curSurveyId }).then(res => {
            if (res.code == 200) {
              // this.questionList.splice(0, 0, ...res.data.list)
              this.statistics = res.data.list
            }
          });
      }
    },
    viewFill(questionId){
      console.log(questionId)
    },
    handleQuestionEdit(index) {
      this.curUpdateQuestionIndex = index
      let curQuestion = this.questionList[index]['question']
      this.questionDetail = Object.assign({},curQuestion)
      this.showQuestionModal = true
      this.modalActName = "编辑问题"
    },
    handleQuestionDel() {},
    // option handle
    handleOptionAdd(index) {
      this.optionDetail = {
        question_id:this.questionList[index]['question'].id,
        sort:0,
        content:''
      }
      this.showOptionModal =true
      this.optionAcType ='add'
      this.curUpdateQuestionIndex = index
    },
    handleOptionEdit(index,optindex) {
      this.curUpdateQuestionIndex = index
      this.curUpdateOptionIndex = optindex
      this.optionDetail = Object.assign({},this.questionList[index]['opt'][optindex])
      this.showOptionModal =true
      this.optionAcType ='edit'
    },
    handleOptionDel(index,optindex) {
      const answerId = this.questionList[index]['opt'][optindex].id
      deleteDataOne('/SurveyAnswer/delone',answerId).then(res=>{
        if(res){
          this.questionList[index]['opt'].splice(optindex,1)
        }
      })
    },
    handleSaveQuestion() {
      this.$refs["questionForm"].validate(valid => {
        if (valid) {
          if(this.questionSubmiting) return
          this.questionSubmiting = true
          saveData('/SurveyQuestion/update',this.questionDetail).then(res => {
            console.log(res)
            let index = this.curUpdateQuestionIndex
            this.$Message.success("Success!")
            this.questionSubmiting = false
            this.showQuestionModal = false
            this.questionList[index]['question'] = res.data.info
          },reject=>{
            this.questionSubmiting = true
          })
        }
      })
    },
    handleSaveOption() {
      this.$refs["optionForm"].validate(valid => {
        if (valid) {
          if(this.optionSubmiting) return
          this.questionSubmiting = true
          let apiUrl = this.optionAcType=='add'?'/SurveyAnswer/insert':'/SurveyAnswer/update'
          saveData(apiUrl,this.optionDetail).then(res => {
            let index = this.curUpdateQuestionIndex
            let optIndex = this.curUpdateOptionIndex
            this.$Message.success("Success!")
            this.optionSubmiting = false
            this.showOptionModal = false
            if(this.optionAcType=='add') {
              this.questionList[index]['opt'].push(res.data.info)
            }else {
              this.questionList[index]['opt'][optIndex] = res.data.info
            }

          },reject=>{
            this.optionSubmiting = true
          })
        }
      })
    },
    pollPercent:function(questionIndex,optIndex){
      const curOpt = this.questionList[questionIndex]['opt']
      let pollTotal = 0
      let percent = 0
      curOpt.forEach(item=>{
        pollTotal += parseInt(item.poll)
      })
      if(pollTotal === 0 ) return 0
      percent = Math.floor(parseInt(curOpt[optIndex].poll) / pollTotal * 100)
      return percent
    },
    viewMoreFill(questionIndex){
        apiUrl = "/SurveyLog/statistics";
        $questionId = this.statistics[questionIndex].question.id
        getTableList(apiUrl, { questionid: questionId,page:this.fillPage+1 }).then(data => {
          if (!data) return;
          this.statistics[questionIndex].fill.list.push(...data.list);
          this.statistics[questionIndex].fill.hasMore = data.hasMore
        });
    },
    changeLogsPage(){

    },
    showlogsDetail(params){
      const id = params.row.id
      this.$router.push({ name: "survey_log_detail", params: { id } })
    }

  },
  computed: {

  },
  mounted() {
    // 获取详情
    const curId = this.$route.params.id;
    this.curId = curId;
    getDataOne("/SurveyQuestion/index", { sid: curId }).then(res => {
      if (res.code == 200) {
        this.questionList.splice(0, 0, ...res.data.list)
        this.surveyInfo = res.data.surveyInfo
      }
    });
  }
};
</script>
