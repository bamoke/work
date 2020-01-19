<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title">编辑服务项目</div>
      <Row :gutter="16">
        <i-col span="18">
          <ServiceForm @form-saved="handleSaved" :id="id"></ServiceForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
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
      isCompleted: false,
      id: null
    };
  },
  methods: {
    handleSaved(data) {
      this.isCompleted = true;
    },
  },
  mounted() {
    this.id = parseInt(this.$route.params.id)
  }
};
</script>
