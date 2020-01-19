<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title">编辑联系人</div>
      <Row :gutter="16">
        <i-col span="18">
          <MainForm @form-saved="handleSaved" :id="id"></MainForm>
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
