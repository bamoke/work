<template>
  <Card>
    <h3 slot="title">当前：【{{testInfo.title}}】</h3>
    <div slot="extra" :style="{marginTop:'-6px'}" v-if="canEdit">
      <Button type="primary" @click="handleAddQuestion">添加选择
        <Icon type="arrow-down-b"></Icon>
      </Button>
    </div>
    <div class="m-question-list" v-if="questionList.length > 0">
      <Row class="question-item" v-for="(item,index) in questionList" v-bind:key="item.id">
        <i-col span="16">
          <div class="question-title">
            <span class="nu">【{{index+1}}】</span>
            <span class="caption">{{item.ask}}</span>
          </div>
          <div class="answer-list">
            <div class="answer-item" v-for="(answer,j) in item.answer" v-bind:key="answer.j">
              <div class="type correct" v-if="isCorrect(index,j)">满足条件</div>
              <div class="type error" v-else>无效选择</div>
              <div>{{answer}}</div>
            </div>
          </div>
        </i-col>
        <i-col offset="2" span="6">
          <div v-if="canEdit">
            <div class="operat-item-box">
              <Button @click="handleEdit(index)" class="btn">编辑</Button>
              <Button @click="handleDel(index)" class="btn">删除</Button>
            </div>
<!--             <div class="operat-item-box">
              <Button @click="handleEdit(index)" class="btn">显示设置</Button>
              <Button @click="handleEdit(index)" class="btn">跳题设置</Button>
            </div> -->
            <div class="operat-item-box">
              <Button @click="handleSort(index,'up')" class="btn">上移</Button>
              <Button @click="handleSort(index,'down')" class="btn">下移</Button>
            </div>
          </div>
        </i-col>
      </Row>
    </div>
    <div class="m-empty" v-else>暂无数据</div>
  </Card>
</template>

<script>
import { saveData, getTableList, deleteDataOne, getDataOne } from "@/api/data";
import { routeOpenSelf } from "@/libs/util";
export default {
  data() {
    return {
      testId: null,
      testInfo: { is_released: "0" },
      questionList: [],
      questionAllId: [],
      showQuestionLibModal: false,
      libQuestionList: [],
      libColumn: [
        {
          type: "selection",
          width: 60,
          align: "center"
        },
        {
          title: "题目名称",
          key: "ask"
        }
      ],
      libTotalInfo: {
        total: 0,
        page: 1,
        pageSize: 20
      },
      selectedLib: []
    };
  },
  methods: {
    handleSort(curIndex,type){
      let questionList = this.questionList
      let newIndex ;
      if(type === 'up') {
        if(curIndex === 0) return
        newIndex = curIndex - 1;
      }else {
        if(curIndex === questionList.length-1) return
        newIndex = curIndex + 1
      }
      let curItem = questionList.splice(curIndex,1)[0]
      questionList.splice(newIndex,0,curItem)
      let newQuestionId = []
      questionList.forEach((item,index)=>{
        newQuestionId.push({
          questionid:item.id,
          sort:index
        })
      })
      saveData("/TestsQuestion/resort",{data:JSON.stringify(newQuestionId)}).then()

    },
    handleAddQuestion(name) {
      this.$router.push({ name: "test_question_add" });
    },
    handleEdit(questionIndex) {
      const testId = this.testId;
      const curItem = this.questionList[questionIndex];
      this.$router.push({
        name: "test_question_edit",
        params: { questionid: curItem.id }
      });
    },
    handleDel(questionIndex) {
      const curItem = this.questionList[questionIndex];
      getDataOne("/TestsQuestion/delone", { id: curItem.id }).then(res => {
        if (res) {
          this.questionList.splice(questionIndex, 1);
        }
      });
    },

    changePage(page) {
      console.log(page);
    },
    isCorrect(questionIndex, answerIndex) {
      const correctArr = this.questionList[questionIndex].correct.split(",");
      return correctArr.indexOf(answerIndex.toString()) >= 0;
    }
  },
  computed: {
    canEdit() {
      return this.testInfo.is_released == 0;
    }
  },
  mounted() {
    const testId = this.$route.params.testid;
    this.testId = testId;
    getDataOne("/TestsQuestion/index", { testid: testId }).then(res => {
      if (res) {
        this.testInfo = res.data.testInfo;
        this.questionList = res.data.questionList;
        if (res.data.questionList.length > 0) {
          let curAllId = res.data.questionList.map(item => {
            return item.id;
          });
          this.questionAllId = curAllId;
        }
      }
    });
  }
};
</script>

<style>
.question-item {
  padding: 12px 0;
  margin-bottom: 12rpx;
  border-bottom: 1px solid #eee;
}
.question-title {
  font-size: 14px;
  font-weight: bold;
}
.answer-item {
  display: flex;
  padding: 5px 0;
}
.answer-item .type {
  flex-shrink: 0;
  flex-grow: 0;
  margin-right: 10px;
  padding: 5px;
  font-size: 12px;
  line-height: 1;
}
.answer-item .correct {
  background: #19be6b;
  color: #fff;
}
.answer-item .error {
  background: #e6ebf1;
  color: #ccc;
}
.operat-item-box {
  margin-bottom:10px;
  text-align: right;
}
.operat-item-box .btn {
  margin-left: 10px;
  width: 80px;
}
</style>
