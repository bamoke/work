<template>
  <div>
    <Card>
      <div slot="title">
        <Row type="flex" justify="space-between" align="middle">
          <i-col span="6" v-if="curChoujiangId">
            <h3>{{choujiangInfo.title}}</h3>
          </i-col>
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
      <div class="m-paging-wrap" style="display:flex;">
        <Button @click="handleExportExcel" type="primary" style="margin-right:100px;">导出数据</Button>
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
import excel from "@/libs/excel";
import axios from "@/libs/api.request";
import tableMixin from "@/libs/table-mixin";
export default {
  name: "",
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      columns: [
        { title: "活动名称", key: "cj_name", width: 300 },

        { title: "姓名", key: "realname", width: 100 },
        { title: "电话", key: "phone", width: 120 },
        { title: "地址", key: "addr" },
        { title: "所获奖品", key: "award", width: 200 },
        { title: "中奖时间", key: "create_time", width: 150, sortable: true },
        {
          title: "兑奖状态",
          render: (h, params) => {
            const curItem = params.row;
            var className, statusTxt;
            if (curItem.stage == 0) {
              className = "s-text-error";
              statusTxt = "未兑奖";
            } else if (curItem.stage == 1) {
              className = "s-text-success";
              statusTxt = "进行中";
            } else {
              className = "s-text-success";
              statusTxt = "已收到奖品";
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
              h("DropdownItem", { props: { name: "0" } }, "未兑奖"),
              h("DropdownItem", { props: { name: "1" } }, "兑奖进行中"),
              h("DropdownItem", { props: { name: "2" } }, "已收到奖品")
            ]);
            let dropdownBtn = h("Button", { props: { type: "primary" } }, [
              h("span", { style: "marginRight:5px" }, "审核"),
              h("Icon", {
                props: { type: "md-arrow-dropdown", size: "24" }
              })
            ]);
            return h(
              "Dropdown",
              {
                props: { trigger: "click" },
                on: { "on-click": e => this.handleVerify(curItem, e) }
              },
              [dropdownBtn, DropdownMenu]
            );
          },
          width: 150
        }
      ],
      tableDataApi: "Choujiang/logs",
      tableData: [],
      pageInfo: { page: 1, total: 0, pageSize: 15 },
      keywords: "",
      eventInfo: { title: "" },
      editRowIndex: null,
      curChoujiangId: null,
      choujiangInfo: {}
    };
  },
  methods: {
    handleVerify(item, stage) {
      const rowIndex = item._index;
      axios
        .request({
          url: "/Choujiang/doverify",
          params: { id: item.id, stage },
          method: "get"
        })
        .then(res => {
          item.stage = stage;
        });
    },
    handleSearch(e) {
      let queryData = {};
      if (this.curChoujiangId) {
        queryData.cid = this.curChoujiangId;
      }
      if (this.keywords != "") {
        queryData.keywords = this.keywords;
      }
      this._toPage(queryData);
    },
    handleExportExcel() {
      if (this.tableData.length) {
        this.exportLoading = true;
        const params = {
          title: ["奖品名称", "姓名", "电话", "地址", "中奖时间"],
          key: ["award", "realname", "phone", "addr", "create_time"],
          data: this.tableData,
          autoWidth: true,
          filename: this.tableData[0].cj_name + "-中奖名单-第" + this.pageInfo.page + "页"
        };
        excel.export_array_to_excel(params);
        this.exportLoading = false;
      } else {
        this.$Message.info("表格数据不能为空！");
      }
    },

    _finishedFetchData(res) {
      var queryData = this.$route.query;
      this.tableData = res.data.list;
      this.choujiangInfo = res.data.cjInfo;
      this.pageInfo = res.data.pageInfo;
    }
  },
  computed: {},
  mounted() {
    this._fetchData(this._finishedFetchData);
    if (this.$route.query.cid) {
      this.curChoujiangId = this.$route.query.cid;
    }
  }
};
</script>
<style>
.ivu-table-wrapper {
  overflow: visible;
}
</style>
