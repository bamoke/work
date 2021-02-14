<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title"></div>
      <Row :gutter="16">
        <i-col span="18">
          <GrantsForm @form-saved="handleSaved" @form-cancel="handleCancel"></GrantsForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
  </div>
</template>
<script>
import GrantsForm from "./grants-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { GrantsForm, SuccessPage },
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
      
    }
  }
};
</script>