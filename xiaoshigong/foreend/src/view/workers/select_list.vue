<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:27:38
 * @LastEditTime: 2021-03-04 13:13:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div>
    <Row :gutter="8">
      <i-col span="6">
        <Input clearable placeholder="输入关键字搜索" class="search-input" v-model="queryData.keyword" />
      </i-col>
      <i-col span="2">
        <Button @click="handleSearch" class="search-btn" type="primary">
          <Icon type="search" />&nbsp;&nbsp;搜索
        </Button>
      </i-col>
    </Row>
    <Table
      border
      :columns="columns"
      :data="tableData"
      :loading="tableLoading"
      @on-selection-change="selectionChange"
      stripe
    ></Table>
    <div class="m-paging-wrap">
      <Page
        :total="pageInfo.total"
        :current="pageInfo.page"
        :page-size="pageInfo.pageSize"
        @on-change="changePage"
      ></Page>
    </div>
  </div>
</template>

<script>
import { getTableList } from "@/api/data";
export default {
  name: "introducer-list",
  components: {},
  props:{
    isOpen:Boolean,
    default:false
  },
  data() {
    return {
      tableLoading: true,
      columns: [
        { type: "selection", width: 60, align: "center" },
        { title: "姓名", key: "name", width: 120 },
        { title: "性别", key: "gender", width: 80 },
        { title: "出生年月日", key: "birth", width: 120 },
        { title: "备注说明", key: "description" }
      ],
      queryData: {},
      tableData: [],
      pageInfo: {}
    };
  },
  methods: {
    selectionChange(e) {
      // console.log(e);
      this.$emit("on-selectd",e)
    },
    handleSearch() {
      this._fetchData();
    },
    changePage: function(e) {
      const queryData = this.$route.query;
      var newQueryData = Object.assign({}, queryData);
      newQueryData.page = e;
      this.queryData = newQueryData;
      this._fetchData();
    },

    _fetchData() {
      getTableList("/Worker/vlist", { ...this.queryData,"d_status":0 }).then(res => {
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
  watch:{
    isOpen:function(newVal) {
      if(newVal) {
        this.tableLoading = true
        this._fetchData()
      }
    }
  },

  mounted() {
    this.queryData = this.$route.query;
    // this._fetchData();
  }
};
</script>

<style>
.m-paging-wrap {
  margin-top: 20px;
}
</style>
