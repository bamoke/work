<template>
  <div>
    <Card>
      <div slot="title">
        <Row :gutter="8">
          <i-col span="3">
            <Select v-model="searchKey">
              <Option
                v-for="item in searchKeyItem"
                :value="item.key"
                :key="item.key"
                >{{ item.name }}</Option
              >
            </Select>
          </i-col>
          <i-col span="8">
            <Input
              clearable
              placeholder="输入关键字搜索"
              class="search-input"
              v-model="keywords"
            />
          </i-col>
          <i-col span="2">
            <Button @click="handleSearch" class="search-btn" type="primary"
              ><Icon type="search" />&nbsp;&nbsp;搜索</Button
            >
          </i-col>
        </Row>
      </div>
      <Button
        type="primary"
        icon="ios-add-circle"
        slot="extra"
        @click.prevent="handleAdd"
        >新建用户</Button
      >
      <Table border :columns="columns" :data="tableData"></Table>
      <div class="m-paging-wrap">
        <Page
          :total="pageInfo.total"
          :current="pageInfo.page"
          :page-size="pageInfo.pageSize"
          @on-change="changePage"
        ></Page>
      </div>
    </Card>
    <Modal ref="userform-modal" v-model="showForm" draggable scrollable>
      <p slot="header" style="text-align: left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>{{ handleName }}</span>
      </p>
      <UserForm
        :id="editId"
        :actype="formActype"
        @handle-submit="handleFormSubmit"
        @handle-cancel="handleFormCancel"
      />
      <p slot="footer"></p>
    </Modal>
  </div>
</template>

<script>
import UserForm from "./components/user1-form";
import { getUserList, deleteUser } from "@/api/users";
export default {
  name: "user-list",
  components: {
    UserForm,
  },
  data() {
    return {
      groupsArr: [],
      searchKeyItem: [
        {
          key: "username",
          name: "用户名",
        },
        {
          key: "nickname",
          name: "称呼/昵称",
        },
      ],
      columns: [
        { title: "用户名", key: "username", width: 150, sortable: true },
        { title: "称呼/昵称", key: "nickname", width: 150, sortable: true },
        { title: "所属权限组", key: "role_name", width: 150 },
        {
          title: "状态",
          key: "status",
          width: 150,
          render: (h, params) => {
            var text;
            var className;
            if (params.row.status == 1) {
              text = "正常";
              className = "text-success";
            } else {
              text = "禁用";
              className = "text-warning";
            }
            return h(
              "span",
              {
                class: className,
              },
              text
            );
          },
        },
        { title: "创建日期", key: "create_time" },
        {
          title: "操作",
          key: "handle",
          render: (h, params) => {
            return h("div", [
              h(
                "Button",
                {
                  props: {
                    type: "default",
                  },
                  style: {
                    marginRight: "10px",
                  },
                  on: {
                    click: () => {
                      this.handleEdit(params);
                    },
                  },
                },
                "编辑"
              ),
              h(
                "Poptip",
                {
                  props: {
                    confirm: true,
                    title: "你确定要删除吗?",
                  },
                  on: {
                    "on-ok": () => {
                      this.handleDelete(params);
                    },
                  },
                },
                [h("Button", {}, "删除")]
              ),
            ]);
          },
        },
      ],
      tableData: [],
      pageInfo: {
        page: 1,
        total: 0,
        pageSize: 15,
      },
      editRowIndex: null,
      editId: 0,
      searchKey: "",
      keywords: "",
      showForm: false,
      formActype: "",
      handleName: "",
      formDetail: {},
      pageSize: null,
    };
  },
  methods: {
    changeSearchKey(e) {
      this.searchKey = e;
    },
    handleSearch() {
      let queryData = {
        p: 1,
      };
      if (this.keywords != "") {
        queryData.k = this.searchKey;
        queryData.w = this.keywords;
      }

      this._toPage(queryData);
      this._fetchData();
    },
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      deleteUser(id).then((res) => {
        this.$Message.success("删除成功");
        this.tableData.splice(index, 1);
      });
    },
    handleEdit(data) {
      this.editRowIndex = data.index;
      this.showForm = true;
      this.handleName = "修改用户";
      this.formActype = "edit";
      this.editId = parseInt(data.row.id);
    },
    handleAdd() {
      this.showForm = true;
      this.handleName = "新建用户";
      this.formActype = "add";
    },
    handleFormCancel() {
      this.showForm = false;
    },
    handleFormSubmit(data) {
      this.showForm = false;
      if (this.formActype == "add") {
        this.tableData.unshift(data);
      } else {
        this.tableData.splice(this.editRowIndex, 1, data);
      }
    },
    changePage: function (e) {
      const queryData = this.$route.query;
      var newQueryData = Object.assign({}, queryData);
      newQueryData.p = e;
      this._toPage(newQueryData);
      this._fetchData();
    },
    _toPage(queryData) {
      this.$router.push({
        name: "auth_user",
        query: queryData,
      });
    },
    _fetchData() {
      var queryData = this.$route.query;
      var curPage = (this.curPage =
        typeof queryData.p === "undefined" ? 1 : parseInt(queryData.p));
      var data = {
        p: curPage,
      };
      if (
        typeof queryData.k !== "undefined" &&
        typeof queryData.w !== "undefined" &&
        queryData.w != ""
      ) {
        data.k = this.searchKey = queryData.k;
        data.w = this.keywords = queryData.w;
      }
      getUserList(data).then((res) => {
        this.tableData = res.data.list;
        this.pageInfo = res.data.pageInfo;
      });
    },
    exportExcel() {
      this.$refs.tables.exportCsv({
        filename: `table-${new Date().valueOf()}.csv`,
      });
    },
  },


  mounted() {
    this.searchKey = "username";
    this._fetchData();
  },
};
</script>

<style>
.m-paging-wrap {
  margin-top: 20px;
}
</style>
