<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title"></div>
      <Row :gutter="16">
        <i-col span="18">
          <ArticleForm @form-saved="handleSaved" @form-cancel="handleCancel"></ArticleForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
  </div>
</template>
<script>
import ArticleForm from "./article-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { ArticleForm, SuccessPage },
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