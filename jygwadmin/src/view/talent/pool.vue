<template>
  <div>
    <Card>
      <div slot="title">
        <Row :gutter="8">
          <i-col span="8">
            <Input clearable placeholder="输入关键字搜索" class="search-input" v-model="keywords" />
          </i-col>
          <i-col span="2">
            <Button @click="handleSearch" class="search-btn" type="primary">
              <Icon type="search" />&nbsp;&nbsp;搜索
            </Button>
          </i-col>
        </Row>
      </div>
      <Button type="primary" slot="extra" icon="ios-add-circle" @click.prevent="handleImport">批量导入</Button>
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
    <Modal ref="adviseruser-modal" v-model="showModal" draggable scrollable>
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>人卡名单导入</span>
      </p>
      <PoolimportForm @form-saved="handleFormSubmit" @on-cancel="handleFormCancel" />
      <p slot="footer"></p>
    </Modal>
  </div>
</template>

<script>
import axios from "@/libs/api.request";
import tableMixin from "@/libs/table-mixin";
import PoolimportForm from "./components/poolimport-form";
export default {
  name: "",
  mixins: [tableMixin],
  components: {
    PoolimportForm
  },
  props: {},
  data() {
    return {
      columns: [
        { title: "人才卡号", key: "card_no", width: 200 },
        { title: "姓名", key: "realname", width: 320 },
        { title: "人才类型", key: "typename", width: 180 },
        { title: "人才级别", key: "level", width: 180 },
        { title: "爱心值", key: "love", width: 180 },
        { title: "积分", key: "score", width: 180 },
        { title: "有效期至", key: "end_date" }
      ],
      showModal: true,
      tableDataApi: "TalentPool/vlist",
      tableData: [],
      keywords: "",
      pageInfo: { page: 1, pageSize: 10, total: 0 },
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
    handleImport() {
      this.showModal = false;
    },

    handleFormSubmit(res) {
      axios
        .request({
          url: this.tableDataApi,
          method: "get"
        })
        .then(res => {
          this.tableData = res.data.list;
          this.pageInfo = res.data.pageInfo;
        });
      this.showModal = false;
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
  }
};
</script>