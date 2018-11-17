<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title"><Icon type="ios-compose-outline" />内容填写，带*号为必填项</div>
      <Row :gutter="16">
        <i-col span="18">
          <ParttimeForm :id="id" @form-saved="handleSaved" @form-cancel="handleCancel"></ParttimeForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
  </div>
</template>
<script>
import ParttimeForm from "./parttime-form";
import SuccessPage from "../components/success-page";
export default {
  name: "",
  components: { ParttimeForm, SuccessPage },
  data() {
    return {
      isCompleted: false,
      id:null
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
    const curId = this.$route.params.id
    this.id = parseInt(curId)
  }
};
</script>