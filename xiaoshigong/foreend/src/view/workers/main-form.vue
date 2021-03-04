<!--
 * @Author: Joy wang
 * @Date: 2021-02-19 23:28:46
 * @LastEditTime: 2021-03-03 08:08:47
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <Card>
    <Tabs :value="tabelValue">
      <TabPane label="基本信息" name="base">
        <Form
          ref="workerBaseForm"
          :model="formInfo"
          :rules="ruleForm"
          :label-width="120"
          label-position="right"
        >
          <Row>
            <i-col span="6">
              <FormItem label="姓名：" prop="name">
                <Input v-model.trim="formInfo.name" placeholder="请输入劳工姓名" />
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="性别：" prop="gender">
                <Select v-model="formInfo.gender" placeholder="请选择">
                  <Option value="男">男</Option>
                  <Option value="女">女</Option>
                </Select>
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="出生年月日：" prop="birth">
                <DatePicker
                  type="date"
                  placeholder="请选择"
                  v-model="formInfo.birth"
                  style="width:100%;"
                ></DatePicker>
              </FormItem>
            </i-col>
          </Row>
          <Row>
            <i-col span="6">
              <FormItem label="婚姻状况：" prop="marriage">
                <Select v-model="formInfo.marriage" placeholder="请选择">
                  <Option value="未婚">未婚</Option>
                  <Option value="已婚">已婚</Option>
                </Select>
              </FormItem>
            </i-col>

            <i-col span="6" offset="2">
              <FormItem label="民族：" prop="nation">
                <Select v-model="formInfo.nation" placeholder="请选择">
                  <Option
                    v-for="nation in nationArr"
                    :key="nation.id"
                    :value="nation.id"
                  >{{nation.name}}</Option>
                </Select>
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="籍贯：" prop="native">
                <Input v-model.trim="formInfo.native" placeholder />
              </FormItem>
            </i-col>
          </Row>
          <Row>
            <i-col span="6">
              <FormItem label="手机号码：" prop="mobile">
                <Input v-model.trim="formInfo.mobile" placeholder />
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="身份证号：" prop="idcard">
                <Input v-model.trim="formInfo.idcard" placeholder />
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="邮箱：" prop="email">
                <Input v-model.trim="formInfo.email" placeholder />
              </FormItem>
            </i-col>
          </Row>
          <Row>
            <i-col span="6">
              <FormItem label="身高：" prop="height">
                <i-input v-model.trim="formInfo.height" placeholder>
                  <span slot="append">厘米</span>
                </i-input>
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="健康状况：" prop="health">
                <Input v-model.trim="formInfo.health" placeholder />
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="期望薪资：">
                <Input v-model.trim="formInfo.wage" placeholder />
              </FormItem>
            </i-col>
          </Row>
          <Row>
            <i-col span="6">
              <FormItem label="学历：" prop="edu">
                <Select v-model="formInfo.edu" placeholder="请选择">
                  <Option v-for="edu in eduArr" :key="edu.id" :value="edu.id">{{edu.name}}</Option>
                </Select>
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="毕业院校：" prop="school">
                <Input v-model.trim="formInfo.school" placeholder />
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="专业：">
                <Input v-model.trim="formInfo.major" placeholder />
              </FormItem>
            </i-col>
          </Row>
          <Row>
            <i-col span="6">
              <FormItem label="毕业时间：" prop="graduation">
                <DatePicker
                  type="date"
                  placeholder="请选择"
                  v-model="formInfo.graduation"
                  style="width:100%;"
                ></DatePicker>
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="居住地址：" prop="address">
                <Input v-model.trim="formInfo.address" placeholder />
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="中间介绍人：" prop="introducer">
                <Select v-model="formInfo.introducer" placeholder="请选择">
                  <Option
                    v-for="introducer in introducerArr"
                    :key="introducer.id"
                    :value="introducer.id"
                  >{{introducer.name}}</Option>
                </Select>
              </FormItem>
            </i-col>
          </Row>
          <FormItem label="备注说明：">
            <Input
              v-model="formInfo.description"
              type="textarea"
              :autosize="{minRows: 2,maxRows: 5}"
              placeholder
            />
          </FormItem>

          <Row>
            <i-col span="6">
              <FormItem label="紧急联系人：" prop="contact_name">
                <Input v-model.trim="formInfo.contact_name" placeholder />
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="与本人关系：" prop="contact_relation">
                <Input v-model.trim="formInfo.contact_relation" placeholder />
              </FormItem>
            </i-col>
            <i-col span="6" offset="2">
              <FormItem label="紧急联系电话：" prop="contact_tel">
                <Input v-model.trim="formInfo.contact_tel" placeholder />
              </FormItem>
            </i-col>
          </Row>

          <FormItem>
            <Button
              type="primary"
              size="large"
              @click="handleSubmit('workerBaseForm')"
              :loading="submitIng"
              style="width:40%"
            >提交</Button>
            <Button @click="handleCancel" size="large" style="width:40%;margin-left: 8px">取消</Button>
          </FormItem>
        </Form>
      </TabPane>
      <TabPane label="工作经历" name="work">
        <Alert type="error" show-icon v-if="!formInfo.id">
          <Icon type="ios-bulb-outline" slot="icon"></Icon>请先保存劳工基本资料！
        </Alert>
        <Row :gutter="32">
          <i-col span="6">起止时间</i-col>
          <i-col span="4">工作单位/职位</i-col>
          <i-col span="4">离职原因</i-col>
          <i-col span="4">操作</i-col>
        </Row>
        <Row :gutter="48" v-for="(work,index) in workInfo" :key="index" class="item-row">
          <i-col span="6">
            <Row>
              <i-col span="11">
                <DatePicker type="date" v-model="work.start_date" placeholder="选择开始日期"></DatePicker>
              </i-col>
              <i-col span="2" style="text-align:center;">至</i-col>
              <i-col span="11">
                <DatePicker type="date" v-model="work.end_date" placeholder="选择结束日期"></DatePicker>
              </i-col>
            </Row>
          </i-col>
          <i-col span="4">
            <Input v-model.trim="work.company" placeholder />
          </i-col>
          <i-col span="4">
            <Input v-model.trim="work.leave_reason" placeholder />
          </i-col>
          <i-col span="4">
            <Button type="primary" ghost @click="saveItem('work',index)">保存</Button>
            <Button
              type="error"
              ghost
              style="margin-left:12px;"
              @click="deleteItem('work',index)"
            >删除</Button>
          </i-col>
        </Row>
        <div class="add-btn">
          <Button type="primary" icon="ios-add" @click="addItem('work')">增加项目</Button>
        </div>
      </TabPane>
      <TabPane label="家庭成员" name="family">
        <Row :gutter="32">
          <i-col span="2">姓名</i-col>
          <i-col span="2">关系</i-col>
          <i-col span="4">工作单位/职位</i-col>
          <i-col span="4">联系电话</i-col>
          <i-col span="4">操作</i-col>
        </Row>
        <div  v-if="familyInfo.length">
          <Row :gutter="32" v-for="(family,index) in familyInfo" :key="index" class="item-row">
            <i-col span="2">
              <Input v-model.trim="family.name" placeholder />
            </i-col>
            <i-col span="2">
              <Input v-model.trim="family.relation" placeholder />
            </i-col>
            <i-col span="4">
              <Input v-model.trim="family.work" placeholder />
            </i-col>
            <i-col span="4">
              <Input v-model.trim="family.tel" placeholder />
            </i-col>
            <i-col span="4">
              <Button type="primary" ghost @click="saveItem('family',index)">保存</Button>
              <Button
                type="error"
                ghost
                style="margin-left:12px;"
                @click="deleteItem('family',index)"
              >删除</Button>
            </i-col>
          </Row>
        </div>
        <div class="add-btn">
          <Button type="primary" icon="ios-add" @click="addItem('family')">增加项目</Button>
        </div>
      </TabPane>
    </Tabs>
  </Card>
