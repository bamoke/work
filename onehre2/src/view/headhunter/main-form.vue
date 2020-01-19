<template>
  <div>
    <Form
      ref="headhunterForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="职位名称:" prop="title">
        <Input v-model.trim="formInfo.title" placeholder="请输入职位名称" />
      </FormItem>
      <FormItem label="招聘企业:" prop="comname">
        <Input v-model.trim="formInfo.comname" placeholder="请输入企业名称" />
      </FormItem>
      <FormItem label="薪资:" prop="wages">
        <Row>
          <i-col span="12">
            <Select v-model="formInfo.wages">
              <Option :value="index" v-for="(wage,index) in wageDataArr" v-bind:key="index">{{wage}}</Option>
            </Select>
          </i-col>
        </Row>
      </FormItem>
      <FormItem label="学历要求:" prop="edu">
        <Row>
          <i-col span="12">
            <Select v-model="formInfo.edu">
              <Option :value="index" v-for="(edu,index) in eduDataArr" v-bind:key="index">{{edu}}</Option>
            </Select>
          </i-col>
        </Row>
      </FormItem>
      <FormItem label="工作经验要求:" prop="experience">
        <Row>
          <i-col span="12">
            <Select v-model="formInfo.experience">
              <Option :value="index" v-for="(exp,index) in expDataArr" v-bind:key="index">{{exp}}</Option>
            </Select>
          </i-col>
        </Row>
      </FormItem>
      <FormItem label="工作城市:" prop="work_addr">
        <Row>
          <i-col span="12">
            <Input v-model.trim="formInfo.work_addr" placeholder="如：珠海、中山" />
          </i-col>
        </Row>
      </FormItem>



      <FormItem label="显示状态:">
        <i-switch
          v-model="formInfo.status"
          size="large"
          true-value="1"
          false-value="0"
          @on-change="handleChangeStatus"
        >
          <span slot="open">显示</span>
          <span slot="close">隐藏</span>
        </i-switch>
      </FormItem>
      <FormItem label="职位详情:">
        <Editor
          v-model="formInfo.content"
          :cache="false"
          :menus="editorMenus"
          @on-change="handleEditorChanged"
        />
      </FormItem>
      <FormItem>
        <Row :gutter="16">
          <i-col span="8">
            <Button @click="handleCancel" size="large" long>取消</Button>
          </i-col>
          <i-col span="8">
            <Button
              type="primary"
              size="large"
              @click="handleSubmit('headhunterForm')"
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
import axios from "@/libs/api.request";
import { closeCurPage } from "@/libs/util";
export default {
  name: "headhunterForm",
  components: { Editor },
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
        "redo"
      ],
      submitIng: false,
      ruleForm: {
        title: [{ required: true, message: "请填写职位名称" }],
        comname: [{ required: true, message: "请填写招聘企业名称" }],
        wages: [{ required: true, message: "请选择薪资" }],
        work_addr: [{ required: true, message: "请填写工作城市" }],
        edu: [{ required: true, message: "请选择学历要求" }],
        experience: [{ required: true, message: "请选择工作经验要求" }]
      },
      formInfo: { status: "1" },
      wageDataArr: [],
      eduDataArr: [],
      expDataArr: [],
      acType: "add",
      stageInfo: []
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      axios
        .request({
          url: `Headhunter/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = res.data.info;
          this.acType = "edit";
        });
    }
  },
  methods: {
    handleChangeStatus() {},
    handleFileChanged(data) {
      this.formInfo.thumb = data;
    },
    handleEditorChanged(data) {},
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios.request({
            url:'Headhunter/save',
            data: this.formInfo,
            method: 'post'
          }).then(res=>{
            this.$Message.success("Success!");
            this.$emit("form-saved", res.info);
            this.submitIng = false;
          })
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
  computed: {
    canEdit() {
      // return this.formInfo.stage > 0;
    }
  },
  mounted() {
    axios
      .request({
        url: "Headhunter/fetch_data_arr",
        method: "get"
      })
      .then(res => {
        this.wageDataArr = res.data.wageArr;
        this.eduDataArr = res.data.eduArr;
        this.expDataArr = res.data.expArr;
      });
  }
};
</script>