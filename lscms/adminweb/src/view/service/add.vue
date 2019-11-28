<template>
  <div>
    <Card>
      <div slot="title">添加服务项目</div>
      <Row :gutter="16">
        <i-col span="18">
          <ServiceForm @form-saved="handleSaved" @form-cancel="handleCancel"></ServiceForm>
        </i-col>
      </Row>
    </Card>
  </div>
</template>
<script>
import ServiceForm from "./service-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { ServiceForm, SuccessPage },
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