<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:27:38
 * @LastEditTime: 2021-03-04 13:08:49
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
      <Button type="primary" icon="ios-add-circle" slot="extra" @click.prevent="handleAdd">新增职位</Button>
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
        <span>{{formActype=='add'?'新增职位':'修改职位'}}</span>
      </p>
      <mainForm
        :id="editId"
        :type-arr="typeArr"
        @handle-submit="handleFormSubmit"
        @handle-cancel="handleFormCancel"
      />
      <p slot="footer"></p>
    </Modal>

    <Drawer title="选择派遣劳工" :closable="false" v-model="showDrawer" width="640">
      <workerTable :is-open="showDrawer" @on-selectd="handleSelectWorker"></workerTable>
      <div class="m-drawer-footer">
        <Button style="margin-right: 8px;width:200px;" type="primary" :size="'large'" @click="handleSetDispatch">提交</Button>
        <Button  @click="showDrawer = false">取消</Button>
      </div>
    </Drawer>
  </div>
</template>

<script>
import mainForm from "./main-form.vue";
import workerTable from "../workers/select_list";
import { getTableList, deleteDataOne, getDataOne, saveData } from "@/api/data";
export default {
  name: "job-list",
  components: { mainForm, workerTable },
  data() {
    return {
      tableLoading: true,
      columns: [
        { title: "职位名称", key: "title", width: 160 },
        { title: "公司名称", key: "comname", width: 240 },
        { title: "工作性质", key: "typename", width: 120 },
        { title: "薪资待遇", key: "wage", width: 220 },
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
        { title: "创建日期", key: "create_time", width: 200 },
        {
          title: "操作",
          key: "handle",
          render: (h, params) => {
            var nodeObject = [
              h(
                "Button",
                {
                  props: {
                    type: "default",
                    icon: "md-create"
                  },
                  style: {
                    marginRight: "12px"
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
                [h("Button", { props: { icon: "ios-trash" } }, "删除")]
              )
            ];
            if (params.row.status == 1) {
              nodeObject.unshift(
                h(
                  "Button",
                  {
                    props: { icon: "md-person-add" },
                    style: { marginRight: "12px" },
                    on: {
                      click: () => {
                        this.handleOpenDrawer(params);
                      }
                    }
                  },
                  "派遣劳工"
                )
              );
            }
            return h("div", nodeObject);
          }
        }
      ],
      typeArr: [],
      showModal: false,
      showDrawer: false,
      seletedWorkerList: [],
      dispatchJobId: null,
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
    //
    handleOpenDrawer(params) {
      this.showDrawer = true;
      this.dispatchJobId = params.row.id;
    },
    //
    handleSetDispatch() {
      if (this.seletedWorkerList.length == 0) {
        return this.$Message.error("请选择需要派遣的劳工");
      }
      saveData("Dispatch/save", {
        jobid: this.dispatchJobId,
        workerid: this.seletedWorkerList
      }).then(res => {
        if (res) {
          this.$Message.success("操作成功");
          this.showDrawer = false;
        }
      });
    },
    handleSelectWorker(e) {
      var workerIds = [];
      if (e.length) {
        workerIds = e.map(function(item) {
          return item.id;
        });
      }
      this.seletedWorkerList = workerIds;
    },
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      deleteDataOne("/Job/deleteone", id).then(res => {
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
      this.editId = 0;
      if (this.formActype == "add") {
        this.tableData.unshift(data);
      } else {
        this.tableData.splice(this.editRowIndex, 1, data);
      }
    },
    changePage: function(e) {
      const queryData = this.$route.query;
      var newQueryData = Object.assign({}, queryData);
      newQueryData.page = e;
      this._toPage(newQueryData);
      // this._fetchData();
    },
    _toPage(queryData) {
      this.$router.push({
        name: "job_list",
        query: queryData
      });
    },
    _fetchData() {
      getTableList("/Job/vlist", { ...this.queryData }).then(res => {
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
    getDataOne("Classification/get_jobtype").then(res => {
      this.typeArr = res.data.list;
    });
  }
};
</script>

<style>
.m-paging-wrap {
  margin-top: 20px;
}
.m-drawer-footer {
  width: 100%;
  position: absolute;
  bottom: 0;
  left: 0;
  border-top: 1px solid #e8e8e8;
  padding: 10px 16px;
  background: #fff;
}
</style>
