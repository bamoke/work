<template>
  <Form :model="formItem" ref="memberForm" :rules="ruleValidate" :label-width="80">
    <FormItem label="姓名" prop="realname">
      <Input v-model="formItem.realname" placeholder="请输入真实姓名..."></Input>
    </FormItem>
    <FormItem label="登录账号" prop="username">
      <Input v-model="formItem.username" placeholder="6-12字符之间..."></Input>
    </FormItem>
    <FormItem label="手机号" prop="phone">
      <Input v-model="formItem.phone" placeholder="请输入手机号..."></Input>
    </FormItem>
    <FormItem label="初始密码" prop="password">
      <Input v-model="formItem.password" placeholder="6-12个字符"></Input>
    </FormItem>
    <FormItem label="所属部门">
      <Select v-model="formItem.department">
        <template v-for="item of departmentList">
          <OptionGroup :label="item.name" v-if="item.child.length" :key="item.id">
            <Option v-for="child in item.child" :value="child.id" :key="child.id">{{ child.name }}</Option>
          </OptionGroup>
          <Option :value="item.id" :key="item.id" v-else>{{ item.name }}</Option>
        </template>
      </Select>
    </FormItem>
    <FormItem label="员工编号">
      <Input v-model="formItem.work_no" placeholder></Input>
    </FormItem>

    <FormItem>
      <Row>
        <Col span="14">
          <Button type="primary" @click="handleSave('memberForm')" :loading="onSubmitIng" long>提交</Button>
        </Col>
        <Col span="2">&nbsp;</Col>
        <Col span="8">
          <Button long @click="handleCancelAdd">取消</Button>
        </Col>
      </Row>
    </FormItem>
  </Form>
</template>
<script>
import axios from '@/libs/api.request'
export default {
  props: {
    id: {
      type: Number,
      default: null
    },
    departmentList: {
      type: Array,
      default: function () {
        return []
      }
    }
  },
  data () {
    return {
      onSubmitIng: false,
      formItem: {
        realname: '',
        username: '',
        phone: '',
        password: '',
        department: '',
        work_no: ''
      },
      ruleValidate: {
        realname: [
          { required: true, message: '请输入用户姓名', trigger: 'blur' },
          {
            type: 'string',
            max: 10,
            message: '请输入真实姓名',
            trigger: 'blur'
          }
        ],
        username: [
          {
            required: true,
            message: '登录名长度必须为6-12位',
            trigger: 'blur'
          },
          {
            type: 'string',
            min: 6,
            max: 12,
            message: '登录名长度必须为6-12位',
            trigger: 'blur'
          }
        ],
        password: [
          { required: true, message: '密码长度必须为6-12位', trigger: 'blur' },
          {
            type: 'string',
            min: 6,
            max: 12,
            message: '密码长度必须为6-12位',
            trigger: 'blur'
          }
        ],
        phone: [
          {
            required: true,
            message: '手机号不能为空',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  methods: {
    handleCancelAdd () {
      this.$emit('on-cancel')
    },
    handleSave (name) {
      this.$refs[name].validate(valid => {
        if (valid) {
          // this.$Message.success('Success!')
          this.onSubmitIng = true
          axios
            .request({
              url: 'Members/do_add',
              data: { ...this.formItem },
              method: 'post'
            })
            .then(res => {
              this.$Message.success('Success!')
              this.$emit('on-success', res.data.info)
              this.onSubmitIng = false
              this.$refs[name].resetFields()
            }, reject => {
              this.onSubmitIng = false
            })
        } else {
          // this.$Message.error('Fail!')
        }
      })
    }
  }
}
</script>
