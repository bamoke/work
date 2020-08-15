<template>
  <Card>
    <div slot="title">
      <Input
        search
        enter-button
        v-model="keywords"
        style="width:400px"
        @on-search="handleSearch"
        placeholder="请输入商家名称关键字"
      />
    </div>
    <Table border :columns="columns" :data="tableData" :loading="tableLoading"></Table>
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
</template>

<script>
import axios from "@/libs/api.request";
import CouponForm from "../coupon/coupon-form";
import tableMixin from "@/libs/table-mixin";
export default {
  name: "",
  components: { CouponForm },
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      columns: [
        { title: "优惠券面额", key: "title", width: 200 },
        { title: "所属商家", key: "businessname", width: 200 },
        { title: "使用说明", key: "description" },
        { title: "发放数量", key: "num", width: 120 },
        { title: "已领取", key: "receive_num", width: 120 },
        { title: "截至日期", key: "end_date", width: 120 },
        { title: "发布时间", key: "create_time", width: 200 },

        {
          title: "状态",
          key: "status",
          render: (h, params) => {
            let className =
              params.row.status == 1 ? "s-text-success" : "s-text-error";
            let text = params.row.status == 1 ? "正常" : "下架";
            return h("span", { class: className }, text);
          },
          width: 120
        },
        {
          title: "操作",
          key: "handle",
          render: (h, params) => {
            return h("div", [
              h(
                "Button",
                {
                  props: { 
                    type: "info",
                    to: { path: "coupon/log", query: { cid: params.row.id } }
                   }
                },
                "消费记录"
              )
            ]);
          }
        }
      ],
      tableDataApi: "Coupon/vlist",
      tableData: [],
      businessId: null,
      tableLoading: true,
      keywords: "",
      pageInfo: { page: 1, pageSize: 10, total: 0 }
    };
  },
  methods: {
    handleSearch() {
      let queryData = {};
      if (this.keywords !== "") {
        queryData.keywords = this.keywords;
      }
      this._toPage(queryData);
    },

    handleGoPage(e) {
      console.log(e);
    },
    handleGoLog() {},
    _finishedFetchData(res) {
      var queryData = this.$route.query;
      this.tableData = res.data.list;
      this.pageInfo = res.data.pageInfo;
      this.keywords = queryData.keywords;
      this.tableLoading = false;
    }
  },
  computed: {},
  mounted() {
    let businessId = parseInt(this.$route.params.id);
    this.businessId = businessId;
    this._fetchData(this._finishedFetchData);
  }
};
</script>

<style lang="scss" scoped>
</style>