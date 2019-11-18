<template>
  <Card title="模块价格">
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
import tableMixin from "@/libs/table-mixin";
export default {
  mixins: [tableMixin],
  data() {
    return {
      columns: [
        { title: "模块类别", key: "catename", width: 120 },
        { title: "模块名称", key: "name", width: 250 },
        {
          title: "销售价",
          width: 150,
          render: (h, params) => {
            return h("span", { class: 's-text-error' }, params.row.price);
          }
        },
        { title: "销售数量", key: "sell_num", width: 150 },

    
      ],
      tableLoading: true,
      tableData: [],
      pageInfo: { total: 0 },
      tableDataApi: "Price/mokuai",
      showModal: false,
      editIndex:0,
      editForm:{},
      submitting: false
    };
  },
  methods: {
    handleSetPrice(index) {
 
      var curItem = Object.assign({}, this.tableData[index]);
      this.editIndex = index;
      this.editForm = curItem;
      this.showModal = true;
      // console.log(this.editForm)
    },
    doSave() {
      const newPrice = this.editForm.new_price;
      if (!newPrice) {
        this.$Message.error("请输入销售价格");
        return;
      }
      this.submitting = true;
      axios
        .request({
          url: "Price/dosave",
          data: { actype: 2, ...this.editForm },
          method: "post"
        })
        .then(
          res => {
            this.submitting = false;
            this.showModal = false;
            if (res.data.priceid) {
              this.editForm.price_id = res.data.priceid;
            }
            this.$set(this.tableData, this.editIndex, this.editForm);
          },
          reject => {
            this.submitting = false;
            this.showModal = false;
          }
        );
    },
    _finishedFetchData(res) {
      var queryData = this.$route.query;
      this.tableData = res.data.list;
      this.pageInfo = res.data.pageInfo;
      this.tableLoading = false;
    }
  },
  mounted() {
    this._fetchData(this._finishedFetchData);
  }
};
</script>