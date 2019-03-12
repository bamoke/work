<template>
    <div class="m-member-list">
        <Row type="flex" justify="space-between" style="margin-bottom:20px;">
          <i-col span=16>
            <Input @on-click="handleSearch" v-model="keywords" icon="ios-search" placeholder="请输入姓名" style="width: 400px"/>
          </i-col>
          <i-col span="6" style="text-align:right;"><Button type="primary" icon="ios-plus-outline" @click="handleAdd">添加学员</Button></i-col>
        </Row>
        <Table border :columns="_customColumns" :data="list" :loading="formLoading"></Table>
        <div class="m-paging-wrap">
          <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="xChangePage" v-show="total > pageSize"></Page>
        </div>

        <Modal v-model="showModal" width="480">
              <p slot="header">
                  <Icon type="information-circled"></Icon>
                  <span>{{actionName}}学员</span>
              </p>
              <div>
                <Form ref="memberForm" :model="memberDetail" :label-width="80" :rules="memberFormRule">
                  <FormItem  label="姓名:" prop="realname">
                    <Input type="text" :maxlength="6" :key="memberDetail.id" v-model="memberDetail.realname" placeholder="请输入学员姓名" />
                  </FormItem>
                  <FormItem  label="手机号码:" prop="phone">
                    <Input type="text" :maxlength="11" :key="memberDetail.id" v-model="memberDetail.phone" placeholder="请输入学员手机号" />
                  </FormItem>
                  <FormItem  label="学员身份:" prop="type">
                    <Select v-model="memberDetail.type">
                        <Option value="1">普通学员</Option>
                        <Option value="3">副班长</Option>
                        <Option value="4">班长</Option>
                    </Select>
                  </FormItem>                  
                  <FormItem>
                      <Button type="primary" size="large" long @click="handleSave">保存</Button>
                  </FormItem>
                </Form>
              </div>
              <div slot="footer" style="margin-left:80px;">

              </div>
        </Modal>
    </div>
</template>
<style>
.top-box {
  padding-bottom: 20px;
}
</style>

<script>
import axios from "@/libs/api.request";
import tableMixin from "@/libs/table-mixin";
export default {
  mixins: [tableMixin],
  data() {
    return {
      courseId: null,
      formLoading: true,
      list: [],
      curPage: 1,
      total: 0,
      pageSize: 20,
      keywords: "",
      showModal: false,
      memberDetail: {},
      actionName:'',//编辑或添加
      columns: [
        {
          title: "序号",
          type: "index",
          width: 60,
          align: "center"
        },
        {
          title: "姓名",
          key: "realname",
          width: 150
        },
        {
          title: "班级身份",
          width: 150,
          render: (h, params) => {
            var txt, className;
            if (params.row.type == 4) {
              txt = "班长";
              className = "s-text-error";
            } else if (params.row.type == 3) {
              className = "s-text-info";
              txt = "副班长";
            } else {
              txt = "学员";
            }
            return h("div", { class: className }, txt);
          }
        },
        {
          title: "手机号",
          key: "phone",
          width: 150
        },
        {
          title: "是否签到",
          key: "is_signin",
          width: 150,
          render: (h, params) => {
            if (params.row.is_signin == 0) {
              return h("span", "未签到");
            } else {
              return h("span", { class: "s-text-success" }, "已签到");
            }
          }
        },
        {
          title: "操作",
          key: "handle",
          button: ["edit", "delete"]
        }
      ],
      memberFormRule:{
        realname:[{required:true,message:"请填写学员姓名"},{type:"string",min:2,max:6,message:'需要2-6个字符'}],
        phone:[{required:true,message:'请输入学员手机号'},{type:'string',pattern:/^1[0-9]{10}$/,message:'手机格式不正确'}]
      }
    };
  },
  methods: {
    handleDelete(params) {
      const memberId = params.row.id
      const index = params.row._index
      const request = axios.request({
          url: "/ClassesMember/delone",
          params: { id:memberId },
          method: "get"
        });
        request.then(res => {
          if (!res) return
          this.$Message.success('已删除!')
          this.list.splice(index,1)
        })
    },
    handleAdd(){
      this.showModal = true
      this.actionName = "添加"
      this.memberDetail = {courseid:this.courseId,type:"1"}
    },
    handleEdit(params) {
      this.memberDetail = Object.assign({},params.row)
      this.showModal = true
      this.actionName = "编辑"
    },
    handleSearch(e) {
      this.formLoading = true
      const request = axios.request({
        url: "/ClassesMember/vlist",
        params: { courseid: this.courseId, keywords: this.keywords },
        method: "get"
      });
      request.then(res => {
        if (!res) return
        this.list = res.data.list
        this.total = parseInt(res.data.total)
        this.pageSize = parseInt(res.data.pageSize)
        this.curPage = parseInt(res.data.page)
        this.formLoading = false;
      });
    },
    xChangePage() {},
    handleSave(){
      this.$refs['memberForm'].validate((valid) => {
          if (!valid) {
              this.$Message.error('Fail!')
              return
          }
          let apiUrl ="/ClassesMember/update"
          if(this.actionName=='添加') {
            apiUrl ="/ClassesMember/doadd"
          }
          const request = axios.request({
            url: apiUrl,
            data: this.memberDetail,
            method: "post"
          });
          request.then(res=>{
            if(res) {
              this.$Message.success('操作成功!')
              this.showModal = false
              if(this.actionName=='添加') {
                this.list.push(res.data.info)
              }else {
                let index= this.memberDetail._index
                // this.list[index] = res.data.info
                this.$set(this.list,index,res.data.info)
              }
            }
          })
      })
    }
  },
  mounted() {
    const courseId = this.$route.params.courseid;
    this.courseId = courseId;
    axios
      .request({
        url: "/ClassesMember/vlist",
        params: { courseid: courseId },
        method: "get"
      })
      .then(res => {
        if (!res) return false
        this.list = res.data.list
        this.total = parseInt(res.data.total)
        this.pageSize = parseInt(res.data.pageSize)
        this.curPage = parseInt(res.data.page)
        this.formLoading = false;
      });
  }
};
</script>
