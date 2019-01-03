<template>
  <div>
    <Card>
        <h3 slot="title">
          【{{testInfo['title']}}】——测试记录
        </h3>
        <Table border :columns="_customColumns" :data="tableData" :loading="tableLoading"></Table>
        <div class="m-paging-wrap">
          <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="changePage" v-show="total > pageSize"></Page>
        </div>
    </Card>
  </div>
</template>

<script>
import { getTableList, deleteDataOne } from "@/api/data";
import tableMixin from "@/libs/table-mixin";
import {routeOpenSelf} from '@/libs/util'
export default {
  name: "",
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      columns: [
        { title: "用户", key: "realname", width: 100 },
        { title: "题目总计", key: "question_total", width: 100 },
        { title: "正确数", key: "correct_total", width: 100 },
        { title: "错误数", key: "error_total", width: 100 },
        { title: "总分数", key: "score", width: 100 ,sortable: true},
        { title: "完成时间", key: "create_time", sortable: true }
      ],
      tableDataApi: "/Tests/logs",
      tableLoading: false,
      testInfo:{},
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
      this.$router.push({ name: "class_tests_add"});
    },
    handleEdit(params) {
      const id = params.row.id;
      this.$router.push({ name: "test_edit", params: { testid:id } });
    },
    handleRelease(params) {},
 
    handleToPage(routeName,params){
      const testId = params.row.id
      this.$router.push({name:routeName,params:{testid:testId}})
    },
    _finishedFetchData(res) {
      var queryData = this.$route.query;
      this.testInfo = res.data.testInfo;
      this.tableData = res.data.list;
      this.total = res.data.total;
      this.pageSize = parseInt(res.data.pageSize);
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