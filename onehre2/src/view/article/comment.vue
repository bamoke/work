<template>
  <div>
    <Card>
        <Table border :columns="_customColumns" :data="tableData" :loading="formLoading"></Table>
        <div class="m-paging-wrap">
          <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="changePage" v-show="total > pageSize"></Page>
        </div>
    </Card>
  </div>
</template>

<script>
import { getTableList, deleteDataOne } from "@/api/data";
import tableMixin from "@/libs/table-mixin";
export default {
  name: "",
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      columns: [
        { title: "文章标题", key: "title", width: 300 },
        { title: "用户", key: "username", width: 120 },
        { title: "评论内容", key: "content"},
        { title: "创建时间", key: "create_time", width: 150, sortable: true },
        { title: "操作", key: "handle", button: ['delete'], width:120 }
      ],
      formLoading:false,
      tableDataApi: "ArticleComment/vlist",
      tableData: [],
      curPage: 1,
      total: 0,
      pageSize: 15,
    };
  },
  methods: {
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      const apiUrl = "ArticleComment/deleteone";
      deleteDataOne(apiUrl, id).then(res => {
        if(res) {
          this.$Message.success("删除成功");
          this.tableData.splice(index, 1);
        }

      });
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
  computed: {
  },
  mounted() {
    this._fetchData(this._finishedFetchData);
  }
};
</script>