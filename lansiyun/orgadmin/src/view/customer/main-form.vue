<template>
  <div>
    <Form
      ref="customerForm"
      :model="formInfo"
      :label-width="120"
      :rules="ruleForm"
      label-position="right"
    >
      <div class="bar">
        <span class="caption">基本信息</span>
      </div>
      <FormItem label="客户名称:" prop="title">
        <Row>
          <Col span="14">
            <Input v-model.trim="formInfo.title" placeholder="请输入单位名称" />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="所在地区:">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.province" placeholder="省市自治区" />
          </Col>
          <Col span="2" style="text-align:center;">-</Col>
          <Col span="6">
            <Input v-model="formInfo.city" placeholder="市、区" />
          </Col>
        </Row>
      </FormItem>

      <div class="bar">
        <span class="caption">联系信息</span>
      </div>
      <FormItem label="联系人:" prop="contact">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.contact" placeholder />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="电话:" prop="phone">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.phone" placeholder="如:0756-8888999" />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="QQ:" prop="qq">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.qq" />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="微信:" prop="wechat">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.wechat" />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="邮箱:" prop="email">
        <Row>
          <Col span="6">
            <Input v-model="formInfo.email" placeholder />
          </Col>
        </Row>
      </FormItem>
      <FormItem label="详细地址:" prop="addr">
        <Row>
          <Col span="14">
            <Input v-model="formInfo.addr" placeholder />
          </Col>
        </Row>
      </FormItem>
      <FormItem>
        <Row :gutter="16">
          <i-col span="7">
            <Button @click="handleCancel" size="large" long>取消</Button>
          </i-col>
          <i-col span="7">
            <Button
              type="primary"
              size="large"
              @click="handleSubmit('customerForm')"
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
import axios from '@/libs/api.request'
export default {
  name: 'customerForm',
  props: {
    id: {
      type: Number,
      default: null
    }
  },
  data () {
    return {

      submitIng: false,
      ruleForm: {
        title: [{ required: true, message: '请输入企业名称' }],
        contact: [{ required: true, message: '请填写联系人' }],
        phone: [{ required: true, message: '请填写联系电话' }],
        addr: [{ required: true, message: '请填写联系地址' }]
      },
      formInfo: {}
    }
  },
  watch: {
    id: function (newValue) {
      if (!newValue) {
        return
      }
      axios
        .request({
          url: `Customer/edit/id/${newValue}`,
          method: 'get'
        })
        .then(res => {
          this.formInfo = res.data.info
        })
    }
  },
  methods: {
    // 检测截至日期是否合法
    valideEndDate (e) {},
    handleSubmit (name) {
      this.submitIng = true
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: 'Customer/save',
              data: { ...this.formInfo },
              method: 'post'
            })
            .then(res => {
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

  }
}
</script>
<style>
</style>
