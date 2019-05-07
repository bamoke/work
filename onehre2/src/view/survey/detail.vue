<template>
  <Card>
    <Tabs @on-click="switchTab" value="question">
        <TabPane name='question' label="题目管理" icon="android-desktop">
          <QuestionList :question-list="questionList" :is-released="surveyInfo.is_released" :cur-survey-id="curId"></QuestionList>
        </TabPane>
        <!--statistics-->
        <TabPane name='statistics' label="结果统计" icon="android-time" >
          <div class="m-question-list" v-if="surveyInfo.is_released == 1">
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
          <div v-else>还未发布</div>
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
  padding: 12px 0;
  margin-bottom: 10px;
  border-top: 1px solid #ddd;
}
.m-question-list .item .ask {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
}
.m-question-list .item .ask .ask-title {padding-right: 30px;}
.m-question-list .item .ask .handle-box {
  flex:none;
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
import QuestionList from "./components/question_list"
import QuestionResult from "./components/question_result"
import QuestionLog from "./components/question_log"
export default {
  components: { Question ,QuestionList, QuestionResult, QuestionLog},
  data() {
    return {
      test: "",
      curTab: "question",
      curId: null,
      questionList:[],
      surveyInfo:{},
      questionTypeArr: ["单选", "多选", "填空"],
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
    this.curId = parseInt(curId);
    getDataOne("/SurveyQuestion/index", { sid: curId }).then(res => {
      if (res.code == 200) {
        this.questionList.splice(0, 0, ...res.data.list)
        this.surveyInfo = res.data.surveyInfo
      }
    });
  }
};
</script>
