<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title"></div>
      <Row :gutter="16">
        <i-col span="18">
          <EventForm @form-saved="handleSaved" :id="id"></EventForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
  </div>
</template>
<script>
import EventForm from "./event-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { EventForm, SuccessPage },
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
