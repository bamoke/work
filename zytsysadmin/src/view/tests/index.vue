<template>
  <div>
    <Card>
      <div slot="title">
        <Row :gutter="8">
          <i-col span="8">
            <Input clearable placeholder="输入项目名称关键字" class="search-input" v-model="keywords"/>
          </i-col>
          <i-col span="2">
            <Button @click="handleSearch" class="search-btn" type="primary">
              <Icon type="search"/>&nbsp;&nbsp;搜索
            </Button>
          </i-col>
        </Row>
      </div>
      <Button type="primary" slot="extra" @click.prevent="handleAdd">
        <Icon type="plus-circled" size="18px"></Icon>添加申报项目
      </Button>
      <Table border :columns="_customColumns" :data="tableData" :loading="tableLoading"></Table>
      <div class="m-paging-wrap">
        <Page
          :total="total"
          :current="curPage"
          :page-size="pageSize"
          @on-change="changePage"
          v-show="total > pageSize*curPage"
        ></Page>
      </div>
    </Card>
  </div>
</template>

<script>
import { getTableList, deleteDataOne } from "@/api/data";
import tableMixin from "@/libs/table-mixin";
import { routeOpenSelf } from "@/libs/util";
export default {
  name: "",
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      columns: [
        { title: "项目名称", key: "title", width: 300 },
        {
          title: "发布状态",
          key: "stage",
          width: 100,
          render: (h, params) => {
            let isReleased = parseInt(params.row.is_released);
            let tempObj;
            if (1 === isReleased) {
              tempObj = h("span", { class: "s-text-success" }, "已发布");
            } else {
              tempObj = h("span", "未发布");
            }
            return tempObj;
          }
        },
        { title: "创建时间", key: "date", width: 150, sortable: true },
        {
          title: "操作",
          key: "",
          render: (h, params) => {
            let isReleased = parseInt(params.row.is_released);
            let tempArr = [
              h(
                "Button",
                {
                  style: { marginRight: "12px" },
                  on: { click: () => this.handleEdit(params) }
                },
                "编辑"
              ),
              h(
                "Button",
                {
                  style: { marginRight: "12px" },
                  on: {
                    click: () => this.handleToPage("test_question_list", params)
                  }
                },
                "条件设置"
              )
 
            ];

            return h("div", tempArr);
          }
        }
      ],
      tableDataApi: "/Tests/vlist",
      tableLoading: false,
      tableData: [],
      keywords: "",
      curPage: 1,
      total: 0,
      pageSize: 0,
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
      this.$router.push({ name: "test_add" });
    },
    handleEdit(params) {
      const id = params.row.id;
      this.$router.push({ name: "test_edit", params: { testid: id } });
    },
    handleRelease(params) {},

    handleToPage(routeName, params) {
      const testId = params.row.id;
      this.$router.push({ name: routeName, params: { testid: testId } });
    },
    _finishedFetchData(res) {
      var queryData = this.$route.query;
      this.tableData = res.info.list;
      this.total = res.info.total;
      this.pageSize = parseInt(res.info.pageSize);
      this.keywords = queryData.keywords;
      this.curPage =
        typeof queryData.p === "undefined" ? 1 : parseInt(queryData.p);
    }
  },
  computed: {},
  mounted() {
    this._fetchData(this._finishedFetchData);
  }
};
</script>