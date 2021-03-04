<template>
  <div>
    <Card>
        <div slot="title">
          <Row :gutter="8">
                <i-col span="8">
                <Input clearable placeholder="输入关键字搜索" class="search-input" v-model="keywords"/>
                </i-col>
                <i-col span="2">
                <Button @click="handleSearch" class="search-btn" type="primary"><Icon type="search"/>&nbsp;&nbsp;搜索</Button>
                </i-col>
          </Row>
        </div>
        <!-- <Button type="primary" slot="extra" icon="ios-add-circle" @click.prevent="handleAdd">新建角色</Button> -->
        <Table border :columns="_customColumns" :data="tableData" :loading="formLoading"></Table>
        <div class="m-paging-wrap">
          <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="changePage" v-show="total > pageSize"></Page>
        </div>
    </Card>

    <Modal v-model="showModal" scrollable >
        <p slot="header" style="text-align:left">
            <span>{{handleName}}</span>
        </p>
      <RoleForm :form-info="formDetail" v-show="handleType == 'edit'"  @handle-submit="handleFormSubmit" @handle-cancel="handleFormCancel"></RoleForm>
      <RoleForm v-show="handleType == 'add'"  @handle-submit="handleFormSubmit" @handle-cancel="handleFormCancel"></RoleForm>
      <p slot="footer"></p>
    </Modal>

  </div>
</template>

<script>
import RoleForm from "./components/group-form";
import axios from "@/libs/api.request";
import tableMixin from "@/libs/table-mixin";
export default {
  name: "",
  mixins: [tableMixin],
  components: { RoleForm },
  props: {},
  data() {
    return {
      columns: [
        { title: "名称", key: "name", width: 250 },
        { title: "描述", key: "description", width: 400 },
        { title: "创建时间", key: "create_time", width: 200, sortable: true },
        { title: "操作", key: "handle", button: ["edit", "delete"] }
      ],
      tableDataApi: "/Role/vlist",
      formLoading: false,
      tableData: [],
      keywords: "",
      curPage: 1,
      total: 0,
      pageSize: 15,
      showModal: false,
      handleType: "",
      formDetail: {},
      editRowIndex: null
    };
  },
  methods: {
    handleSearch() {
      let queryData = {};
      if (this.keywords != "") {
        queryData.keywords = this.keywords;
      }
      this._toPage(queryData);
    },
    handleAdd() {
      this.showModal = true;
      this.handleType = "add";
    },
    handleEdit(params) {
      this.showModal = true;
      this.handleType = "edit";
      this.editRowIndex = params.index;
      this.formDetail = {
        id: params.row.id,
        name: params.row.name,
        description: params.row.description
      };
    },
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      const apiUrl = "/Role/deleteone";
      axios.request({
        url:apiUrl,
        params:{id}
      }).then(res=>{
        this.$Message.success("删除成功");
        this.tableData.splice(index, 1);
      })
    },
    handleFormSubmit(resData) {
      this.showModal = false;
      if (this.handleType == "add") {
        this.tableData.unshift(resData);
      } else {
        this.tableData.splice(this.editRowIndex, 1, resData);
      }
    },
    handleFormCancel() {
      this.showModal = false;
    },
    _finishedFetchData(res) {

      var queryData = this.$route.query;
      this.tableData = res.data.list;
      this.pageInfo = res.data.pageInfo;
      this.keywords = queryData.keywords;
      this.curPage = typeof queryData.p === 'undefined' ? 1 : parseInt(queryData.p)
    }
  },
  computed: {
    handleName() {
      let nameText = "";
      if (this.handleType == "add") {
        nameText = "新建角色";
      } else if (this.handleType == "edit") {
        nameText = "编辑角色";
      }
      return nameText;
    }
  },
  mounted() {
    this._fetchData(this._finishedFetchData);
  }
};
</script>