<template>
  <Card>
    <Button type="primary" slot="title" @click.prevent="handleAdd">
      <Icon type="plus-circled" size="18px"></Icon>添加类别
    </Button>
    <Table :columns="_customColumns" :data="tableData" :loading="tableLoading"></Table>
    <Modal v-model="showModal" @on-ok="formSubmit">
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>类别管理</span>
      </p>
      <p slot="footer"></p>
      <Layout>
        <Form ref="cateForm" :model="cateDetail" :rules="formRules" :label-width="80">
          <FormItem label="名称:" prop="name">
            <Input v-model="cateDetail.name" placeholder="请输入类别名称" />
          </FormItem>
          <FormItem label="价格:" prop="amount">
            <Input v-model="cateDetail.amount" :number="true" :maxlength="9" placeholder="请输入代理价格" style="width:200px">
            <span slot="append">/年</span>
            </Input>
          </FormItem>
          <FormItem label="描述:" prop="description">
            <Input v-model="cateDetail.description" type="textarea" :rows="4" placeholder="请输入描述" />
          </FormItem>
          <FormItem label="排序:">
            <InputNumber :max="100" :min="0" v-model="cateDetail.sort"></InputNumber>
          </FormItem>
          <FormItem label="显示状态:">
            <RadioGroup v-model="cateDetail.status">
              <Radio label="0">隐藏</Radio>
              <Radio label="1">正常</Radio>
            </RadioGroup>
          </FormItem>
          <FormItem>
            <Row :gutter="16">
              <i-col span="8">
                <Button type="primary" long @click="formSubmit">保存</Button>
              </i-col>
              <i-col span="8">
                <Button long @click="showModal=false">取消</Button>
              </i-col>
            </Row>
          </FormItem>
        </Form>
      </Layout>
    </Modal>
  </Card>
</template>
<script>
import tableMixin from "@/libs/table-mixin";
import axios from "@/libs/api.request";
export default {
  mixins: [tableMixin],
  data() {
    return {
      columns: [
        { title: "类别名称", key: "name", width: 250 },
        { title: "代理价格", key: "amount", width: 250 },
        { title: "排序", key: "sort", width: 150 },
        { title: "状态", key: "status", width: 100 },
        { title: "操作", key: "handle", button: ["edit", "delete"] }
      ],
      tableDataApi: "AgentCate/index",
      tableData: [],
      showModal: false,
      editRowIndex: null,
      actype: "",
      cateDetail: {},
      formRules: {
        name: [{ required: true, message: "请填写级别名称" }],
        amount: [
          { required: true, message: "请填写代理价格" }
          // { type: "number", message: "价格必须是数字",trigger:"blur" }
        ]
      }
    };
  },
  methods: {
    handleAdd() {
      this.cateDetail = { sort: 1, status: "1" };
      this.showModal = true;
      this.acType = "add";
    },
    handleEdit(params) {
      this.acType = "edit";
      this.editRowIndex = params.index;
      this.cateDetail = Object.assign({},params.row);
      this.cateDetail.sort = parseInt(this.cateDetail.sort);
      this.showModal = true;
    },
    handleDelete(params) {
      const id = params.row.id;
      const index = params.index;
      axios
        .request({
          url: "AgentCate/delone",
          params: { id },
          method: "get"
        })
        .then(res => {
          this.tableData.splice(index, 1);
        });
    },
    formSubmit() {
      this.$refs["cateForm"].validate(valid=> {

        if (valid) {
          axios
            .request({
              url: "AgentCate/save",
              data: { ...this.cateDetail },
              method: "post"
            })
            .then(res => {
              if (this.acType === "add") {
                this.tableData.push(res.data.info);
              } else {
                this.$set(this.tableData,this.editRowIndex,res.data.info)
                // this.tableData[this.editRowIndex] = res.data.info;
              }
              this.showModal = false;
            });
        }
      });
    },
    _finishedFetchData(res) {
      this.tableData = res.data.list;
    }
  },
  mounted() {
    this._fetchData(this._finishedFetchData);
  }
};
</script>
