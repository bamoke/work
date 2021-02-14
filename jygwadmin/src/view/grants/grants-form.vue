<template>
  <div>
    <Form
      ref="eventForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="活动标题:" prop="title">
        <Input v-model.trim="formInfo.title" placeholder="请输入活动标题" />
      </FormItem>

      <FormItem label="封面图片:">
        <Row>
          <i-col span="8">
            <ImgUpload
              :upload-url="thumbUploadUrl"
              :delete-url="thumbDeleteUrl"
              :initFileList="thumbList"
              @file-changed="handleFileChanged"
            />
          </i-col>
          <i-col span="8">图片尺寸建议:1080px*480px</i-col>
        </Row>
      </FormItem>

      <FormItem label="项目描述:" prop="description">
        <Input v-model.trim="formInfo.description" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="请输入项目描述" />
      </FormItem>

      <FormItem label="截至日期:" prop="end_date">
        <DatePicker
          :value="formInfo.end_date"
          type="date"
          format="yyyy-MM-dd"
          placeholder="请选择"
          style="width: 200px"
          @on-change="handleEndDateChange"
        ></DatePicker>
      </FormItem>
      <FormItem label="项目进展:">
        <Select v-model="formInfo.stage" style="width:200px">
          <Option value="0">项目中止</Option>
          <Option value="1">项目进行中</Option>
          <Option value="2">项目已完成</Option>
        </Select>
      </FormItem>
      <FormItem label="显示状态:">
        <i-switch v-model="formInfo.status" size="large" true-value="1" false-value="0">
          <span slot="open">启用</span>
          <span slot="close">禁用</span>
        </i-switch>
      </FormItem>
      <FormItem label="活动详情:">
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
              @click="handleSubmit('eventForm')"
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
  name: "eventForm",
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
        title: [{ required: true, message: "请输入活动标题" }],
        event_time: [{ required: true, message: "请填写活动时间" }],
        description: [{ required: true, message: "请填写项目描述120字符内" }]
      },
      formInfo: { status: "1", stage:"1",end_date: "" },
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
          url: `Grants/edit/id/${newValue}`,
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
      this.formInfo.end_date = e;
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
              url: "Grants/save",
              data: { ...this.formInfo },
              method: "post"
            })
            .then(res => {
              this.$Message.success("Success!");
              this.$emit("form-saved", res);
              this.submitIng = false;
            },reject=>{
              this.$Message.success(reject.toSting());
              this.submitIng = false;
              console.log(reject)
            });
        } else {
          // this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      this.$store.commit("closeTag", this.$route);
    }
  },
  computed: {},
  mounted() {}
};
</script>
<style>
</style>
