<template>
  <div></div>
</template>

<script>
import { saveData, getTableList, deleteDataOne, getDataOne } from "@/api/data";
export default {
  data() {
    return {
      testId: null,
      formInfo: {
        questionInfo: {},
        answerInfo: []
      }
    };
  },
  mounted() {
    const testId = this.$route.params.testid;
    this.testId = testId;
    if (this.$route.params.questionid) {
      const questionId = this.$route.params.questionid
      getDataOne("/TestsQuestion/edit", { id: questionId }).then(res => {
        if (res) {
          this.formInfo = res.data.info
        }
      });
    }
  }
};
</script>

<style>
</style>

