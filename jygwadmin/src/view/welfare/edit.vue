<template>
  <div>
    <Tabs :value="editContent">
      <TabPane label="基本资料" name="base">
        <div v-if="!isCompleted">
          <Row :gutter="16">
            <i-col span="18">
              <WelfareForm @form-saved="handleSaved" :id="id"></WelfareForm>
            </i-col>
          </Row>
        </div>
      </TabPane>
      <TabPane label="优惠券管理" name="coupon">
        <Coupon></Coupon>
      </TabPane>
      <TabPane label="商户账号" name="account">
        <Account></Account>
      </TabPane>
    </Tabs>
  </div>
</template>

<script>
import WelfareForm from "./welfare-form";
import Coupon from "./coupon-main.vue";
import Account from "./account.vue";
export default {
  components: { WelfareForm, Coupon,Account },
  data() {
    return {
      editContent: "base",
      isCompleted: false,
      id: null
    };
  },
  methods: {
    handleSaved(data) {
      // this.$Message.success("ok");
    }
  },
  mounted() {
    this.id = parseInt(this.$route.params.id);
  }
};
</script>

<style lang="scss" scoped>
</style>
