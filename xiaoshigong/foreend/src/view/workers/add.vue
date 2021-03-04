<!--
 * @Author: Joy wang
 * @Date: 2021-02-20 07:30:13
 * @LastEditTime: 2021-03-02 08:59:01
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div>
    <WorkerForm @form-saved="handleSaved" @form-cancel="handleCancel"></WorkerForm>
  </div>
</template>
<script>
import WorkerForm from "./main-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { WorkerForm, SuccessPage },
  data() {
    return {
      isCompleted: false
    };
  },
  methods: {
    handleSaved(data) {
      this.isCompleted = true;
    },
    handleCancel() {}
  }
};
</script>