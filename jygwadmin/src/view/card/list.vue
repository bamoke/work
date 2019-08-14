<template>
  <div>
    <Card>
      <div slot="title">
        <Row :gutter="8">
          <i-col span="8">
            <Input clearable placeholder="输入姓名或手机号码搜索" class="search-input" v-model="keywords"/>
          </i-col>
          <i-col span="2">
            <Button @click="handleSearch" class="search-btn" type="primary">
              <Icon type="search"/>&nbsp;&nbsp;搜索
            </Button>
          </i-col>
        </Row>
      </div>
      <Button type="primary" slot="extra" icon="ios-add-circle" @click.prevent="handleAdd">添加资料</Button>
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
        { title: "姓名", key: "realname", width: 120 },

        {
          title: "入驻状态",
          render: (h, params) => {
            let curItem = params.row;
            let className = "";
            let tempText = ""
            if (curItem.uid) {
              className = "s-text-success";
              tempText = "已入驻"
            }else {
              className = "s-text-light";
              tempText = "未入驻"
            } 
            return h("span", { class: className }, tempText);
          },
          width: 120
        },
        { title: "单位", key: "company" },
        { title: "职务", key: "position", width: 200 },

        { title: "创建时间", key: "create_time", width: 150, sortable: true },
        // { title: "操作", key: "handle", button: ["edit", "delete"], width: 200 }
      ],
      tableDataApi: "Card/vlist",
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

    handleAdd(){
      this.$Message.error("功能开发中")
    },
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      axios
        .request({
          url: "Event/deleteone",
          params: { id },
          method: "get"
        })
        .then(res => {
          this.$Message.success("删除成功");
          this.tableData.splice(index, 1);
        });
    },

    _finishedFetchData(res) {
      console.log(res)
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