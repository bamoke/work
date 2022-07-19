<template>
  <div>
    <Form
      ref="policyForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <FormItem label="标题:" prop="title">
        <Input v-model.trim="formInfo.title" placeholder="请输入标题" />
      </FormItem>
      <FormItem label="类别:" prop="cate_selected">
        <Row>
          <i-col span="6">
            <Cascader :data="cateList" v-model="formInfo.cate_selected"></Cascader>
          </i-col>
        </Row>
      </FormItem>

      <!--       <FormItem label="文章描述:">
        <Input
          v-model="formInfo.description"
          type="textarea"
          :autosize="{minRows: 2,maxRows: 5}"
          placeholder="文章描述，120字符以内"
        />
      </FormItem>-->

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
      <FormItem label="文件:" prop="file">
        <div v-if="formInfo.file">{{ formInfo.file }}</div>
        <Upload
          :show-upload-list="false"
          type="drag"
          name="file"
          :headers="uploadHeaders"
          :action="uploadUrl"
          :on-success="uploadSuccess"
        >
          <div style="padding: 20px 0">
            <Icon
              type="ios-cloud-upload"
              size="52"
              style="color: #3399ff"
            ></Icon>
            <p>选择或拖拽上传文件</p>
          </div>
        </Upload>
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
              @click="handleSubmit('policyForm')"
              :loading="submitIng"
              long
              >提交</Button
            >
          </i-col>
        </Row>
      </FormItem>
    </Form>
  </div>
</template>

<script>
import Cookies from 'js-cookie'
import { TOKEN_KEY } from '@/libs/util'
import Editor from '_c/editor'
import ImgUpload from '_c/img-upload'
import axios from '@/libs/api.request'
import config from '@/config'
export default {
  name: 'policyForm',
  components: { Editor, ImgUpload },
  props: {
    id: {
      type: Number,
      default: null
    }
  },
  data () {
    return {
      editorMenus: [
        'head',
        'bold',
        'italic',
        'underline',
        'justify',
        'list',
        'undo',
        'redo',
        'image'
      ],
      submitIng: false,
      ruleForm: {
        title: [{ required: true, message: '请输入文章标题' }],
        cate_selected: [{ required: true, message: '请选择文章类别' }],
        file: [{ required: true, message: '请上传文件' }],
        web_url: [
          {
            type: 'url',
            message: '地址必须是合法的url格式,http://或https://开头'
          }
        ]
      },
      formInfo: {
        title: '',
        cate_selected: [],
        status: '1',
        file: ''
      },
      thumbList: [],
      cateList: [],
      uploadHeaders: {},
      uploadUrl: `${config.uploadBaseUrl}/jygw/admin.php/Uploads/save_file/f/policy`,
      initContent: '',
      initEncontent: ''
    }
  },
  watch: {
    id: function (newValue) {
      if (!newValue) {
        return
      }
      axios
        .request({
          url: `Policy/edit/id/${newValue}`,
          method: 'get'
        })
        .then((res) => {
          this.formInfo = res.data.info
          this.initEncontent = res.data.info.en_content || ''
          this.initContent = res.data.info.content || ''
          this.thumbList = res.data.thumbList
        })
    }
  },
  methods: {
    uploadSuccess (response, file, fileList) {
      if (response.code != 200) {
        this.$Message.error('上传错误')
      } else {
        this.formInfo.file = response.filename
        this.$Message.success('上传成功')
      }
    },
    setFileList () {},
    handleChangeStatus () {},
    handleFileChanged (data) {
      this.formInfo.thumb = data
    },
    handleSubmit (name) {
      this.formInfo.cate_id = this.curCate
      this.submitIng = true
      this.$refs[name].validate((valid) => {
        if (valid) {
          axios
            .request({
              url: 'Policy/save',
              data: { ...this.formInfo },
              method: 'post'
            })
            .then((res) => {
              this.$Message.success('Success!')
              this.$emit('form-saved', res)
              this.submitIng = false
            })
        } else {
          // this.$Message.error("Error!");
          this.submitIng = false
        }
      })
    },
    handleCancel () {
      closeCurPage(this)
    }
  },
  computed: {},
  mounted () {
    axios
      .request({
        url: 'Policy/catelist',
        method: 'get'
      })
      .then((res) => {
        this.cateList = res.data.list
      })
    this.uploadHeaders = {
      'x-access-token': Cookies.get(TOKEN_KEY)
    }
  }
}
</script>
<style>
</style>
