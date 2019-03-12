<template>
  <div>
      <Form ref="testForm" :model="formInfo" :label-width="120" :rules="ruleForm" label-position="right">
        <FormItem label="测试试题名称:" prop="title">
            <Input v-model.trim="formInfo.title" placeholder="请输入试题名称"/>
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
        <FormItem label="测试试卷说明:">
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
              <Button type="primary" size="large" @click="handleSubmit('testForm')" :loading="submitIng" long>提交</Button>
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
  name: "testForm",
  components: { Editor },
  props: {
    id: {
      type: Number,
      default: null
    },
    operateType:String,
    default:"0"
  },
  data() {
    return {
      courseId:null,
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
        title: [{ required: true, message: "请填写测试试题名称" }]
      },
      formInfo: { course_id:null,status: "1", is_released: "0" },
      apiUrl: "Tests/save"
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      getDataOne(`Tests/edit/id/${newValue}`).then(res => {
        this.formInfo = res.data.info;
      });
    }
  },
  methods: {
    handleEditorChanged(data) {},
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          saveData(this.apiUrl, this.formInfo).then(res => {
            if(res){
              this.$Message.success("Success!");
              this.$emit("form-saved", res.info);
            }
            this.submitIng = false;
          },reject=>{
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
    if(this.$route.params.courseid) {
     this.formInfo.course_id=this.$route.params.courseid
    }
    
  }
};
</script>