/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-13 23:31:40 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-08-17 22:08:02
 */
<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title"></div>
      <Row :gutter="16">
        <i-col span="18">
          <TeacherForm @form-saved="handleSaved" @form-cancel="handleCancel"></TeacherForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
  </div>
</template>
<script>
import TeacherForm from "./comp-teacher-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { TeacherForm, SuccessPage },
  data() {
    return {
      isCompleted: false
    }
  },
  methods: {
    handleSaved(data){
      this.isCompleted = true
    },
    handleCancel(){
      console.log("add cancel")
    }
  }
};
</script>