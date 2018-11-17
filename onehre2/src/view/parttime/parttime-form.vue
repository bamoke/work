<template>
  <div>
      <Form ref="articleForm" :model="formInfo" :label-width="120" :rules="ruleForm" label-position="right">
        <FormItem label="项目名称:" prop="title">
            <Input v-model.trim="formInfo.title" placeholder="请输入项目名称"/>
        </FormItem>

        <FormItem label="薪资:" prop="wage">
          <Row>
            <i-col span="12">
              <Input v-model.trim="formInfo.wage" placeholder="数字或‘面议’;如：5000;面议"/>
            </i-col>
          </Row>
        </FormItem>

        <FormItem label="工作地点:" prop="work_addr">
          <Row>
            <i-col span="12">
              <Input v-model.trim="formInfo.work_addr" placeholder="如：珠海、中山"/>
            </i-col>
          </Row>
        </FormItem>

        <FormItem label="工期:" prop="work_day">
          <Row>
            <i-col span="12">
              <Input v-model.trim="formInfo.work_day" placeholder="如：120天；1年；长期；"/>
            </i-col>
          </Row>
        </FormItem>
        <FormItem label="需求人数:" prop="person_num">
          <Row>
            <i-col span="12">
              <Input v-model.trim="formInfo.person_num" placeholder="如：50人；不限；"/>
            </i-col>
          </Row>
        </FormItem>

  

        <FormItem prop="requirement" label="兼职要求:">
            <Input 
            v-model="formInfo.requirement" 
            type="textarea" 
            :autosize="{minRows: 2,maxRows: 5}" 
            placeholder="兼职要求，250字符以内"
            />
        </FormItem>
        <FormItem label="项目状态" v-if="acType == 'edit'">
          <Row>
            <i-col span="12">
              <Select v-model="formInfo.stage">
                <Option v-for="(item , index) in stageInfo" :key="index" :value="index">{{item.name}}</Option>
              </Select>
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
              <span slot="close">禁用</span>
          </i-switch>
        </FormItem>
        <FormItem label="项目详情:">
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
import ImageUpload from "_c/uploads/ali-oss";
import oss from "@/libs/alioss";
import { saveData, getDataOne } from "@/api/data";
import { closeCurPage } from "@/libs/util";
export default {
  name: "articleForm",
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
        title: [{ required: true, message: "请填写项目名称" }],
        wage: [{ required: true, message: "请填写薪资" }],
        work_addr: [{ required: true, message: "请填写工作地点" }],
        work_day: [{ required: true, message: "请填写项目工期" }],
        person_num: [{ required: true, message: "请填写需求人数" }]
      },
      formInfo: { status: "1", stage: 0 },
      apiUrl: "Parttime/save",
      acType: 'add',
      stageInfo:[]
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      getDataOne(`Parttime/edit/id/${newValue}`).then(res => {
        res.info.stage = parseInt(res.info.stage);
        this.formInfo = res.info;
        this.acType = 'edit'
        this.stageInfo = res.stageName
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
  computed: {
    canEdit() {
      // return this.formInfo.stage > 0;
    }
  },
  mounted() {}
};
</script>