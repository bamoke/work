<template>
  <div>
    <Card>
      <div slot="title">
        <Row :gutter="8">
          <i-col span="8">
            <Input clearable placeholder="输入关键字搜索" class="search-input" v-model="keywords"/>
          </i-col>
          <i-col span="2">
            <Button @click="handleSearch" class="search-btn" type="primary">
              <Icon type="search"/>&nbsp;&nbsp;搜索
            </Button>
          </i-col>
        </Row>
      </div>
      <Button type="primary" slot="extra" icon="ios-add-circle" @click.prevent="handleAdd">添加项目</Button>
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
        { title: "项目名称",width: 200, key: "title" },

        { title: "描述", key: "description" },
        { title: "显示状态", key: "status", width: 120 },
        { title: "操作", key: "handle", button: ["edit", "delete"], width: 200 }
      ],
      tableDataApi: "Service/vlist",
      tableData: [],
      keywords: "",
      pageInfo: { page: 1, pageSize: 15, total: 0 },
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
      this.$router.push({ name: "service_add" });
    },
    handleEdit(params) {
      const id = params.row.id;
      this.$router.push({ name: "service_edit", params: { id } });
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