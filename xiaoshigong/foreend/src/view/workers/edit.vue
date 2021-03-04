<!--
 * @Author: Joy wang
 * @Date: 2021-02-20 07:30:13
 * @LastEditTime: 2021-03-02 18:06:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div>
    <WorkerForm :id="curId" @form-saved="handleSaved" @form-cancel="handleCancel"></WorkerForm>
  </div>
</template>
<script>
import WorkerForm from "./main-form";
export default {
  name: "",
  components: { WorkerForm },
  data() {
    return {
      curId:0
    };
  },
  methods: {
    handleSaved(data) {
      this.isCompleted = true;
    },
    handleCancel() {}
  },
  mounted(){
      this.curId = parseInt(this.$route.params.id)
  }
};
</script>