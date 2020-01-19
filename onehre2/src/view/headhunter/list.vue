<template>
  <div>
    <Card>
      <div slot="title">
        <Row :gutter="8">
          <i-col span="8">
            <Input clearable placeholder="输入职位名称关键字" class="search-input" v-model="keywords" />
          </i-col>
          <i-col span="2">
            <Button @click="handleSearch" class="search-btn" type="primary">
              <Icon type="search" />&nbsp;&nbsp;搜索
            </Button>
          </i-col>
        </Row>
      </div>
      <Button type="primary" slot="extra" @click.prevent="handleAdd">
        <Icon type="plus-circled" size="18px"></Icon>添加职位
      </Button>
      <Table border :columns="_customColumns" :data="tableData" :loading="formLoading"></Table>
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
import { getTableList, deleteDataOne } from "@/api/data";
import tableMixin from "@/libs/table-mixin";
export default {
  name: "",
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      columns: [
        { title: "职位名称", key: "title", width: 200 },
        { title: "工作地点", key: "work_addr", width: 100 },
        { title: "薪资待遇", key: "work_wage", width: 100 },
        { title: "学历要求", key: "work_edu", width: 100 },
        { title: "招聘单位", key: "comname", width: 200 },
        { title: "显示状态", key: "status", width: 100 },
        { title: "创建时间", key: "create_time", width: 150, sortable: true },
        {
          title: "操作",
          key: "handle",
          button:['edit','delete']

        }
      ],
      tableDataApi: "Headhunter/vlist",
      formLoading: false,
      tableData: [],
      pageInfo: { page: 1, total: 0, pageSize: 15 },
      keywords: "",
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
      this.$router.push({ name: "headhunter_edit", params: { id } });
    },

    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      const apiUrl = "Headhunter/deleteone";
      deleteDataOne(apiUrl, id).then(res => {
        if (res) {
          this.$Message.success("删除成功");
          this.tableData.splice(index, 1);
        }
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