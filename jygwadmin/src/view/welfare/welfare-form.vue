<template>
  <div>
    <Form
      ref="welfareForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="商家名称:" prop="title">
        <Input v-model.trim="formInfo.title" style="width:300px;" placeholder="请输入商家名称" />
      </FormItem>

      <FormItem label="商家缩略图片:">
        <ImgUpload
          :upload-url="thumbUploadUrl"
          :delete-url="thumbDeleteUrl"
          :initFileList="thumbList"
          @file-changed="handleFileChanged"
        />
      </FormItem>

      <FormItem label="商家地址:" prop="addr">
        <Input v-model.trim="formInfo.addr" placeholder="请输入商家地址" />
      </FormItem>
      <FormItem label="地图坐标:">
        <Row>
          <Col span="6">
            <FormItem prop="latitude">
              <Input v-model.trim="formInfo.latitude" style="width:200px" placeholder="纬度" />
            </FormItem>
          </Col>
          <Col span="1">&nbsp;</Col>
          <Col span="6">
            <FormItem prop="longitude">
              <Input v-model.trim="formInfo.longitude" style="width:200px" placeholder="经度" />
            </FormItem>
          </Col>
        </Row>
      </FormItem>
      <FormItem label="联系电话:" prop="phone">
        <Input v-model.trim="formInfo.phone" style="width:200px" placeholder="请输入商家联系电话" />
      </FormItem>
      <FormItem label="特色标签:" prop="tags">
        <Input v-model.trim="formInfo.tags" placeholder="多个标签用;号隔开" />
      </FormItem>
      <FormItem label="营业时间:" prop="daily_hours">
        <Input v-model.trim="formInfo.daily_hours" placeholder="请输入商家营业时间段" />
      </FormItem>
      <FormItem label="福利详情:" prop="description">
        <Input v-model.trim="formInfo.description" type="textarea" placeholder="请输入福利优惠说明" />
      </FormItem>
      <FormItem label="开始日期:" prop="start_date">
        <DatePicker
          type="date"
          v-model="formInfo.start_date"
          format="yyyy-MM-dd"
          placeholder="请选择"
          style="width: 200px"
          @on-change="handleStartDateChange"
        ></DatePicker>
      </FormItem>
      <FormItem label="截至日期:" prop="end_date">
        <DatePicker
          v-model="formInfo.end_date"
          type="date"
          format="yyyy-MM-dd"
          placeholder="请选择"
          style="width: 200px"
          @on-change="handleEndDateChange"
        ></DatePicker>
      </FormItem>
      <FormItem label="显示状态:">
        <i-switch v-model="formInfo.status" size="large" true-value="1" false-value="0">
          <span slot="open">启用</span>
          <span slot="close">禁用</span>
        </i-switch>
      </FormItem>
      <FormItem label="商家简介:">
        <Editor
          v-model="formInfo.content"
          :cache="false"
          :menus="editorMenus"
          :upload-url="contentUploadUrl"
          :init-content="initContent"
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
              @click="handleSubmit('welfareForm')"
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
import * as util from "@/libs/util";
export default {
  name: "welfareForm",
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
        title: [{ required: true, message: "请输入商家名称" }],
        addr: [{ required: true, message: "请填写商家地址" }],
        phone: [{ required: true, message: "请填写联系电话" }],
        latitude: [{ required: true, message: "请输入坐标纬度值" }],
        longitude: [{ required: true, message: "请输入坐标经度值" }],
        daily_hours: [{ required: true, message: "请填写商家营业时间段" }],
        description: [{ required: true, message: "请填写福利说明" }],
        start_date: [
          {
            required: true,
            message: "请选择福利优惠开始日期"
          }
        ],
        end_date: [
          {
            required: true,
            message: "请选择福利优惠截至日期"
          }
        ]
      },
      formInfo: { status: "1", end_date: "", start_date: "" },
      thumbList: [],
      cateList: [],
      thumbUploadUrl: "/Uploads/save/f/thumb",
      thumbDeleteUrl: "/Uploads/delete",
      contentUploadUrl: "/jygw/admin.php/Uploads/save/f/images",
      initContent: ""
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      axios
        .request({
          url: `Welfare/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = res.data.info;
          this.thumbList = res.data.thumbList;
          this.initContent = res.data.info.content;
        });
    }
  },
  methods: {

    handleEndDateChange(e) {
      //   this.formInfo.end_date = e
    },
    handleStartDateChange(e) {
      //   this.formInfo.start_date = e
      console.log(this.formInfo);
    },
    setFileList() {},
    handleFileChanged(data) {
      this.formInfo.thumb = data;
    },

    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Welfare/save",
              data: { ...this.formInfo },
              method: "post"
            })
            .then(
              res => {
                this.$Message.success("Success!");
                this.$emit("form-saved", res);
                this.submitIng = false;
              },
              reject => {
                this.$Message.error("系统错误");
                this.submitIng = false;
              }
            );
        } else {
          this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      // closeCurPage(this)
      // util.getNextRoute(list,toute)
      this.$store.commit("closeTag", this.$route);
    }
  },
  computed: {},
  mounted() {}
};
</script>
<style>
</style>
