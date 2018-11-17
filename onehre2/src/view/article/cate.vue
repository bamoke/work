<template>
  <Card>
    <Button type="primary" slot="title" @click.prevent="handleAdd">
      <Icon type="plus-circled" size="18px"></Icon>
      添加分类
    </Button>
    <Table :columns="_customColumns" :data="tableData" :loading="formLoading"></Table>
     <Modal
        v-model="showModal"
        @on-ok="formSubmit">
        <p slot="header" style="text-align:left">
            <Icon type="ios-compose" size="18"></Icon>
            <span>分类管理</span>
        </p>
        <p slot="footer"></p>
        <Layout>
          <Form ref="cateForm" :model="cateDetail" :rules="formRules" :label-width="80">
            <FormItem label="名称:" prop="name">
              <Input v-model="cateDetail.name" placeholder="请输入分类名称"/>
            </FormItem>
            <FormItem label="排序:">
              <InputNumber :max="100" :min="1" v-model="cateDetail.sort"></InputNumber>
            </FormItem>
            <FormItem label="状态:">
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
import tableMixin from "@/libs/table-mixin"
import { saveData, deleteDataOne } from "@/api/data";
export default {
  mixins: [tableMixin],
  data() {
    return {
      columns: [
        { title: "分类名称", key: "name", width: 450 },
        { title: "排序", key: "sort", width: 150 },
        { title: "状态", key: "status", width: 100 },
        { title: "操作", key: "handle", button: ["edit", "delete"] }
      ],
      tableDataApi: "ArticleCate/index",
      formLoading: false,
      tableData: [],
      showModal: false,
      editRowIndex: null,
      actype:'',
      cateDetail: {},
      formRules: {
        name: [{ required: true, message: "请填写类别名称" }]
      }
    };
  },
  methods: {
    handleAdd() {
      this.cateDetail = {sort: 1, status: "1"}
      this.showModal = true
      this.acType = 'add'
    },
    handleEdit(params){
      this.editRowIndex = params.index
      this.cateDetail = params.row
      this.cateDetail.sort = parseInt(this.cateDetail.sort)
      this.showModal = true
    },
    handleDelete(params){
      const id = params.row.id
      const index = params.index
      deleteDataOne('ArticleCate/delone',id).then(res=>{
        if(res){
          this.tableData.splice(index,1)
        }
      })
    },
    formSubmit() {
      this.$refs["cateForm"].validate(valid => {
        if (valid) {
          saveData('ArticleCate/save',this.cateDetail).then(res=>{
            if(res){
              if (this.acType === 'add'){
                this.tableData.push(res.info)
              }else {
                this.tableData[this.editRowIndex] = res.info
              }
              this.showModal = false
            }
          })
        }
      })
    },
    _finishedFetchData(res) {
      this.tableData = res.info.list;
    }
  },
  mounted() {
    this._fetchData(this._finishedFetchData);
  }
};
</script>
