<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title"><Icon type="ios-compose-outline" />内容填写，带*号为必填项</div>
      <Row :gutter="16">
        <i-col span="18">
          <TestForm :id="id" operate-type="1" @form-saved="handleSaved" @form-cancel="handleCancel"></TestForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
  </div>
</template>
<script>
import TestForm from "./test-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { TestForm, SuccessPage },
  data() {
    return {
      id:null,
      isCompleted: false
    };
  },
  methods: {
    handleSaved(data) {
      this.isCompleted = true;
    },
    handleCancel() {
      console.log("add cancel");
    }
  },
  mounted(){
    const curId = this.$route.params.testid
    this.id = parseInt(curId)
    console.log(curId)
  }
};
</script>