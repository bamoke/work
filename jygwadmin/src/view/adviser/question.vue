<template>
  <Card>
    <div slot="title">
      <Form ref="searchForm" :model="searchInfo" label-position="right" inline>
        <FormItem>
          <Input
            clearable
            placeholder="输入标题关键字搜索"
            class="search-input"
            v-model="searchInfo.keywords"
            style="width:200px"
          />
        </FormItem>
        <FormItem>
          <Select v-model="searchInfo.cate" style="width:120px">
            <Option value="0">全部类别</Option>
            <Option v-for="item in cateList" :value="item.id" :key="item.id">{{item.name}}</Option>
          </Select>
        </FormItem>
        <FormItem>
          <Button @click="handleSearch" class="search-btn" type="primary">
            <Icon type="search" />&nbsp;&nbsp;搜索
          </Button>
        </FormItem>
      </Form>
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
    <Modal ref="adviseruser-modal" v-model="showModal" draggable scrollable>
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>{{modalTitle}}</span>
      </p>
      <QuestionVerifyForm
        :id="curEditId"
        @form-saved="handleFormSubmit"
        @on-cancel="handleFormCancel"
      />
      <p slot="footer"></p>
    </Modal>
  </Card>
</template>

<script>
import axios from "@/libs/api.request";
import tableMixin from "@/libs/table-mixin";
import QuestionVerifyForm from "./component/question_verify";
export default {
  name: "",
  components: { QuestionVerifyForm },
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      curEditId: null,
      columns: [
        { title: "问题标题", key: "title", width: 500 },

        { title: "所属类别", key: "cate_name", width: 120 },
        {
          title: "是否解决",
          key: "stage",
          width: 120,
          render: (h, params) => {
            var iconType = "ios-close-circle-outline";
            var color = "#9c9c9c";
            if (params.row.stage == 1) {
              iconType = "ios-checkmark-circle";
              color = "#19be6b";
            }
            return h("Icon", {
              props: {
                type: iconType,
                size: 18,
                color
              }
            });
          }
        },
        {
          title: "显示状态",
          key: "verify_status",
          width: 120,
          render: (h, params) => {
            var className = "s-text-error";
            var txt = "不显示";
            if (params.row.verify_status == 1) {
              className = "s-text-success";
              txt = "显示";
            }
            return h(
              "span",
              {
                class: className
              },
              txt
            );
          }
        },
        { title: "不显示原因", key: "verify_reason" },
        { title: "发布时间", key: "create_time", width: 200 },
        {
          title: "操作",
          width: 200,
          render: (h, params) => {
            return h("div", [
              h(
                "Button",
                {
                  style: { marginRight: "12px" },
                  on: { click: () => this.handleVerify(params) }
                },
                "审核"
              ),
              h(
                "Button",
                {
                  style: { marginRight: "12px" },
                  props: {
                    to: {
                      name: "adviser_question_detail",
                      params: { id: params.row.id }
                    }
                  }
                },
                "详细"
              )
            ]);
          }
        }
      ],
      tableDataApi: "AdviserQuestion/index",
      tableData: [],
      searchInfo: {cate:"0"},
      cateList: [],
      pageInfo: { page: 1, pageSize: 10, total: 0 },
      editRowIndex: null,
      showModal: false,
      modalTitle: "问题显示审核"
    };
  },
  methods: {
    handleSearch() {
      let queryData = {...this.searchInfo};
      if (this.keywords !== "") {
        queryData.keywords = this.keywords;
      }
      this._toPage(queryData);
    },

    handleVerify(params) {
      this.editRowIndex = params.index;
      this.curEditId = parseInt(params.row.id);
      this.showModal = true;
    },

    handleFormSubmit(res) {
      this.$set(this.tableData, this.editRowIndex, res.data.info);
      this.showModal = false;
      this.curEditId = null;
    },
    handleFormCancel() {
      this.showModal = false;
      this.curEditId = null;
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
    axios
      .request({
        url: `AdviserQuestion/cate`,
        method: "get"
      })
      .then(res => {
        this.cateList = res.data.list;
      });
  }
};
</script>
