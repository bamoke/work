<template>
  <div>
    <Card>
      <div slot="title">
        <Row type="flex" justify="space-between" align="middle">
          <i-col span="8">
            <Input
              search
              enter-button
              v-model="keywords"
              placeholder="输入姓名或手机号关键字..."
              @on-search="handleSearch"
            />
          </i-col>
        </Row>
      </div>

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
        { title: "项目名称", key: "grantname", width: 300 },
        { title: "姓名", key: "realname", width: 100 },
        { title: "电话", key: "phone", width: 200 },
        { title: "邮箱", key: "email", width: 120 },
        { title: "申请时间", key: "create_time", width: 150, sortable: true },
        {
          title: "认捐状态",
          render: (h, params) => {
            const curItem = params.row;
            var className, statusTxt;
            if (curItem.stage == 0) {
              className = "s-text-error";
              statusTxt = "未确认";
            } else if (curItem.stage == 1) {
              className = "s-text-info";
              statusTxt = "已确认";
            } else {
              className = "s-text-success";
              statusTxt = "已完成捐助";
            }
            return h("span", { class: className }, statusTxt);
          },
          width: 120
        },
        {
          title: "操作",
          render: (h, params) => {
            const curItem = params.row;
            let DropdownMenu = h("DropdownMenu", { slot: "list" }, [
              h("DropdownItem", { props: { name: "0" } }, "未确认"),
              h("DropdownItem", { props: { name: "1" } }, "已确认"),
              h("DropdownItem", { props: { name: "2" } }, "已完成认捐")
            ]);
            let dropdownBtn = h(
              "Button",
              { props: { type: "primary"} },
              [
                h("span", { style: "marginRight:5px" }, "审核"),
                h("Icon", {
                  props: { type: "md-arrow-dropdown", size: "24" }
                })
              ]
            );
            return h(
              "Dropdown",
              {
                props: { trigger: "click" },
                on: { "on-click": e => this.handleVerify(curItem, e) }
              },
              [dropdownBtn, DropdownMenu]
            );
          }
        }
      ],
      tableDataApi: "Grants/apply",
      tableData: [],
      pageInfo: { page: 1, total: 0, pageSize: 15 },
      keywords: "",
      eventInfo: { title: "" },
      editRowIndex: null,
      curGrantId:null
    };
  },
  methods: {
    handleVerify(item, stage) {

      const rowIndex = item._index;
      axios
        .request({
          url: "/Grants/doverify",
          params: { id: item.id, stage },
          method: "get"
        })
        .then(res => {
          item.stage = stage;
        });
    },
    handleSearch(e) {
      let queryData = {};
      if(this.curGrantId) {
        queryData.grantid = this.curGrantId
      }
      if (this.keywords != "") {
        queryData.keywords = this.keywords;
      }
      this._toPage(queryData);
    },

    _finishedFetchData(res) {
      var queryData = this.$route.query;
      this.tableData = res.data.list;
      this.eventInfo = res.data.eventInfo;
      this.pageInfo = res.data.pageInfo;
    }
  },
  computed: {},
  mounted() {
    this._fetchData(this._finishedFetchData);
    if(this.$route.query.grantid) {
      this.curGrantId = this.$route.query.grantid
    }
  }
};
</script>
<style>
.ivu-table-wrapper {
  overflow: visible;
}
</style>
