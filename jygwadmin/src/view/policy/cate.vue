<template>
  <Card>
    <Button type="primary" slot="title" @click.prevent="handleAdd">
      <Icon type="plus-circled" size="18px"></Icon>添加分类
    </Button>
    <Table
      :columns="_customColumns"
      :data="tableData"
      :loading="tableLoading"
    ></Table>
    <Modal v-model="showModal" @on-ok="formSubmit">
      <p slot="header" style="text-align: left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>分类管理</span>
      </p>
      <p slot="footer"></p>
      <Layout>
        <Form
          ref="cateForm"
          :model="cateDetail"
          :rules="formRules"
          :label-width="80"
        >
          <FormItem label="一级类别">
            <Select v-model="cateDetail.parent_name">
              <Option value="金湾区">金湾区</Option>
              <Option value="珠海市">珠海市</Option>
            </Select>
          </FormItem>
          <FormItem label="名称:" prop="name">
            <Input v-model="cateDetail.name" placeholder="请输入分类名称" />
          </FormItem>

          <FormItem label="描述:" prop="description">
            <Input
              v-model="cateDetail.description"
              type="textarea"
              :autosize="{ minRows: 2, maxRows: 5 }"
              placeholder="描述"
            ></Input>
          </FormItem>

          <FormItem label="排序:">
            <InputNumber
              :max="100"
              :min="0"
              v-model="cateDetail.sort"
            ></InputNumber>
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
                <Button long @click="showModal = false">取消</Button>
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
        { title: "分类名称", key: "name", width: 450 },
        { title: "上级类目", key: "parent_name", width: 150 },
        { title: "排序", key: "sort", width: 150 },
        { title: "显示状态", key: "status", width: 100 },
        { title: "操作", key: "handle", button: ["edit", "delete"] },
      ],
      tableDataApi: "PolicyCate/getlist",
      tableData: [],
      showModal: false,
      editRowIndex: null,
      actype: "",
      cateDetail: {},
      formRules: {
        name: [{ required: true, message: "请填写类别名称" }],
      },
    };
  },
  methods: {
    handleAdd() {
      this.cateDetail = { sort: 1, status: "1", pid: 1 };
      this.showModal = true;
      this.acType = "add";
    },
    handleEdit(params) {
      this.editRowIndex = params.index;
      this.cateDetail = params.row;
      this.cateDetail.sort = parseInt(this.cateDetail.sort);
      this.showModal = true;
    },
    handleDelete(params) {
      const id = params.row.id;
      const index = params.index;
      axios
        .request({
          url: "PolicyCate/delone",
          params: { id },
          method: "get",
        })
        .then((res) => {
          this.tableData.splice(index, 1);
        });
    },
    formSubmit() {
      this.$refs["cateForm"].validate((valid) => {
        if (valid) {
          axios
            .request({
              url: "PolicyCate/save",
              data: { ...this.cateDetail },
              method: "post",
            })
            .then((res) => {
              if (this.acType === "add") {
                this.tableData.push(res.data.info);
              } else {
                this.tableData[this.editRowIndex] = res.data.info;
              }
              this.showModal = false;
            });
        }
      });
    },
    _finishedFetchData(res) {
      this.tableData = res.data.list;
    },
  },
  mounted() {
    this._fetchData(this._finishedFetchData);
  },
};
</script>
