<template>
  <div>
    <Tabs :value="curTab">
        <TabPane label="基本信息" name="base">
            <Form :model="formItem" ref="baseForm" :rules="ruleValidate" :label-width="80">
                <FormItem label="姓名" prop="realname">
                <Input v-model="formItem.realname" placeholder="请输入真实姓名..."></Input>
                </FormItem>
                <FormItem label="手机号" prop="phone">
                <Input v-model="formItem.phone" placeholder="请输入手机号..."></Input>
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
                <FormItem label="所属角色">
                    <Select v-model="formItem.cur_role" multiple>
                        <Option v-for="item of roleList" :value="item.id" :key="item.id">{{ item.title }}</Option>
                    </Select>
                </FormItem>
                <FormItem label="员工编号">
                <Input v-model="formItem.work_no" placeholder></Input>
                </FormItem>

                <FormItem>
                <Row>
                    <Col span="14">
                    <Button type="primary" @click="handleSaveBase('baseForm')" :loading="onSubmitIng" long>提交</Button>
                    </Col>
                    <Col span="2">&nbsp;</Col>
                    <Col span="8">
                    <Button long @click="handleCancel">取消</Button>
                    </Col>
                </Row>
                </FormItem>
            </Form>
        </TabPane>
        <TabPane label="修改密码" name="reset">
             <Form :model="pwFormItem" ref="resetForm" :rules="ruleValidate" :label-width="80">
                <FormItem label="新密码" prop="password">
                <Input v-model="formItem.realname" type="password" password placeholder=""></Input>
                </FormItem>
                <FormItem>
                <Row>
                    <Col span="14">
                    <Button type="primary" @click="handleSaveReset('resetForm')" :loading="onSubmitIng" long>提交</Button>
                    </Col>
                    <Col span="2">&nbsp;</Col>
                    <Col span="8">
                    <Button long @click="handleCancel">取消</Button>
                    </Col>
                </Row>
                </FormItem>
            </Form>
        </TabPane>
    </Tabs>
  </div>
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
      curTab: 'base',
      onSubmitIng: false,
      roleList: [],
      formItem: {
        realname: '',
        phone: '',
        department: '',
        role: [],
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
        phone: [
          {
            required: true,
            message: '手机号不能为空',
            trigger: 'blur'
          }
        ]
      },
      pwFormItem: {
        password: ''
      },
      pwValidateRule: {
        passwod: [
          { required: true, message: '密码长度必须为6-12位', trigger: 'blur' },
          {
            type: 'string',
            min: 6,
            max: 12,
            message: '密码长度必须为6-12位',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  watch: {
    id: function (newVal) {
      axios.request({
        url: 'Members/edit',
        params: { id: newVal }
      }).then(res => {
        this.formItem = res.data.memberInfo
      }, reject => {

      })
    }
  },
  methods: {
    handleCancel () {
      this.$emit('on-cancel')
    },
    handleSaveBase (name) {
      this.$refs[name].validate(valid => {
        if (valid) {
          // this.$Message.success('Success!')
          this.onSubmitIng = true
          axios
            .request({
              url: 'Members/do_modify',
              data: { ...this.formItem },
              method: 'post'
            })
            .then(res => {
              this.$Message.success('Success!')
              this.$emit('on-success', res.data.memberInfo)
              this.onSubmitIng = false
            }, reject => {
              this.onSubmitIng = false
            })
        } else {
          // this.$Message.error('Fail!')
        }
      })
    },
    handleSavePassword (name) {
      this.$refs[name].validate(valid => {
        if (valid) {
          // this.$Message.success('Success!')
          this.onSubmitIng = true
          axios
            .request({
              url: 'Members/reset',
              data: { password: this.password },
              method: 'post'
            })
            .then(res => {
              this.$Message.success('Success!')
              this.$emit('on-success', res.data.info)
              this.onSubmitIng = false
              this.id = null
            }, reject => {
              this.onSubmitIng = false
            })
        } else {
          // this.$Message.error('Fail!')
        }
      })
    }
  },
  mounted () {
    axios.request({
      url: 'Members/fetch_role'
    }).then(res => {
      this.roleList = res.data.roleList
    }, reject => {

    })
  }
}
</script>
<style>
</style>
