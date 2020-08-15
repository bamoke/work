<template>
  <div>
    <Card v-if="!isCompleted">
      <div slot="title">添加商家</div>
      <Row :gutter="16">
        <i-col span="18">
          <WelfareForm @form-saved="handleSaved" @form-cancel="handleCancel"></WelfareForm>
        </i-col>
      </Row>
    </Card>
    <SuccessPage v-else></SuccessPage>
  </div>
</template>
<script>
import WelfareForm from './welfare-form'
import SuccessPage from '../components/success-page'
export default {
  name: '',
  components: { WelfareForm, SuccessPage },
  data () {
    return {
      isCompleted: false
    }
  },
  methods: {
    handleSaved (data) {
      this.isCompleted = true
    },
    handleCancel () {
      console.log('add cancel')
    }
  }
}
</script>
