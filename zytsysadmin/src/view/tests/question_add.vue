<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title"><Icon type="ios-compose-outline" />内容填写，带*号为必填项</div>
      <Row :gutter="16">
        <i-col span="18">
          <QuestionForm operate-type="0" @form-saved="handleSaved" @form-cancel="handleCancel"></QuestionForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
  </div>
</template>
<script>
import QuestionForm from "./question-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { QuestionForm, SuccessPage },
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