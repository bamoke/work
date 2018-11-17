/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-10 20:21:47 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 00:52:45
 */
<template>
  <div>
      <Form ref="courseForm" :model="formInfo" :label-width="120" :rules="ruleForm" label-position="right">
        <FormItem label="课程名称:" prop="title">
            <Input v-model.trim="formInfo.title" placeholder="请输入课程名称"/>
        </FormItem>
        <FormItem label="封面图片:">
          <ImageUpload 
          type="img" 
          dir="thumb" 
          :format="format" 
          :initFileList="fileList" 
          @remove-file="handleRemoveFile"
          @file-changed="handleFileChanged" 
          />
        </FormItem>
        <FormItem label="课程类型:" prop="type">
          <Row>
            <Col span="12">
              <Select v-model="formInfo.type" placeholder="请选择课程类型">
                <Option value="1">公开课</Option>
                <Option value="2">内训</Option>
              </Select>
            </Col>
          </Row>
        </FormItem>
        <FormItem label="讲师:" prop="teacher_id">
          <Row>
            <Col span="12">
              <Select v-model="formInfo.teacher_id" placeholder="请选择讲师" filterable>
                <Option v-bind:value="item.id" v-for="item in teacherList" v-bind:key="item.id">{{item.fullname}}</Option>
              </Select>
            </Col>
          </Row>
        </FormItem>

        <template v-if="formInfo.type == 1">
        <FormItem label="开课时间:" prop="time">
          <Row>
            <Col span="12">
              <Input type="text" v-model="formInfo.time" placeholder="请填写上课时间"/>
            </Col>
          </Row>
        </FormItem>   
        <FormItem label="上课地点:" prop="addr">
          <Row>
            <Col span="12">
              <Input type="text" v-model="formInfo.addr" placeholder="请填写上课地点"/>
            </Col>
          </Row>
        </FormItem>
        <FormItem label="人数限制:" >
          <Row>
            <Col span="12">
              <InputNumber :max="5000" :min="1" :step="1" v-model="formInfo.person_num"></InputNumber>
            </Col>
          </Row>
        </FormItem> 
      </template>
  

        <FormItem label="课程描述:">
            <Input 
            v-model="formInfo.position" 
            type="textarea" 
            :autosize="{minRows: 2,maxRows: 5}" 
            placeholder="课程描述，120字符以内"
            />
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
        <FormItem label="课程详情:">
            <Editor 
            v-model="formInfo.content" 
            :cache="false" 
            :menus="editorMenus" 
            @on-change="handleEditorChanged"
            />
        </FormItem>
        <FormItem>
          <Row :gutter="16">
            <Col span="8">
              <Button @click="handleCancel" size="large" long>取消</Button>
            </Col>
            <Col span="8">
              <Button type="primary" size="large" @click="handleSubmit('courseForm')" :loading="submitIng" long>提交</Button>
            </Col>
          </Row>
        </FormItem>
      </Form>
  </div>
</template>

<script>
import Editor from "_c/editor";
import ImageUpload from "_c/uploads/ali-oss";
import oss from "@/libs/alioss";
import { saveData, getDataOne } from "@/api/data";
import { closeCurPage } from "@/libs/util";
export default {
  name: "courseForm",
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
        title: [{ required: true, message: "请输入课程标题" }],
        type: [{ required: true, message: "请选择课程类型" }]
      },
      formInfo: { status: "1" },
      apiUrl: "Course/save",
      format: ["jpg", "png", "jpeg"],
      fileList: [],
      teacherList: []
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      getDataOne(`Course/edit/id/${newValue}`).then(res => {
        this.formInfo = res.info;
        let imgName = res.info.thumb;
        if (typeof imgName !== "undfined" && imgName !== "") {
          this.fileList = String.prototype.split.call(imgName, ",");
        }
      });
    }
  },
  methods: {
    setFileList() {},
    handleRemoveFile(file) {},
    handleChangeStatus() {},
    handleFileChanged(data) {
      this.formInfo.thumb = data;
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
      closeCurPage(this);
    }
  },
  computed: {},
  mounted() {
    getDataOne("Course/teacher").then(res => {
      this.teacherList = res.info.list;
    });
  }
};
</script>
