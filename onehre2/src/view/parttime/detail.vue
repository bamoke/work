<template>
  <Card>
    <Tabs @on-click="switchTab" value="detail">
        <TabPane name='detail' label="项目介绍" icon="android-desktop">
          <h2>{{detail.title}}</h2>
          <Row>
            <i-col :sm=6>显示状态：<span v-bind:class="[parttimeStatus.className]">{{parttimeStatus.name}}</span></i-col>
            <i-col :sm=6>项目状态：<span v-bind:class="parttimeStage.class">{{parttimeStage.name}}</span></i-col>
          </Row>
          <Row>
            <i-col :sm=6>薪资：{{detail.wage}}</i-col>
            <i-col :sm=6>工期：{{detail.work_day}}</i-col>
            <i-col :sm=6>工作地点：{{detail.work_addr}}</i-col>
            <i-col :sm=6>需求人数:{{detail.person_num}}</i-col>
          </Row>
          <Row>
            <i-col :sm=4>兼职要求:</i-col>
            <i-col :sm=18>{{detail.requirement}}</i-col>
          </Row>
          <Row>
            <i-col :sm=4>项目介绍:</i-col>
            <i-col :sm=18 v-html="detail.content"></i-col>
          </Row>
        </TabPane>
        <TabPane name='progress' label="项目进度" icon="android-time">
          <Steps :current="2" direction="vertical">
              <Step title="UI设计" content="这里是该步骤的描述信息"></Step>
              <Step title="HTML编码" content="这里是该步骤的描述信息"></Step>
              <Step title="数据库设计" content="这里是该步骤的描述信息"></Step>
              <Step title="后台开发" content="这里是该步骤的描述信息"></Step>
              <Step title="接口开发" content="这里是该步骤的描述信息"></Step>
              <Step title="测试" content="这里是该步骤的描述信息"></Step>
              <Step title="完成" content="这里是该步骤的描述信息"></Step>
          </Steps>
        </TabPane>
        <TabPane name='member' label="项目成员" icon="android-people">
          <Table :columns="memberColumn" :data="member"></Table>
        </TabPane>
        <TabPane name='apply' label="申请记录" icon="android-clipboard">
          <Table :columns="applyColumn" :data="apply"></Table>
        </TabPane>
    </Tabs>
  </Card>
</template>
<script>
import { getTableList, deleteDataOne, getDataOne } from "@/api/data";
export default {
  data() {
    return {
      curTab: "detail",
      curId: null,
      detail: {},
      progress: [],
      member: [],
      apply: [],
      stageInfo: [],
      memberColumn: [
        {
          title: "姓名",
          key: "realname"
        },
        {
          title: "称呼",
          key: "nickname"
        },
        {
          title: "手机",
          key: "phone"
        },
        {
          title: "类型",
          key: "type",
          render: (h, params) => {
            let typeName = params.row.type == 1 ? "成员" : "项目管理员";
            return h("span", typeName);
          }
        },
        {
          title: "操作",
          key: "handle",
          render: (h, params) => {
            return h("Button", "移除");
          }
        }
      ],
      applyColumn: [
        {
          title: "姓名",
          key: "realname"
        },
        {
          title: "手机",
          key: "phone"
        },
        {
          title: "邮箱",
          key: "email"
        },
        {
          title: "投递时间",
          key: "create_time"
        },
        {
          title: "状态",
          key: "status",
          render: (h, params) => {
            const curStatusName = params.row.statusName
            const curStatusClass = params.row.statusClass
            return h('span',{class:curStatusClass},curStatusName)
          }
        },
        {
          title: "操作",
          key: "handle",
          render:(h,params)=>{
            return h('Button','审核')
          }
        }
      ]
    };
  },
  methods: {
    switchTab(name) {
      this.curTab = name;
      const parttimeId = this.curId;
      let apiUrl;
      if (name == "member" && this.member.length === 0) {
        apiUrl = "/ParttimeMember/index";
        getTableList(apiUrl, { ptid: parttimeId }).then(res => {
          if (!res) return;
          this.member = res.data.list;
        });
      } else if (name == "progress" && this.progress.length === 0) {
        apiUrl = "/ParttimeProgress/index";
        getTableList(apiUrl, { ptid: parttimeId }).then(res => {
          if (!res) return;
          this.progress = res.data.list;
        });
      } else if (name == "apply" && this.apply.length === 0) {
        apiUrl = "/ParttimeApply/vlist";
        getTableList(apiUrl, { ptid: parttimeId }).then(res => {
          if (!res) return;
          this.apply = res.data.list;
        });
      }
    }
  },
  computed: {
    parttimeStatus() {
      let obj;
      if (this.detail.status == 0) {
        obj = { name: "不显示", className: "s-text-warning" };
      } else {
        obj = { name: "显示", className: "s-text-info" };
      }
      return obj;
    },
    parttimeStage() {
      let curStage = this.stageInfo[this.detail.stage] || {
        name: "",
        class: ""
      };
      return curStage;
    }
  },
  mounted() {
    // 获取详情
    const curId = this.$route.params.id;
    this.curId = curId;
    getDataOne("Parttime/edit", { id: curId }).then(res => {
      res.info.stage = parseInt(res.info.stage);
      this.detail = res.info;
      this.stageInfo = res.stageName;
    });
  }
};
</script>
