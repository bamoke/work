/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-13 23:35:44 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-03-07 01:38:49
 */
<template>
  <div>
      <Form ref="teacherForm" :model="formInfo" :label-width="120" :rules="ruleForm" label-position="right">
        <FormItem label="姓名:" prop="fullname">
            <Input v-model.trim="formInfo.fullname" placeholder="请输入讲师姓名"/>
        </FormItem>
        <FormItem label="上传头像:">
          <ImageUpload 
          type="img" 
          dir="avatar" 
          :format="format" 
          :initFileList="fileList" 
          @remove-file="handleRemoveFile"
          @file-changed="handleFileChanged" 
          />
        </FormItem>
        <FormItem label="职称/头衔:">
            <Input 
            v-model="formInfo.position" 
            type="textarea" 
            :autosize="{minRows: 2,maxRows: 5}" 
            placeholder="讲师职称或头衔"
            />
        </FormItem>
        <FormItem label="备注:">
          <Input type="textarea" :autosize="{minRows: 2,maxRows: 5}" v-model="formInfo.remarks" placeholder="备注关键词,方便后续添加课程时的讲师查询;200字符以内" />
        </FormItem>
        <FormItem label="状态:">
          <i-switch 
          v-model="formInfo.status" 
          size="large" 
          true-value="1" 
          false-value="0" 
          @on-change="handleChangeStatus"
          >
              <span slot="open">启用</span>
              <span slot="close">禁用</span>
          </i-switch>
        </FormItem>
        <FormItem label="简介:">
            <Editor 
            v-model="formInfo.introduce" 
            :cache="false" 
            :menus="editorMenus" 
            @on-change="handleEditorChanged"
            />
        </FormItem>
        <FormItem>
            <Button type="primary" size="large" @click="handleSubmit('teacherForm')" :loading="submitIng" style="width:40%">提交</Button>
            <Button @click="handleCancel" size="large" style="width:40%;margin-left: 8px">取消</Button>
        </FormItem>
      </Form>
  </div>
</template>

<script>
import Editor from "_c/editor";
import ImageUpload from "_c/uploads/ali-oss";
import oss from '@/libs/alioss'
import { saveData, getDataOne } from "@/api/data";
import { closeCurPage } from '@/libs/util'
export default {
  name: "teacherForm",
  components: { Editor, ImageUpload },
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
        fullname: [{ required: true, message: "请输入讲师姓名" }]
      },
      formInfo: {},
      apiUrl: "Teacher/save",
      maxSize: 2,
      format: ["jpg", "png", "jpeg"],
      fileList: []
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      getDataOne(`Teacher/getone/id/${newValue}`).then(res => {
        this.formInfo = res.info;
        let avatarName = res.info.avatar;
        if (typeof avatarName !== "undfined" && avatarName !== "") {
          this.fileList = String.prototype.split.call(avatarName, ",");
        }
      });
    }
  },
  methods: {
    setFileList() {},
    handleRemoveFile(file){

    },
    handleChangeStatus() {},
    handleFileChanged(data) {
      this.formInfo.avatar = data;
    },
    handleEditorChanged(data) {},
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          saveData(this.apiUrl, this.formInfo).then(res => {
            this.$Message.success("Success!");
            this.$emit("form-saved", res.info);
            this.submitIng = false;
          });
        } else {
          // this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      closeCurPage(this)
    }
  },
  computed: {},
  mounted() {}
};
</script>