</template>

<script>
import { saveData, getDataOne, deleteData } from "@/api/data";
const defaultFormData = {
  name: "",
  description: "",
  status: "1"
};
export default {
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data() {
    const workItemDefault = {
      start_data: "",
      end_data: "",
      company: "",
      leave_reason: ""
    };
    const familyItemDefault = {
      name: "",
      relation: "",
      work: "",
      tel: ""
    };
    return {
      submitIng: false,
      eduArr: [],
      nationArr: [],
      introducerArr: [],
      actype: "add",
      tabelValue: "base",
      formInfo: { ...defaultFormData },
      workInfo: [workItemDefault],
      familyInfo: [familyItemDefault],
      ruleForm: {
        name: [{ required: true, message: "请输入员工姓名" }],
        gender: [{ required: true, message: "请选择性别" }],
        birth: [
          {
            required: true,
            message: "请选择出生年月日"
          }
        ],
        marriage: [{ required: true, message: "请选择婚姻状况" }],
        nation: [{ required: true, message: "请选择民族" }],
        native: [{ required: true, message: "请填写籍贯" }],
        mobile: [
          { required: true, message: "请填写手机号码" },
          { pattern: /^1[0-9]{10}$/, message: "手机号码格式不正确" }
        ],
        idcard: [{ required: true, message: "请填写身份证号码" }],
        email: [{ type: "email", message: "邮箱格式不正确" }],
        height: [
          {
            required: true,
            type: "integer",
            message: "身高为正整数",
            transform(value) {
              return parseInt(value);
            }
          }
        ],
        edu: [{ required: true, message: "请选择学历" }],
        address: [{ required: true, message: "请填写现在的居住地址" }],
        contact_name: [{ required: true, message: "请填写紧急联系人" }],
        contact_relation: [{ required: true, message: "请填写与本人的关系" }],
        contact_tel: [{ required: true, message: "请填写紧急联系人电话" }]
      }
    };
  },
  watch: {
    id: function(newValue, oldValue) {
      if (!newValue) {
        this.actype = "add";
        this.initForm();
        return;
      }
      this.actype = "eidt";
      getDataOne("/Worker/info", { id: newValue }).then(res => {
        this.formInfo = res.data.info;
        if(res.data.workList.length > 0) {
          this.workInfo = res.data.workList
        }
        if(res.data.familyList.length > 0) {
          this.familyInfo = res.data.familyList
        }
      });
    }
  },
  methods: {
    //表单初始化
    initForm() {
      this.formInfo = { ...defaultFormData };
      this.$refs["introducerForm"].resetFields();
    },
    // 
    addItem(itemName) {
      if(itemName === "work") {
        this.workInfo.push({})
      }else {
        this.familyInfo.push({})
      }
    },
    //
    deleteItem(itemName,index){
      var dataName = itemName+"Info";

      if(this[dataName][index].id) {
        deleteData("Worker/delete_item",{table:itemName,id:this[dataName][index].id}).then(res=>{
          this.$Message.success("删除成功")
          this[dataName].splice(index,1)
        })
      }else {
        this[dataName].splice(index,1)
      }

    },
    //
    saveItem(itemName,index) {
      var postData,dataList
      if(!this.formInfo.id) {
        this.$Message.error("请先创建劳工基本资料")
        return
      }
      if(itemName === 'work') {
        dataList = this.workInfo
      }else {
        dataList = this.familyInfo
      }
      postData = {...dataList[index],table:itemName,wid:this.formInfo.id}

      saveData("Worker/save_item",postData).then(res=>{
        this.$Message.success("保存成功")
        this.$set(this[itemName+'Info'],index,res.data.info)
        console.log(this[itemName+'Info'])
      })
    },
    //submit
    handleSubmit(name) {
      this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          saveData("Worker/save_base", this.formInfo).then(
            res => {
              this.$Message.success("Success!");
              this.formInfo = res.data.info;
              this.submitIng = false;
            },
            reject => {
              this.submitIng = false;
            }
          );
        } else {
          // this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      this.$store.commit("closeTag", this.$route);
    }
  },
  mounted() {
    getDataOne("Classification/get_edu").then(res => {
      this.eduArr = res.data.list;
    });
    getDataOne("Classification/get_nation").then(res => {
      this.nationArr = res.data.list;
    });
    getDataOne("Introducer/all_list").then(res => {
      this.introducerArr = res.data.list;
    });
  }
};
</script>
<style>
.add-btn {
  margin-top: 24px;
}
.item-row {margin-bottom:12px;}
</style>
