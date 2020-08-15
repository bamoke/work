<template>
  <div>
    <Card title="人才卡申请记录">
      <div slot="extra">
        <Input search enter-button @on-search="handleSearch" v-model="keywords" placeholder="请输入用户姓名关键字..." />
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
        <Modal ref="verify-modal" v-model="showModal" draggable scrollable>
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>{{editApplyInfo.realname}}人才卡申领审核</span>
      </p>
      <VerifyForm :talent-info="editApplyInfo" @form-saved="handleVerifySave" @form-cancel="handleVerifyCancel"></VerifyForm>
      <p slot="footer"></p>
    </Modal>
  </div>
</template>

<script>
import axios from "@/libs/api.request";
import tableMixin from "@/libs/table-mixin";
import VerifyForm from "./verify-form"
export default {
  name: "",
  mixins: [tableMixin],
  components:{VerifyForm},
  props: {},
  data() {
    return {
      columns: [
        { title: "姓名", key: "realname", width:120 },
        { title: "人才类型", key: "typename", width: 120 },
        { title: "审核状态", key: "verifyname", width: 200 ,render:(h,params)=>{
          // console.log(params)
          return h("span",{class:'s-text-'+params.row.verifyname.style},params.row.verifyname.name)
        }},
        { title: "未通过原因", key: "reason", width: 200 },
        { title: "申请时间", key: "create_time", width: 200 },
        { title: "操作", render:(h,params)=>{
          let operation = [h("Button",{
            props:{
              to:{name:'talent_log_detail',params:{id:params.row.id}}
            }
          },'详情')]
          if(params.row.type != '1' && params.row.verify_status != '6') {
            let verifyBtn = h('Button',{style:{marginLeft:'12px'},on:{'click':()=>{
              this.handleVerify(params.row)
            }}},'审核')
            operation.push(verifyBtn)
          }
          return h("div",operation)
        }}
      ],
      tableDataApi: "Talent/log",
      tableData: [],
      keywords: "",
      pageInfo: { page: 1, pageSize: 10, total: 0 },
      editRowIndex: null,
      showModal: false,
      editApplyInfo:{}
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
    handleAdd() {
      this.$router.push({ name: "event_add" });
    },
    handleEdit(params) {
      const id = params.row.id;
      this.$router.push({ name: "event_edit", params: { id } });
    },
    handleVerify(row){
      this.editApplyInfo = {
        realname: row.realname,
        id:row.id,
        verify_status: row.verify_status
      }
      this.showModal = true
      this.editRowIndex = row._index
    },
    handleVerifySave(newVal){
      this.editApplyInfo = {}
      console.log(newVal)
      this.$set(this.tableData,this.editRowIndex,newVal.data.info)
      this.showModal = false
    },
    handleVerifyCancel(){
      this.editApplyInfo = {}
      this.showModal = false
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