<template>
  <Card>
    <div slot="title">
      <Button type="primary" icon="ios-add-circle" @click.prevent="handleAdd">添加账号</Button>
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
    <Modal ref="account-modal" v-model="showModal" draggable scrollable>
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>{{formActype == 'add'? '添加账号':'修改账号'}}</span>
      </p>
      <AccountForm
        :init-form-data="editFormData"
        :ac-type="formActype"
        @form-saved="handleFormSubmit"
        @handle-cancel="showModal=false"
      />
      <p slot="footer"></p>
    </Modal>
  </Card>
</template>

<script>
import axios from "@/libs/api.request";
import AccountForm from "./account-form";
export default {
  name: "",
  components: { AccountForm },

  props: {},
  data() {
    return {
      columns: [
        { title: "账号", key: "username", width: 200 },

        { title: "姓名", key: "realname", width: 200 },

        {
          title: "状态",
          key: "status",
          render: (h, params) => {
            let className =
              params.row.status == 1 ? "s-text-success" : "s-text-error";
            let text = params.row.status == 1 ? "正常" : "禁用";
            return h("span", { class: className }, text);
          },
          width: 120
        },
        { title: "创建时间", key: "create_time", width: 200 },
        {
          title: "操作",
          key: "handle",
          render: (h, params) => {
            return h("div", [
              h(
                "Button",
                {
                  props: { type: "info" },
                  on: { click: () => this.handleEdit(params) },
                  style: { marginRight: "12px" }
                },
                "修改"
              ),
              h(
                "Button",
                {
                  on: {
                    click: () => {
                      this.handleDelete(params);
                    }
                  }
                },
                "删除"
              )
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
      editRow: {},
      editFormData: {},
      showModal: false,
      formActype: "add",
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
      this.formActype = "add";
      this.editFormData = { status: "1", b_id: this.businessId };
    },
    handleEdit(params) {
      this.editFormData = {
        id:params.row.id,
        b_id:params.row.b_id,
        username:params.row.username,
        realname:params.row.realname,
        status:params.row.status
      };
      this.editRow = params.row;
      this.formActype = "edit";
      this.showModal = true;
    },
    handleDelete() {},
    handleFormSubmit(res) {
      if (this.formActype === "add") {
        this.tableData.push(res.data.info);
      } else {
        this.$set(this.tableData, this.editRow._index, res.data.info);
      }
      this.showModal = false;
    },

    handleFormCancel() {
      this.showModal = false;
    },
    handleGoPage(e) {
      console.log(e);
    },
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
        url: `BusinessAccount/vlist/bid/${businessId}`,
        method: "get"
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