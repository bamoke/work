<template>
  <div>
    <Form
      ref="productForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="产品名称:" prop="title">
        <Input v-model.trim="formInfo.title" placeholder="请输入产品名称" />
      </FormItem>

      <FormItem label="产品价格:" prop="price">
        <InputNumber v-model.trim="formInfo.price" :max="99999" :min="0"></InputNumber>
      </FormItem>
      <FormItem label="产品描述:" prop="description">
        <Input v-model.trim="formInfo.description" type="textarea" :rows="4" placeholder="产品描述" />
      </FormItem>

      <FormItem label="模块配置:">
        <Tree :data="treeData" show-checkbox @on-check-change="handleGetModuleChecked"></Tree>
      </FormItem>
      <FormItem label="账号数:" prop="account_num">
        <InputNumber :max="999" :min="1" v-model="formInfo.account_num"></InputNumber>
      </FormItem>

      <FormItem label="排序:">
        <InputNumber :max="999" :min="1" v-model="formInfo.sort"></InputNumber>
      </FormItem>
      <FormItem label="显示状态:">
        <i-switch v-model="formInfo.status" size="large" true-value="1" false-value="0">
          <span slot="open">启用</span>
          <span slot="close">禁用</span>
        </i-switch>
      </FormItem>
      <FormItem label="产品介绍详情:">
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
              @click="handleSubmit('productForm')"
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
export default {
  name: "eventForm",
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
        "redo",
        "image"
      ],
      submitIng: false,
      ruleForm: {
        title: [{ required: true, message: "请输入活动标题" }],
        price: [
          { required: true, message: "请填写价格" },
          { type: "number", message: "必须为数字" }
        ]
      },
      formInfo: { status: "1" },

      contentUploadUrl:
        "http://localhost:802/lansiyun/backend/platform.php/Uploads/save/f/images",
      newContent: "",
      treeData: []
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      axios
        .request({
          url: `Product/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = res.data.info;
          let curModule = res.data.info.module.split(",");
          let newTreeData = this.treeData.slice(0)
          this.treeData.forEach(item => {
            if (item.children.length > 0) {
              item.children.forEach(child => {
                if (curModule.indexOf(child.id) >= 0) {
                  child.checked = true;
                }
              });
              
            }
            if (curModule.indexOf(item.id) >= 0) {
              item.checked = true;
            }
          });
          this.treeData = newTreeData
        });
    }
  },
  methods: {
    // 选中模块
    handleGetModuleChecked(e) {
      var idArr = e.map(element => {
        return element.id;
      });
      this.formInfo.module = idArr.join(",");
    },
    handleEditorChange(html, text) {
      this.newContent = html;
    },
    handleSubmit(name) {
      if (this.newContent) {
        this.formInfo.content = this.newContent;
      }
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Product/save",
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
  mounted() {
    axios
      .request({
        url: "Mokuai/vlist",
        mothod: "get"
      })
      .then(res => {
        this.treeData = res.data.list;
      });
  }
};
</script>
<style>
</style>
