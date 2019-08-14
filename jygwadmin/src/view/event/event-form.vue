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
        <Input v-model.trim="formInfo.title" placeholder="请输入活动标题"/>
      </FormItem>

      <FormItem label="封面图片:">
        <ImgUpload
          :upload-url="thumbUploadUrl"
          :delete-url="thumbDeleteUrl"
          :initFileList="thumbList"
          @file-changed="handleFileChanged"
        />
      </FormItem>

      <FormItem label="活动时间:" prop="event_time">
        <Input v-model.trim="formInfo.event_time" placeholder="请输入活动时间"/>
      </FormItem>
      <FormItem label="活动地点:" prop="addr">
        <Input v-model.trim="formInfo.addr" placeholder="请输入活动地点"/>
      </FormItem>
      <FormItem label="报名开始日期:" prop="enroll_start_date">
        <DatePicker
          type="date"
          :value="formInfo.enroll_start_date"
          format="yyyy-MM-dd"
          placeholder="请选择"
          style="width: 200px"
          @on-change="handleStartDateChange"
        ></DatePicker>
      </FormItem>
      <FormItem label="报名截至日期:" prop="enroll_end_date">
        <DatePicker
          :value="formInfo.enroll_end_date"
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
      <FormItem label="活动详情:">
        <Editor
          v-model="formInfo.content"
          :cache="false"
          :menus="editorMenus"
          :upload-url="contentUploadUrl"
          @on-change="handleEditorChange"
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
        addr: [{ required: true, message: "请填写活动地点" }],
        enroll_start_date: [
          {
            required: true,
            type: "string",
            message: "请选择报名开始日期",
            trigger: "change"
          }
        ],
        enroll_end_date: [
          {
            required: true,
            type: "string",
            message: "请选择报名截至日期",
            trigger: "change"
          }
        ]
      },
      formInfo: { status: "1", type: 2 },
      thumbList: [],
      cateList: [],
      thumbUploadUrl: "/Uploads/save/f/thumb",
      thumbDeleteUrl: "/Uploads/delete",
      contentUploadUrl: "/jygw/admin.php/Uploads/save/f/images",
      newContent: ""
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      axios
        .request({
          url: `Event/edit/id/${newValue}`,
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
    handleEndDateChange(e){
      this.formInfo.enroll_end_date = e
    },
    handleStartDateChange(e){
      this.formInfo.enroll_start_date = e
    },
    setFileList() {},
    handleFileChanged(data) {
      this.formInfo.thumb = data;
    },
    handleEditorChange(html, text) {
      this.newContent = html;
    },
    handleSubmit(name) {
      this.formInfo.content = this.newContent;
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Event/save",
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
  mounted() {}
};
</script>
<style>
</style>
