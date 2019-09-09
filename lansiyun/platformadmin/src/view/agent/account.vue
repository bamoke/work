<template>
  <div>
    <Card>
      <div slot="title">
        <Row :gutter="8">
          <i-col span="8">
            <Input clearable placeholder="输入关键字搜索" class="search-input" v-model.trim="keywords" />
          </i-col>
          <i-col span="2">
            <Button @click="handleSearch" class="search-btn" type="primary">
              <Icon type="search" />&nbsp;&nbsp;搜索
            </Button>
          </i-col>
        </Row>
      </div>
      <Button type="primary" slot="extra" icon="ios-add-circle" @click.prevent="handleAdd">添加账号</Button>
      <Table border :columns="_customColumns" :data="tableData" :loading="tableLoading"></Table>
      <div class="m-paging-wrap">
        <Page
          :total="pageInfo.total"
          :current="pageInfo.page"
          :page-size="pageInfo.pageSize"
          @on-change="changePage"
          v-show="pageInfo.total > pageInfo.page * pageInfo.pageSize"
        ></Page>
      </div>
    </Card>
    <Modal v-model="showAccountModal">
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>添加代理账号</span>
      </p>
      <p slot="footer"></p>

      <Form ref="accountForm" :model="accountDetail" :rules="accountFormRules" :label-width="80">
        <FormItem label="用户名:" prop="username">
          <Input v-model="accountDetail.username" placeholder="请输入用户名" />
        </FormItem>
        <FormItem label="密码:" prop="password">
          <Input type="password" v-model="accountDetail.password" placeholder="请输入密码" />
        </FormItem>

        <FormItem>
          <Row :gutter="16">
            <i-col span="8">
              <Button type="primary" long @click="handleSaveAccount">保存</Button>
            </i-col>
            <i-col span="8">
              <Button long @click="showAccountModal=false">取消</Button>
            </i-col>
          </Row>
        </FormItem>
      </Form>
    </Modal>
  </div>
</template>

<script>
import axios from "@/libs/api.request";
import tableMixin from "@/libs/table-mixin";
export default {
  name: "",
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      columns: [
        { title: "用户名", key: "username" },
        {
          title: "状态",
          render: (h, params) => {
            let statusText = "正常";
            let className = "s-text-success";
            if (parseInt(params.row.status) === 0) {
              statusText = "禁用";
              className = "s-text-error";
            }
            return h("span", { class: className }, statusText);
          }
        },
        { title: "创建日期", key: "create_time", width: 150, sortable: true },
        {
          title: "操作",
          width: 300,
          render: (h, params) => {
            var statusBtnText = "启用",
              statusBtnType = "success";
            if (params.row.status == 1) {
              statusBtnText = "禁用";
              statusBtnType = "error";
            }
            return h("div", [
              h(
                "Button",
                {
                  props: { type: statusBtnType, size: "small", ghost: true},
                  on: { click: () => this.handleStatus(params) }
                },
                statusBtnText
              ),
              h(
                "Button",
                {
                  props: { type: "primary", size: "small", ghost: true},
                  style: { marginLeft: "10px" },
                  on: { click: () => this.handleReset(params) }
                },

                "重置密码"
              ),
              h(
                "Poptip",
                {
                  props: {
                    confirm: true,
                    title: "确认删除？",
                    placement: "right-end"
                  },
                  style: { marginLeft: "10px" },
                  on: { "on-ok": () => this.handleDelete(params) }
                },
                [
                  h(
                    "Button",
                    { Props: { type: "default", size: "small",ghost: true } },
                    "删除"
                  )
                ]
              )
            ]);
          }
        }
      ],
      tableDataApi: "AgentAccount/vlist",
      tableData: [],
      keywords: "",
      pageInfo: { page: 1, pageSize: 10, total: 0 },
      editRowIndex: null,
      showAccountModal: false,
      accountDetail: { agent_id: 0 },
      accountFormRules: {
        username: [{ required: true, message: "请输入用户名" }],
        password: [
          { required: true, message: "请填写输入密码" }
          // { type: "number", message: "价格必须是数字",trigger:"blur" }
        ]
      }
    };
  },
  methods: {
    handleSearch() {
      let queryData = {};
      queryData.keywords = this.keywords;
      this._toPage(queryData);
    },
    handleAdd() {
      this.showAccountModal = !this.showAccountModal;
    },
    handleReset(params) {
      const id = params.row.id;
      const apiUrl = "AgentAccount/reset";
      axios
        .request({
          url: apiUrl,
          params: { id },
          method: "get"
        })
        .then(res => {
          // this.$Message.success("操作成功");
          var newPassword = res.data.info;
          this.$Modal.success({
            title: "操作成功,请记住新密码",
            content: newPassword
          });
        });
    },
    handleStatus(params) {
      const index = params.index;
      const id = params.row.id;
      const apiUrl = "AgentAccount/forbid";
      var curItem = Object.assign({}, params.row);
      var newStatus = curItem.status == 0 ? 1 : 0;
      axios
        .request({
          url: apiUrl,
          params: { id, status: newStatus },
          method: "get"
        })
        .then(res => {
          curItem.status = newStatus;
          this.$Message.success("操作成功");
          this.$set(this.tableData, index, curItem);
        });
    },
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      const apiUrl = "AgentAccount/deleteone";
      axios
        .request({
          url: apiUrl,
          params: { id },
          method: "get"
        })
        .then(res => {
          this.$Message.success("删除成功");
          this.tableData.splice(index, 1);
        });
    },
    handleSaveAccount() {
      this.$refs["accountForm"].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "AgentAccount/save",
              data: { ...this.accountDetail },
              method: "post"
            })
            .then(res => {
              this.tableData.push(res.data.info);
              this.showAccountModal = false;
            });
        }
      });
    },
    _finishedFetchData(res) {
      var queryData = this.$route.query;
      this.tableData = res.data.list;
      this.pageInfo = res.data.pageInfo;
      this.keywords = queryData.keywords;
    }
  },
  computed: {},
  mounted() {
    this._fetchData(this._finishedFetchData);
    this.accountDetail.agent_id = this.$route.params.agentid;
  }
};
</script>