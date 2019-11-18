<template>
  <div>
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
      <Button type="primary" slot="extra" icon="ios-add-circle" @click.prevent="handleAdd">添加代理商</Button>
      <Table border :columns="_customColumns" :data="tableData" :loading="tableLoading"></Table>
      <div class="m-paging-wrap">
        <Page
          :total="pageInfo.total"
          :current="pageInfo.page"
          :page-size="pageInfo.pageSize"
          @on-change="changePage"
          v-show="pageInfo.total > pageInfo.pageSize*pageInfo.page"
        ></Page>
      </div>
    </Card>
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
        { title: "名称", key: "name" },
        { title: "类别", key: "level_name", width: 120 },
        { title: "代理区域", key: "agent_area", width: 120 },
        {
          title: "合同状态",
          width: 100,
          render: (h, params) => {
            var statusText = params.row.status == 1 ? "正常" : "中止";
            var statusStyle = params.row.status == 1 ? "s-text-success" : "s-text-error";
            return h("span", { class: statusStyle }, statusText);
          }
        },
        { title: "到期日期", key: "contract_end", width: 150, sortable: true },
        {
          title: "操作",
          width: 300,
          render: (h, params) => {
            var statusBtnTxt = params.row.status == 0 ? "激活合同" : "中止合同";
            return h("div", [
              h(
                "Button",
                {
                  props: { type: "primary", size: "small", ghost: true },
                  on: { click: () => this.handleEdit(params) }
                },

                "编辑"
              ),
              h(
                "Button",
                {
                  props: {
                    type: "primary",
                    size: "small",
                    ghost: true,
                    to: {
                      name: "agent_account",
                      params: { agentid: params.row.id }
                    }
                  },
                  style: { marginLeft: "10px" }
                },
                "账号管理"
              ),
              h(
                "Button",
                {
                  props: {
                    type: "primary",
                    size: "small",
                    ghost: true,
                    to: {
                      name: "agent_config",
                      params: { agentid: params.row.id }
                    }
                  },
                  style: { marginLeft: "10px" }
                },
                "配置信息"
              ),
              h(
                "Button",
                {
                  props: {
                    type: "primary",
                    size: "small",
                    ghost: true
                  },
                  style: { marginLeft: "10px" },
                  on: { click: () => this.handleChangeStatus(params) }
                },
                statusBtnTxt
              )
            ]);
          }
        }
      ],
      tableDataApi: "Agent/vlist",
      tableData: [],
      keywords: "",
      pageInfo: { page: 1, pageSize: 10, total: 0 },
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
      this.$router.push("add");
    },
    handleEdit(params) {
      const id = params.row.id;
      this.$router.push({ name: "agent_edit", params: { id } });
    },

    handleChangeStatus(params) {
      const index = params.index;
      const id = params.row.id;
      var newRow = Object.assign({}, params.row);
      var newStatus = newRow.status == 1 ? 0 : 1;
      const apiUrl = "Agent/changestatus";
      axios
        .request({
          url: apiUrl,
          params: { id, status: newStatus },
          method: "get"
        })
        .then(res => {
          newRow.status = newStatus;
          this.$Message.success("操作成功");
          this.$set(this.tableData, index, newRow);
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
  }
};
</script>