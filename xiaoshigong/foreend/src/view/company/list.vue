<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:27:38
 * @LastEditTime: 2021-02-28 17:39:25
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div>
    <Card>
      <div slot="title">
        <Row :gutter="8">
          <i-col span="6">
            <Input
              clearable
              placeholder="输入关键字搜索"
              class="search-input"
              v-model="queryData.keyword"
            />
          </i-col>
          <i-col span="2">
            <Button @click="handleSearch" class="search-btn" type="primary">
              <Icon type="search" />&nbsp;&nbsp;搜索
            </Button>
          </i-col>
        </Row>
      </div>
      <Button type="primary" icon="ios-add-circle" slot="extra" @click.prevent="handleAdd">新建企业</Button>
      <Table border :columns="columns" :data="tableData" :loading="tableLoading" stripe></Table>
      <div class="m-paging-wrap">
        <Page
          :total="pageInfo.total"
          :current="pageInfo.page"
          :page-size="pageInfo.pageSize"
          @on-change="changePage"
        ></Page>
      </div>
    </Card>
    <Modal ref="com-form-modal" v-model="showModal" draggable scrollable>
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>{{formActype=='add'?'新建企业':'修改企业'}}</span>
      </p>
      <ComForm :id="editId" :area-arr="areaArr" :stationer-arr="stationerArr" @handle-submit="handleFormSubmit" @handle-cancel="handleFormCancel" />
      <p slot="footer"></p>
    </Modal>
  </div>
</template>

<script>
import ComForm from "./company-form.vue";
import { getCompanyList, deleteCompanyOne } from "@/api/company";
import { getStationerList } from "@/api/stationer";
import { getCity } from "@/api/classification";
export default {
  name: "company-list",
  components:{ComForm},
  data() {
    return {
      tableLoading: true,
      columns: [
        { title: "企业名称", key: "name", width: 260 },
        { title: "所在区域", key: "area_name", width: 100 },
        { title: "地址", key: "address", width: 300 },
        { title: "联系人", key: "contact", width: 120 },
        { title: "联系电话", key: "telphone", width: 220 },
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
                class: className
              },
              text
            );
          }
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
                    type: "default"
                  },
                  style: {
                    marginRight: "10px"
                  },
                  on: {
                    click: () => {
                      this.handleEdit(params);
                    }
                  }
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
            ]);
          }
        }
      ],
      stationerArr:[],
      areaArr:[],
      showModal:false,
      queryData: {},
      tableData: [],
      editId: 0,
      editRowIndex: null,
      showForm: false,
      formActype: "",
      pageInfo: {}
    };
  },
  methods: {
    changeSearchKey(e) {
      this.searchKey = e;
    },
    handleSearch() {
      this._fetchData();
    },
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      deleteCompanyOne(id).then(res => {
        this.$Message.success("删除成功");
        this.tableData.splice(index, 1);
      });
    },
    handleEdit(data) {
      this.editRowIndex = data.index;
      this.showModal = true;
      this.formActype = "edit";
      this.editId = parseInt(this.tableData[this.editRowIndex].id);
    },
    handleAdd() {
      this.showModal = true;
      this.formActype = "add";
      this.editId = 0;
    },
    handleFormCancel() {
      this.editId = 0;
      this.showModal = false;
    },
    handleFormSubmit(data) {
      this.showModal = false;
      this.editId = 0
      if (this.formActype == "add") {
        this.tableData.unshift(data);
      } else {
        this.tableData.splice(this.editRowIndex, 1, data);
      }
    },
    changePage: function(e) {
      const queryData = this.$route.query;
      var newQueryData = Object.assign({}, queryData);
      newQueryData.p = e;
      this._toPage(newQueryData);
      this._fetchData();
    },
    _toPage(queryData) {
      this.$router.push({
        name: "auth_user",
        query: queryData
      });
    },
    _fetchData() {
      getCompanyList({ ...this.queryData }).then(res => {
        this.tableData = res.data.list;
        this.pageInfo = parseInt(res.data.pageInfo);
        this.tableLoading = false;
      });
    },
    exportExcel() {
      this.$refs.tables.exportCsv({
        filename: `table-${new Date().valueOf()}.csv`
      });
    }
  },

  mounted() {
    this.queryData = this.$route.query;
    this._fetchData();
    getCity().then(res=>{
        this.areaArr = res.data.list

    })
    getStationerList().then(res=>{
        this.stationerArr = res.data.list
    })
  }
};
</script>

<style>
.m-paging-wrap {
  margin-top: 20px;
}
</style>
