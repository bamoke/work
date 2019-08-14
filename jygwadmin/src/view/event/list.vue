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
      <Button type="primary" slot="extra" icon="ios-add-circle" @click.prevent="handleAdd">添加活动</Button>
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
        { title: "活动标题", key: "title" },

        {
          title: "活动状态",
          render: (h, params) => {
            let curItem = params.row;
            let className = "";
            if (curItem.stage === 0) {
              className = "s-text-light";
            } else if (curItem.stage === 1) {
              className = "s-text-info";
            } else if (curItem.stage === 2) {
              className = "s-text-success";
            }
            return h("span", { class: className }, curItem.stageTxt);
          },
          width: 120
        },
        { title: "显示状态", key: "status", width: 120 },
        {
          title: "报名人数",
          render: (h, params) => {
            const curItem = params.row;
            return h(
              "Button",
              {
                props: { size: "default", icon: "ios-people" },
                on: { click: () => this.goEnrollPage(curItem.id) }
              },
              curItem.enroll_num
            );
          },
          width: 120
        },

        { title: "浏览量", key: "click", width: 120 },
        { title: "创建时间", key: "create_time", width: 150, sortable: true },
        { title: "操作", key: "handle", button: ["edit", "delete"], width: 200 }
      ],
      tableDataApi: "Event/vlist",
      tableData: [],
      keywords: "",
      pageInfo: { page: 1, pageSize: 10, total: 0 },
      editRowIndex: null
    };
  },
  methods: {
    goEnrollPage(eventId) {
      console.log(eventId);
      this.$router.push({ name: "event_enroll", params: { eventid: eventId } });
    },
    handleSearch() {
      let queryData = {};
      if (this.keywords != "") {
        queryData.keywords = this.keywords;
      }
      this._toPage(queryData);
    },
    handleAdd() {
      this.$router.push({ name: "event_add" });
    },
    handleEdit(params) {
      const id = params.row.id;
      this.$router.push({ name: "event_edit", params: { id } });
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