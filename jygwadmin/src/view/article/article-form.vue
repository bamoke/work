<template>
  <div>
    <Form
      ref="articleForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="文章标题:" prop="title">
        <Input v-model.trim="formInfo.title" placeholder="请输入文章标题" />
      </FormItem>
      <FormItem label="类别:" prop="cate_id">
        <Row>
          <i-col span="12">
            <Select v-model="formInfo.cate_id" placeholder="请选择类别">
              <Option
                v-bind:value="item.id"
                v-for="item in cateList"
                v-bind:key="item.id"
              >{{item.name}}</Option>
            </Select>
          </i-col>
        </Row>
      </FormItem>
      <FormItem label="外部链接:" prop="web_url">
        <Input v-model.trim="formInfo.web_url" placeholder="对应公众号文章地址" />
      </FormItem>
      <FormItem label="封面图片:">
        <ImgUpload
          :upload-url="thumbUploadUrl"
          :delete-url="thumbDeleteUrl"
          :initFileList="thumbList"
          @file-changed="handleFileChanged"
        />
      </FormItem>
      <FormItem label="将封面图片显示在详细页中:">
        <RadioGroup v-model="formInfo.thumb_show_in_content">
          <Radio label="2">
            <span>是</span>
          </Radio>
          <Radio label="0">
            <span>否</span>
          </Radio>
        </RadioGroup>
      </FormItem>
      <FormItem label="来源:">
        <Row>
          <i-col span="12">
            <Input v-model.trim="formInfo.origin" :maxlength="12" placeholder="尽量简写（12个字符以内）" />
          </i-col>
        </Row>
      </FormItem>
      <FormItem label="显示英文版:">
        <RadioGroup v-model="formInfo.is_en">
          <Radio label="1">
            <span>是</span>
          </Radio>
          <Radio label="0">
            <span>否</span>
          </Radio>
        </RadioGroup>
      </FormItem>
      <template v-if="formInfo.is_en==1">
        <FormItem label="英文标题:" prop="en_title">
          <Input v-model.trim="formInfo.en_title" placeholder="请输入英文标题" />
        </FormItem>
        <FormItem label="英文内容详情:">
          <Editor
            v-model="formInfo.en_content"
            :cache="false"
            :menus="editorMenus"
            :upload-url="uploadUrl"
            :init-content="initEncontent"
          />
        </FormItem>
      </template>

      <!--       <FormItem label="文章描述:">
        <Input
          v-model="formInfo.description"
          type="textarea"
          :autosize="{minRows: 2,maxRows: 5}"
          placeholder="文章描述，120字符以内"
        />
      </FormItem>-->

      <FormItem label="是否推荐:">
        <RadioGroup v-model="formInfo.recommend">
          <Radio label="1">
            <span>是</span>
          </Radio>
          <Radio label="0">
            <span>否</span>
          </Radio>
        </RadioGroup>
      </FormItem>

      <FormItem label="显示状态:">
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
          :upload-url="uploadUrl"
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
              @click="handleSubmit('articleForm')"
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
  name: "articleForm",
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
        title: [{ required: true, message: "请输入文章标题" }],
        cate_id: [{ required: true, message: "请选择文章类别" }],
        web_url:[{type:"url",message: "地址必须是合法的url格式,http://或https://开头"}]
      },
      formInfo: { status: "1", is_en:"0", recommend: "0", thumb_show_in_content: "2" },
      thumbList: [],
      cateList: [],
      thumbUploadUrl: "/Uploads/save/f/thumb",
      thumbDeleteUrl: "/Uploads/delete",
      uploadUrl: "/jygw/admin.php/Uploads/save/f/images",
      initContent:"",
      initEncontent:""
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      axios
        .request({
          url: `Article/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = res.data.info;
          this.initEncontent = res.data.info.en_content || ''
          this.initContent = res.data.info.content || ''
          this.thumbList = res.data.thumbList
        });
    }
  },
  methods: {

    setFileList() {},
    handleChangeStatus() {},
    handleFileChanged(data) {
      this.formInfo.thumb = data;
    },
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Article/save",
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
        url: "Article/catelist",
        method: "get"
      })
      .then(res => {
        this.cateList = res.data.list;
      });
  }
};
</script>
<style>
</style>
