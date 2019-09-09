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
      <Button type="primary" slot="extra" icon="ios-add-circle" @click.prevent="handleAdd">添加产品</Button>
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
        { title: "产品名称", key: "title" },
        { title: "价格", key: "price", width: 120 },
        { title: "显示状态", key: "status", width: 120 },
        {
          title: "已售数量",
          key:"buy_num",
          width: 120
        },

        { title: "操作", key: "handle", button: ["edit"], width: 200 }
      ],
      tableDataApi: "Product/vlist",
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
      this.$router.push({ name: "product_add" });
    },
    handleEdit(params) {
      const id = params.row.id;
      this.$router.push({ name: "product_edit", params: { id } });
    },
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      axios
        .request({
          url: "product/deleteone",
          params: { id },
          method: "get"
        })
        .then(res => {
          this.$Message.success("删除成功");
          this.tableData.splice(index, 1);
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