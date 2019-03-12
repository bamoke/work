<template>
  <Card>
    <div slot="title">
      <Row :gutter="8">
        <i-col span="8">
          <Input clearable placeholder="请输入入场凭证号" class="search-input" v-model="keywords"/>
        </i-col>
        <i-col span="2">
          <Button @click="handleSearch" class="search-btn" type="primary">
            <Icon type="search"/>&nbsp;&nbsp;搜索
          </Button>
        </i-col>
      </Row>
    </div>
    <Table
      ref="ticketTable"
      border
      :columns="_customColumns"
      :data="tableData"
      :loading="formLoading"
    ></Table>
    <br>
    <Row>
      <i-col :sm="6">
        <Button type="primary" @click="exportData">
          <Icon type="ios-download-outline"></Icon>导出数据
        </Button>
      </i-col>
      <i-col :sm="18">
        <Page
          :total="total"
          :current="curPage"
          :page-size="pageSize"
          @on-change="changePage"
          :class="pullRight"
        ></Page>
      </i-col>
    </Row>
  </Card>
</template>
<script>
import { getTableList, getDataOne } from "@/api/data";
import tableMixin from "@/libs/table-mixin";
export default {
  name: "",
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      columns: [
        { title: "姓名", key: "realname", width: 100 },
        { title: "性别", key: "sex_name", width: 80 },
        { title: "手机号码", key: "phone", width: 150 },
        { title: "入场凭证号", key: "code" },
        { title: "日期", key: "date", width: 150, sortable: true }
      ],
      tableDataApi: "Ticket/vlist",
      formLoading: false,
      tableData: [],
      keywords: "",
      curPage: 1,
      total: 0,
      pageSize: 15,
      editRowIndex: null,
      pullRight: "pull-right"
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
    handleView(params) {
      const id = params.row.id;
      this.$router.push({ name: "resume_detail", params: { id } });
    },
    exportData() {
      if (this.tableData.length == 0) return;
      this.$refs.resumeTable.exportCsv({
        filename: "resume-p" + this.curPage,
        columns: this.columns.filter(
          (col, index) => index < this.columns.length - 1
        ),
        data: this.tableData
      });
    },
    _finishedFetchData(res) {
      var queryData = this.$route.query;
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