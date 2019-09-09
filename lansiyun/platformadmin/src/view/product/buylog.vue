<template>
  <div>
    <Card>
      <div slot="title">
        <Row type="flex" justify="space-between" align="middle">
          <i-col span="16">
            <div class="u-event-title">
              活动名称：
              <strong>{{eventInfo.title}}</strong>
            </div>
          </i-col>
          <i-col span="4">
            <Input
              search
              enter-button
              v-model="keywords"
              placeholder="输入姓名..."
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
        { title: "姓名", key: "realname", width: 100 },
        { title: "单位", key: "company", width: 200 },
        { title: "电话", key: "phone", width: 200 },
        { title: "邮箱", key: "email", width: 120 },
        { title: "报名时间", key: "create_time", width: 150, sortable: true },
        {
          title: "审核状态",
          render: (h, params) => {
            const curItem = params.row;
            var className, statusTxt;
            if (curItem.status == 0) {
              className = "s-text-error";
              statusTxt = "未通过";
            } else if (curItem.status == 1) {
              className = "s-text-info";
              statusTxt = "待审核";
            } else {
              className = "s-text-success";
              statusTxt = "通过";
            }
            return h("span", { class: className }, statusTxt);
          },
          width: 120
        },
        {
          title: "操作",
          render: (h, params) => {
            const curItem = params.row;
            if (curItem.status != 1) {
              return h(
                "Button",
                { on: { click: () => this.handleVerify(curItem, 1) } },
                "反审核"
              );
            } else {
              let DropdownMenu = h("DropdownMenu", { slot: "list" }, [
                h("DropdownItem", { props: { name: "2" } }, "通过"),
                h("DropdownItem", { props: { name: "0" } }, "不通过")
              ]);
              let dropdownBtn = h(
                "Button",
                { props: { type: "primary", size: "small" } },
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
        }
      ],
      tableDataApi: "EventEnroll/vlist",
      tableData: [],
      pageInfo: { page: 1, total: 0, pageSize: 15 },
      keywords: "",
      eventInfo: { title: "" },
      editRowIndex: null
    };
  },
  methods: {
    handleVerify(item, status) {
      const rowIndex = item._index;
      axios
        .request({
          url: "/EventEnroll/doverify",
          params: { id: item.id, status },
          method: "get"
        })
        .then(res => {
          item.status = status;
        });
    },
    handleSearch(e) {
      let queryData = {};
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
  }
};
</script>
<style>
.ivu-table-wrapper {
  overflow: visible;
}
</style>
