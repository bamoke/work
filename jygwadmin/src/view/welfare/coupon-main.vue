<template>
  <Card>
    <div slot="title">
      <Button type="primary" icon="ios-add-circle" @click.prevent="handleAdd">添加优惠券</Button>
    </div>
    <Table border :columns="columns" :data="tableData" :loading="tableLoading"></Table>
    <div class="m-paging-wrap">
      <Page
        :total="pageInfo.total"
        :current="pageInfo.page"
        :page-size="pageInfo.pageSize"
        @on-change="handleGoPage"
        v-show="pageInfo.total > pageInfo.pageSize"
      ></Page>
    </div>
    <Modal ref="couponform-modal" v-model="showModal" draggable scrollable>
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>{{modalTitle}}</span>
      </p>
      <CouponForm
        :form-data="couponFormInfo"
        :business-id="businessId"
        @form-saved="handleFormSubmit"
        @handle-cancel="showModal=false"
      />
      <p slot="footer"></p>
    </Modal>
  </Card>
</template>

<script>
import axios from "@/libs/api.request";
import CouponForm from "../coupon/coupon-form";
export default {
  name: "",
  components: { CouponForm },

  props: {},
  data() {
    return {
      columns: [
        { title: "优惠券面额", key: "title", width: 200 },

        { title: "使用说明", key: "description" },
        { title: "发放数量", key: "num", width: 120 },
        { title: "已领取", key: "receive_num", width: 120 },

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
                  props: { type: "info" },
                  style: { marginRight: "12px" },
                  on: {
                    click: () => {
                      this.handleGoLog(params);
                    }
                  }
                },
                "消费记录"
              ),
              h(
                "Button",
                {
                  on: { click: () => this.handleEdit(params) },
                  style: { marginRight: "12px" }
                },
                "修改"
              ),
              h("Button", "删除")
            ]);
          }
        }
      ],
      tableDataApi: "Coupon/vlist",
      tableData: [],
      businessId: null,
      tableLoading: true,
      curPage: 1,
      total: 0,
      pageSize: 15,
      keywords: "",
      pageInfo: { page: 1, pageSize: 10, total: 0 },
      editRowIndex: null,
      showModal: false,
      modalTitle: "添加优惠券",
      couponFormInfo: {}
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
    handleAdd() {
      this.showModal = true;
      this.modalTitle = "添加优惠券";
    },
    handleEdit(params) {
      this.editRowIndex = params.index;
      this.modalTitle = "修改优惠券";
      this.showModal = true;
      axios
        .request({
          url: `Coupon/detail/id/${params.row.id}`,
          method: "get"
        })
        .then(
          res => {
            this.couponFormInfo = res.data.info;
          },
          reject => {
            this.$Message.error("系统错误");
            console.log(reject);
          }
        );
    },
    handleDelete() {},
    handleFormSubmit(res) {
      console.log(res);
      if (this.modalTitle === "添加优惠券") {
        this.tableData.push(res.data.info);
      } else {
        this.$set(this.tableData, this.editRowIndex, res.data.info);
      }
      this.showModal = false;
    },
    handleFormCancel() {
      this.showModal = false;
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

    axios
      .request({
        url: `Coupon/vlist`,
        method: "get",
        params:{bid:businessId || ''}
      })
      .then(
        res => {
          this._finishedFetchData(res);
        },
        reject => {
          this.$Message.error("系统错误");
          console.log(reject);
        }
      );
  }
};
</script>

<style lang="scss" scoped>
</style>