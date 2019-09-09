<template>
  <div>
    <Form
      ref="articleForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <div class="bar">
        <span class="caption">基本信息</span>
      </div>
      <FormItem label="单位名称:" prop="name">
        <Row>
          <Col span="14">
            <Input v-model.trim="formInfo.name" placeholder="请输入单位名称" />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="所在地区:">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.province" placeholder="省市自治区" />
          </Col>
          <Col span="2" style="text-align:center;">-</Col>
          <Col span="6">
            <Input v-model="formInfo.city" placeholder="市、区" />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="代理区域:" prop="agent_area">
        <Row>
          <Col span="6">
            <Select v-model="formInfo.agent_area">
              <Option value="广州">广州</Option>
              <Option value="深圳">深圳</Option>
              <Option value="中山">中山</Option>
              <Option value="珠海">珠海</Option>
            </Select>
          </Col>
        </Row>
      </FormItem>
      <FormItem label="代理级别:" prop="level">
        <Row>
          <Col span="6">
            <Select v-model="formInfo.level" placeholder="请选择类别">
              <Option
                v-bind:value="item.id"
                v-for="item in cateList"
                v-bind:key="item.id"
              >{{item.name}}</Option>
            </Select>
          </Col>
        </Row>
      </FormItem>

      <div class="bar">
        <span class="caption">业务信息</span>
      </div>

      <FormItem label="合同编号" prop="contract_no">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.contract_no" placeholder="请输入合同编号" />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="业务开始日期" prop="contract_start">
        <Row>
          <Col span="6">
            <DatePicker
              type="date"
              v-model="formInfo.contract_start"
              :start-date="new Date()"
              format="yyyy-MM-dd"
            ></DatePicker>
          </Col>
        </Row>
      </FormItem>
      <FormItem label="业务到期日期" prop="contract_end">
        <Row>
          <Col span="6">
            <DatePicker
              type="date"
              v-model="formInfo.contract_end"
              :start-date="new Date()"
              format="yyyy-MM-dd"
              @on-change="valideEndDate"
            ></DatePicker>
          </Col>
        </Row>
      </FormItem>
      <div class="bar">
        <span class="caption">联系信息</span>
      </div>
      <FormItem label="联系人:" prop="contact_person">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.contact_person" placeholder />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="电话:" prop="contact_phone">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.contact_phone" placeholder="如:0756-8888999" />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="传真:" prop="contact_fax">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.contact_fax" placeholder="如:07568888999" />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="邮箱:" prop="contact_email">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.contact_email" placeholder />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="地址:" prop="contact_addr">
        <Row>
          <Col span="14">
            <Input v-model="formInfo.contact_addr" placeholder />
          </Col>
        </Row>
      </FormItem>
      <FormItem>
        <Row :gutter="16">
          <i-col span="7">
            <Button @click="handleCancel" size="large" long>取消</Button>
          </i-col>
          <i-col span="7">
            <Button
              type="primary"
              size="large"
              @click="handleSubmit('articleForm')"
              :loading="submitIng"
              long
            >提交</Button>
          </i-col>
        </Row>
      </FormItem>
    </Form>
  </div>
</template>

<script>
import Editor from "_c/editor";
import ImgUpload from "_c/img-upload";
import axios from "@/libs/api.request";
export default {
  name: "articleForm",
  components: { Editor, ImgUpload },
  props: {
    id: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
      editorMenus: [
        "head",
        "bold",
        "italic",
        "underline",
        "justify",
        "list",
        "undo",
        "redo",
        "image"
      ],
      submitIng: false,
      ruleForm: {
        name: [{ required: true, message: "请输入代理商名称" }],
        agent_area: [{ required: true, message: "请选择代理区域" }],
        level: [{ required: true, message: "请选择代理级别" }],
        contract_no: [{ required: true, message: "请输入合同编号" }],
        contract_start: [{ required: true, message: "请选择业务开始日期" }],
        contract_end: [{ required: true, message: "请选择业务截至日期" }],
        contact_person: [{ required: true, message: "请填写联系人" }],
        contact_phone: [{ required: true, message: "请填写联系电话" }],
        contact_addr: [{ required: true, message: "请填写联系地址" }]
      },
      formInfo: {  },
      cateList: []
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      axios
        .request({
          url: `Agent/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = res.data.info;
          this.thumbList = res.data.thumbList;
          this.newContent = res.data.info.content;
        });
    }
  },
  methods: {
    // 检测截至日期是否合法
    valideEndDate(e){
    },
    handleSubmit(name) {
      this.formInfo.content = this.newContent;
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Agent/save",
              data: { ...this.formInfo },
              method: "post"
            })
            .then(res => {
              this.$Message.success("Success!");
              this.$emit("form-saved", res);
              this.submitIng = false;
            });
        } else {
          // this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      closeCurPage(this);
    }
  },
  computed: {},
  mounted() {
    axios
      .request({
        url: "Agent/catelist",
        method: "get"
      })
      .then(res => {
        this.cateList = res.data.list;
      });
  }
};
</script>
<style>
</style>
