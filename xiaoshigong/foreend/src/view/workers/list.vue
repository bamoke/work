<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:27:38
 * @LastEditTime: 2021-03-02 18:17:27
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
      <Button type="primary" icon="ios-add-circle" slot="extra" @click.prevent="handleAdd">新增劳工</Button>
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
  </div>
</template>

<script>
import { getTableList, deleteDataOne } from "@/api/data";
export default {
  name: "introducer-list",
  components: {},
  data() {
    return {
      tableLoading: true,
      columns: [
        { title: "姓名", key: "name", width: 120 },
        { title: "手机号码", key: "mobile", width: 220 },
        { title: "性别", key: "gender", width: 80 },
        { title: "出生年月日", key: "birth", width: 120 },
        {
          title: "劳工状态",
          key: "status",
          width: 120,
          render: (h, params) => {
            var text;
            var className;
            if (params.row.status == 1) {
              text = "正常";
              className = "text-success";
            } else {
              text = "异常";
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
        { title: "备注说明", key: "description" },
        {
          title: "派遣状态",
          key: "dispatch_status",
          width: 150,
          render: (h, params) => {
            var text;
            var className;
            if (params.row.dispatch_status == 1) {
              text = "派遣中";
              className = "text-success";
            } else {
              text = "未派遣";
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
        { title: "账户金额", key: "capital", width: 120 },
        { title: "创建日期", key: "create_time", width: 200 },
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
      showModal: false,
      queryData: {},
      tableData: [],
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
      deleteDataOne("/Worker/deleteone", id).then(res => {
        this.$Message.success("删除成功");
        this.tableData.splice(index, 1);
      });
    },
    handleEdit(data) {
      this.editRowIndex = data.index
      this.$router.push({name:"worker_edit",params:{id:data.row.id}})
    },
    handleAdd() {
      this.$router.push({ name: "worker_add" });
    },

    changePage: function(e) {
      const queryData = this.$route.query;
      var newQueryData = Object.assign({}, queryData);
      newQueryData.p = e;
      this._fetchData();
    },

    _fetchData() {
      getTableList("/Worker/vlist", { ...this.queryData }).then(res => {
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
