<template>
  <Card>
    <div slot="title">
      <Row :gutter="8">
        <i-col span="8">
          <Input clearable placeholder="输入关键字搜索" class="search-input" v-model="keywords" />
        </i-col>
        <i-col span="2">
          <Button @click="handleSearch" class="search-btn" type="primary">
            <Icon type="search" />&nbsp;&nbsp;搜索
          </Button>
        </i-col>
      </Row>
    </div>
    <Button type="primary" slot="extra" icon="ios-add-circle" @click.prevent="handleAdd">添加成员</Button>
    <Table border :columns="_customColumns" :data="tableData" :loading="tableLoading"></Table>
    <div class="m-paging-wrap">
      <Page
        :total="pageInfo.total"
        :current="pageInfo.page"
        :page-size="pageInfo.pageSize"
        @on-change="changePage"
        v-show="pageInfo.total > pageInfo.pageSize"
      ></Page>
    </div>
    <Modal ref="adviseruser-modal" v-model="showModal" draggable scrollable>
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>{{modalTitle}}</span>
      </p>
      <AdviserUserForm
        :id="curEditId"
        @form-saved="handleFormSubmit"
        @on-cancel="handleFormCancel"
      />
      <p slot="footer"></p>
    </Modal>
  </Card>
</template>

<script>
import axios from "@/libs/api.request";
import tableMixin from "@/libs/table-mixin";
import AdviserUserForm from "./component/userform";
export default {
  name: "",
  mixins: [tableMixin],
  components: { AdviserUserForm },
  props: {},
  data() {
    return {
      curEditId: null,
      columns: [
        { title: "姓名/昵称", key: "realname", width: 200 },

        { title: "账号", key: "username",width: 120 },
        { title: "所属类别", key: "belong_cate"},
        { title: "账号状态", key: "status", width: 120 },
        { title: "创建时间", key: "create_time", width: 200 },
        {
          title: "操作",
          width: 300,
          render: (h, params) => {
            return h("div", [
              h(
                "Button",
                {
                  style: { marginRight: "12px" },
                  on: { click: () => this.handleEdit(params) }
                },
                "修改"
              ),
              h(
                "Button",
                {
                  style: { marginRight: "12px" },
                  on: {
                    click: () => {
                      this.handleDelete(params);
                    }
                  }
                },
                "删除"
              )

            ]);
          }
        }
      ],
      tableDataApi: "AdviserUser/index",
      tableData: [],
      keywords: "",
      pageInfo: { page: 1, pageSize: 10, total: 0 },
      editRowIndex: null,
      showModal: false,
      modalTitle: "添加成员"
    };
  },
  methods: {
    handleSearch() {
      let queryData = {};
      if (this.keywords !== "") {
        queryData.keywords = this.keywords;
      }
      this._toPage(queryData);
    },
    handleAdd() {
      this.showModal = true;
      this.curEditId = null;
      this.modalTitle = "添加成员";
    },

    handleEdit(params) {
      this.modalTitle = "修改成员";
      this.editRowIndex = params.index;
      this.curEditId = parseInt(params.row.id);
      console.log(params.row.id)
      this.showModal = true;
    },
    handleDelete(params) {
      const index = params.index;
      axios
        .request({
          url: "AdviserUser/deleteone",
          params: {id: params.row.id},
          method: "get"
        })
        .then(
          res => {
            this.tableData.splice(index,1)
          },
          reject => {
            this.$Message.error("系统错误");
 
          }
        );
    },
    handleFormSubmit(res) {
        console.log(this.editRowIndex)
        if(this.modalTitle === '修改成员') {
            this.$set(this.tableData, this.editRowIndex, res.data.info);
        }else {
            this.tableData.unshift(res.data.info)
        }
      this.showModal = false;
      this.curEditId = null
    },
    handleFormCancel(){
        this.showModal = false
        this.curEditId = null
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
  }
};
</script>
