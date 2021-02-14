<template>
  <Card>
    <div slot="title">
      <div class="m-coupon-info" v-if="couponId">
        <div class="business-name">所属商家：{{couponInfo.businessname}}</div>
        <div class="desc">优惠券面额：{{couponInfo.couponname}}</div>
      </div>
      <div>
        <Form ref="searchForm" inline>
          <FormItem class="no-margin">
            <ButtonGroup>
              <Button :type="stageAllStyle" @click="handleStageChange('0')">全部</Button>
              <Button :type="stageUsedStyle" @click="handleStageChange('2')">已使用</Button>
              <Button :type="stageUnusedStyle" @click="handleStageChange('1')">未使用</Button>
            </ButtonGroup>
          </FormItem>
          <FormItem class="no-margin">
            <Input enter-button v-model="keywords" style="width:400px" placeholder="请输入关键字">
              <Select v-model="searchType" style="width:80px" slot="prepend">
                <Option value="businessname" v-if="!couponId">商户名称</Option>
                <Option value="username">用户姓名</Option>
                <Option value="code">优惠券码</Option>
              </Select>
            </Input>
          </FormItem>
          <FormItem class="no-margin">
            <Button type="primary" @click="handleSearchSubmit('searchForm')">搜索</Button>
          </FormItem>
        </Form>
      </div>
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
        { title: "用户姓名", key: "username", width: 120 },
        { title: "优惠券码", key: "code", width: 120 },
        { title: "优惠券面额", key: "title", width: 200 },
        { title: "所属商家", key: "businessname", width: 200 },
        { title: "使用说明", key: "description" },
        { title: "截至日期", key: "end_date", width: 120 },
        { title: "领取时间", key: "create_time", width: 200 },

        {
          title: "使用状态",
          key: "stage",
          render: (h, params) => {
            let className = params.row.stage == 1 ? "s-text-success" : "";
            let text = params.row.stage == 1 ? "已使用" : "未使用";
            return h("span", { class: className }, text);
          },
          width: 120
        },
        { title: "使用地点", key: "use_addr" },
        { title: "使用时间", key: "use_time", width: 200 }
      ],
      tableDataApi: "CouponLog/vlist",
      tableData: [],
      couponId: null,
      couponInfo: {},
      tableLoading: true,
      searchType: "",
      keywords: "",
      curStageSelected: "0",
      pageInfo: { page: 1, pageSize: 10, total: 0 }
    };
  },
  methods: {
    handleSearchSubmit() {
      let queryData = {
        skey: this.searchType
      };
      if (!this.searchType) {
        this.$Message.error("请选择搜索类型");
        return;
      }
      if (this.keywords != "") {
        queryData.keywords = this.keywords;
      }
      if (this.couponId) {
        queryData.cid = this.couponId;
      }
      this._toPage(queryData);
    },
    handleStageChange(e) {
      let queryData = {};
      if (this.keywords) {
        queryData.keywords = this.keywords;
      }
      if (this.searchType) {
        queryData.skey = this.searchType;
      }
      if (this.couponId) {
        queryData.cid = this.couponId;
      }
      queryData.stage = e;
      this.curStageSelected = e;
      this._toPage(queryData);
    },

    _finishedFetchData(res) {
      this.tableData = res.data.list;
      this.pageInfo = res.data.pageInfo;

      this.tableLoading = false;
    }
  },
  computed: {
    stageAllStyle() {
      return this.curStageSelected === "0" ? "primary" : "default";
    },
    stageUsedStyle() {
      return this.curStageSelected === "2" ? "primary" : "default";
    },
    stageUnusedStyle() {
      return this.curStageSelected === "1" ? "primary" : "default";
    }
  },
  watch: {
    $route: function(newVal) {
      var queryData = this.$route.query;
      this.couponId = queryData.cid || null;
      this.keywords = queryData.keywords || "";
      this.searchType = queryData.skey || "businessname";
    }
  },
  mounted() {
    var queryData = this.$route.query;
    
    this.keywords = queryData.keywords || "";
    this.searchType = queryData.skey || "businessname";
    this.curStageSelected = queryData.stage || "0";
    if (queryData.cid) {
      this.couponId = queryData.cid;
      axios
        .request({
          url: `CouponLog/coupon_desc/id/${queryData.cid}`
        })
        .then(res => {
          this.couponInfo = res.data.info;
        });
    }
    this._fetchData(this._finishedFetchData);
  }
};
</script>

<style>
.no-margin {
  margin-bottom: 0;
}
.m-coupon-info {
  padding-bottom: 12px;
}
.m-coupon-info .business-name {
  margin-bottom: 12px;
  font-size: 16px;
  line-height: 1;
}
</style>