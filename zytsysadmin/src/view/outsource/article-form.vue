<template>
  <div>
      <Form ref="articleForm" :model="formInfo" :label-width="120" :rules="ruleForm" label-position="right">
        <FormItem label="文章标题:" prop="title">
            <Input v-model.trim="formInfo.title" placeholder="请输入文章标题"/>
        </FormItem>


        <FormItem label="文章描述:">
            <Input 
            v-model="formInfo.description" 
            type="textarea" 
            :autosize="{minRows: 2,maxRows: 5}" 
            placeholder="文章描述，120字符以内"
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
        <FormItem label="文章详情:">
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
              <Button type="primary" size="large" @click="handleSubmit('articleForm')" :loading="submitIng" long>提交</Button>
            </i-col>
          </Row>
        </FormItem>
      </Form>
  </div>
</template>

<script>
import Editor from "_c/editor";

import { saveData, getDataOne } from "@/api/data";
import { closeCurPage } from "@/libs/util";
export default {
  name: "articleForm",
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
        title: [{ required: true, message: "请输入文章标题" }]
      },
      formInfo: { status: "1" },
      apiUrl: "Outsource/save",
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      getDataOne(`Outsource/edit/id/${newValue}`).then(res => {
        this.formInfo = res.info;

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

  }
};
</script>