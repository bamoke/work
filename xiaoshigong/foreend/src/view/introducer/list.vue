<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:27:38
 * @LastEditTime: 2021-03-01 04:59:43
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
      <Button type="primary" icon="ios-add-circle" slot="extra" @click.prevent="handleAdd">新增中间人</Button>
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
        <span>{{formActype=='add'?'新增中间人':'修改中间人'}}</span>
      </p>
      <IntroducerForm :id="editId" @handle-submit="handleFormSubmit" @handle-cancel="handleFormCancel" />
      <p slot="footer"></p>
    </Modal>
  </div>
</template>

<script>
import IntroducerForm from "./main-form.vue";
import { getTableList, deleteDataOne } from "@/api/data";
export default {
  name: "introducer-list",
  components:{IntroducerForm},
  data() {
    return {
      tableLoading: true,
      columns: [
        { title: "姓名", key: "name", width: 260 },
        { title: "联系电话", key: "telphone", width: 220 },
        { title: "提成比例(%)", key: "percentage", width: 200 },
        { title: "备注说明", key: "description"},
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
        { title: "创建日期", key: "create_time", width:200 },
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
      deleteDataOne('/Introducer/deleteone',id).then(res => {
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
      getTableList('/Introducer/vlist',{ ...this.queryData }).then(res => {
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
  }
};
</script>

<style>
.m-paging-wrap {
  margin-top: 20px;
}
</style>
