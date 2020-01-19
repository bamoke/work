<template>
  <div>
    <Card>
      <div slot="title">添加客户</div>
      <Row :gutter="16">
        <i-col span="18">
          <MainForm @form-saved="handleSaved" @form-cancel="handleCancel"></MainForm>
        </i-col>
      </Row>
    </Card>
  </div>
</template>
<script>
import MainForm from "./main-form";
export default {
  name: "",
  components: { MainForm },
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