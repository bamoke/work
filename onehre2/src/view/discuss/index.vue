<template>
    <div>
        <Row type="flex" justify="space-between" style="margin-bottom:20px;">
          <i-col span=16>
            <Input @on-click="handleSearch" v-model="keywords" icon="ios-search" placeholder="讨论议题名称" style="width: 400px"/>
          </i-col>
          <i-col span="6" style="text-align:right;"><Button type="primary" icon="ios-plus-outline" @click="handleAdd">添加讨论组</Button></i-col>
        </Row>
        <Table border :columns="columns" :data="list" :loading="formLoading"></Table>
        <div class="m-paging-wrap">
          <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="changePage" v-show="total > pageSize"></Page>
        </div>
        <Modal v-model="showModal" width="480">
              <p slot="header">
                  <Icon type="information-circled"></Icon>
                  <span>{{actionName}}讨论议题</span>
              </p>
              <div>
                <Form ref="discussForm" :model="discussDetail" :label-width="80" :rules="discussFormRule">
                  <FormItem  label="标题:" prop="title">
                    <Input type="text" :maxlength="24" :key="discussDetail.id" v-model="discussDetail.title" placeholder="请输入讨论议题名称" />
                  </FormItem>
                <FormItem  label="讨论进程:">
                    <Select v-model="discussDetail.stage">
                        <Option value="0">未开始</Option>
                        <Option value="1">进行中</Option>
                        <Option value="2">已结束</Option>
                    </Select>
                </FormItem>
                  <FormItem  label="显示状态:" prop="status">
                    <i-switch 
                    v-model="discussDetail.status" 
                    size="large" 
                    true-value="1" 
                    false-value="0" 
                    >
                        <span slot="open">显示</span>
                        <span slot="close">不显示</span>
                    </i-switch>
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
</style>
<script>
import axios from "@/libs/api.request";
export default {
  data() {
    return {
      list: [],
      keywords: "",
      formLoading: false,
      courseId: null,
      curPage: 1,
      total: 0,
      pageSize: 15,
      tableDataApi: "/Classes/remark",
      showModal: false,
      discussDetail: {},
      actionName: "",
      columns: [
        {
          title: "#",
          type: "index",
          width: 60
        },
        {
          title: "名称",
          key: "title"
        },
        {
          title: "讨论进程",
          width: 100,
          render: (h, params) => {
            let className, txt;
            if (params.row.stage == 2) {
              className = "s-text-success";
              txt = "已结束";
            } else if (params.row.stage == 1) {
              className = "s-text-info";
              txt = "进行中";
            } else {
              className = "";
              txt = "未开始";
            }
            return h(
              "span",
              {
                class: className
              },
              txt
            );
          }
        },
        {
          title: "显示状态",
          width: 100,
          render: (h, params) => {
            let className, txt;
            if (params.row.status == 1) {
              className = "s-text-success";
              txt = "正常";
            } else {
              className = "s-text-error";
              txt = "不显示";
            }
            return h("span", { class: className }, txt);
          }
        },
        {
          title: "操作",
          width: 300,
          render: (h, params) => {
            let buttonArr = [];
            if (params.row.stage == 0) {
              buttonArr.push(
                h(
                  "Button",
                  {
                    style: { marginRight: "10px" },
                    on: { click: () => this.handleEdit(params) }
                  },
                  "编辑"
                ),
                h(
                  "Poptip",
                  {
                    props: {
                      confirm: true,
                      title: "你确定要删除吗?"
                    },
                    on: {
                      "on-ok": () => {
                        this.handleDelete(params);
                      }
                    }
                  },
                  [h("Button", {}, "删除")]
                )
              );
            } else {
              buttonArr.push(
                h(
                  "Button",
                  {
                    style: {},
                    on: { click: () => this.handleView(params) }
                  },
                  "详情"
                )
              );
            }
            return h("div", buttonArr);
          }
        }
      ],
      discussFormRule: {
        title: [{ required: true, message: "请填写讨论议题名称" }]
      }
    };
  },
  methods: {
    changePage(page) {
      this.formLoading = true;
      axios
        .request({
          url: "/Discuss/vlist",
          params: { type: 1, objid: this.courseId, page: page },
          method: "get"
        })
        .then(res => {
          if (!res) return false;
          this.list = res.data.list;
          this.total = parseInt(res.data.total);
          this.pageSize = parseInt(res.data.pageSize);
          this.curPage = parseInt(res.data.page);
          this.formLoading = false;
        });
    },

    handleAdd() {
      this.showModal = true;
      this.actionName = "添加";
      this.discussDetail = {
        id: null,
        status: "1",
        stage:"0",
        type: 1,
        objid: this.courseId,
        title: ""
      };
    },
    handleEdit(params) {
      this.discussDetail = Object.assign({}, params.row);
      this.actionName = "编辑";
      this.showModal = true;
    },
    handleView(params) {
      console.log(params);
    },
    handleDelete(params) {
      const discussId = params.row.id;
      const index = params.row._index;
      const request = axios.request({
        url: "/Discuss/delone",
        params: { id: discussId },
        method: "get"
      });
      request.then(res => {
        if (!res) return;
        this.$Message.success("已删除!");
        this.list.splice(index, 1);
      });
    },
    handleSearch() {
      this.formLoading = true;
      const request = axios.request({
        url: "/Discuss/vlist",
        params: { type: 1, objid: this.courseId, keywords: this.keywords },
        method: "get"
      });
      request.then(res => {
        if (!res) return;
        this.list = res.data.list;
        this.total = parseInt(res.data.total);
        this.pageSize = parseInt(res.data.pageSize);
        this.curPage = parseInt(res.data.page);
        this.formLoading = false;
      });
    },
    handleSave() {
      this.$refs["discussForm"].validate(valid => {
        if (!valid) {
          //   this.$Message.error("Fail!");
          return;
        }
        let apiUrl = "/Discuss/update";
        if (this.actionName == "添加") {
          apiUrl = "/Discuss/doadd";
        }
        const request = axios.request({
          url: apiUrl,
          data: this.discussDetail,
          method: "post"
        });
        request.then(res => {
          if (res) {
            this.$Message.success("操作成功!");
            this.showModal = false;
            if (this.actionName == "添加") {
              this.list.push(res.data.info);
            } else {
              let index = this.discussDetail._index;
              // this.list[index] = res.data.info
              this.$set(this.list, index, res.data.info);
            }
          }
        });
      });
    }
  },
  mounted() {
    const courseId = this.$route.params.courseid;
    this.courseId = courseId;
    this.formLoading = true;
    axios
      .request({
        url: "/Discuss/vlist",
        params: { type: 1, objid: courseId, page: this.curPage },
        method: "get"
      })
      .then(res => {
        if (!res) return false;
        this.list = res.data.list;
        this.total = parseInt(res.data.total);
        this.pageSize = parseInt(res.data.pageSize);
        this.curPage = parseInt(res.data.page);
        this.formLoading = false;
      });
  }
};
</script>


