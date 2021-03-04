<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:27:38
 * @LastEditTime: 2021-03-04 01:23:39
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
  components:{},
  data() {
    return {
      tableLoading: true,
      columns: [
        { title: "姓名", key: "worker_name", width: 120 },
        { title: "企业名称", key: "comname", width: 220 },
        { title: "职位名称", key: "jobname", width: 180 },
        { title: "收益", key: "revenue", width: 100 },
        { title: "备注说明", key: "description"},
        {
          title: "状态",
          key: "status",
          width: 150,
          render: (h, params) => {
            var text;
            var className;
            if (params.row.status == 1) {
              text = "派遣中";
              className = "text-success";
            } else {
              text = "已结束";
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
            if(params.row.status == 0) {
              return h('span')
            }
            return h("div", [
              h(
                "Button",
                {
                  props: {
                    type: "default"
                  },
                  on: {
                    click: () => {
                      this.handleEnd(params);
                    }
                  }
                },
                "结束派遣"
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
    handleEnd(params) {
      const index = params.index;
      const id = params.row.id;
      deleteDataOne('/Introducer/deleteone',id).then(res => {
        this.$Message.success("删除成功");
        this.tableData.splice(index, 1);
      });
    },


    changePage: function(e) {
      const queryData = this.$route.query;
      var newQueryData = Object.assign({}, queryData);
      newQueryData.p = e;
      this._toPage(newQueryData);
      this._fetchData();
    },

    _fetchData() {
      getTableList('/Dispatch/vlist',{ ...this.queryData }).then(res => {
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
