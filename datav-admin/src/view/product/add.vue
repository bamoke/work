<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title">添加产品</div>
      <Row :gutter="16">
        <i-col span="18">
          <MainForm @form-saved="handleSaved" @form-cancel="handleCancel"></MainForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
  </div>
</template>
<script>
import MainForm from "./main-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { MainForm, SuccessPage },
  data() {
    return {
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
  }
};
</script>