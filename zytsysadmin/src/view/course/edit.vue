<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title"></div>
      <Row :gutter="16">
        <i-col span="18">
          <CourseForm @form-saved="handleSaved" :id="id"></CourseForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
  </div>
</template>
<script>
import CourseForm from "./course-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { CourseForm, SuccessPage },
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
    const id = this.$route.params.id;
    this.id = parseInt(id);
  }
};
</script>
