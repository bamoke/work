<template>
  <div>
    <Card>
        <div slot="title">
          <Row :gutter="8">
                <i-col span="8">
                <Input clearable placeholder="输入关键字搜索" class="search-input" v-model="keywords"/>
                </i-col>
                <i-col span="2">
                <Button @click="handleSearch" class="search-btn" type="primary"><Icon type="search"/>&nbsp;&nbsp;搜索</Button>
                </i-col>
          </Row>
        </div>
        <Button type="primary" slot="extra" icon="ios-add-circle" @click.prevent="handleAdd">添加文章</Button>
        <Table border :columns="_customColumns" :data="tableData" :loading="tableLoading"></Table>
        <div class="m-paging-wrap">
          <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="changePage" v-show="total > pageSize"></Page>
        </div>
    </Card>
  </div>
</template>
<script>
import axios from '@/libs/api.request'
import tableMixin from "@/libs/table-mixin"
export default {
  name: "",
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      columns: [
        { title: "标题", key: "title"},
        { title: "有英文版", key: "is_en",width:120,render:(h,params)=>{
          var iconType = 'ios-close-circle-outline'
          var color="#9c9c9c";
          if(params.row.is_en == 1) {
            iconType = 'ios-checkmark-circle'
            color = '#19be6b'
          }
          return h("Icon",{props:{
            type:iconType,
            size:18,
            color
          }})
        }},
        { title: "类别", key: "catename", width: 200 },
        { title: "浏览量", key: "click", width: 120 },
        { title: "状态", key: "status", width: 80 },
        { title: "创建时间", key: "create_time", width: 150, sortable: true },
        { title: "操作", key: "handle", button: ["edit",'delete'],width:200 }
      ],
      tableDataApi: "Article/vlist",
      tableData: [],
      keywords: "",
      curPage: 1,
      total: 0,
      pageSize: 15,
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
      this.$router.push({ name: "article_edit", params: { id } });
    },
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      const apiUrl = "Article/deleteone";
      axios.request({
        url: "Article/deleteone",
        params: {id},
        method: "get"
      }).then(res=>{
          this.$Message.success("删除成功");
          this.tableData.splice(index, 1);
      })

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