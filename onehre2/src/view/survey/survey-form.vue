<template>
  <div>
      <Form ref="surveyForm" :model="formInfo" :label-width="120" :rules="ruleForm" label-position="right">
        <FormItem label="问卷标题:" prop="title">
            <Input v-model.trim="formInfo.title" placeholder="请输入问卷标题"/>
        </FormItem>

 
        <FormItem label="发布状态">
          <RadioGroup v-model="formInfo.is_released">
            <Radio label="0">未发布</Radio>
            <Radio label="1">已发布</Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="显示状态:">
          <RadioGroup v-model="formInfo.status">
            <Radio label="0">不显示</Radio>
            <Radio label="1">显示</Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="问卷说明:">
            <Editor 
            v-model="formInfo.description" 
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
              <Button type="primary" size="large" @click="handleSubmit('surveyForm')" :loading="submitIng" long>提交</Button>
            </i-col>
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
  name: "surveyForm",
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
        title: [{ required: true, message: "请填写问卷名称" }]
      },
      formInfo: { status: "1", is_released: "0" },
      apiUrl: "Survey/save",
      acType: "add"
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      getDataOne(`Survey/edit/id/${newValue}`).then(res => {
        this.formInfo = res.info;
        this.acType = "edit";
      });
    }
  },
  methods: {
    handleEditorChanged(data) {},
    handleSubmit(name) {
      console.log(this.formInfo)
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
  computed: {
    canEdit() {
      // return this.formInfo.stage > 0;
    }
  },
  mounted() {
    if(this.$route.query.courseid) {
      this.formInfo.type=2
      this.formInfo.course_id=this.$route.query.courseid
    }
    
  }
};
</script>