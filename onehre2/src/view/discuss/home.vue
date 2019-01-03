<template>
  <Card>
    <h3 slot="title">当前:【{{discussInfo.title}}】</h3>
    <router-view></router-view>
  </Card>
</template>
<script>
import { getDataOne } from '@/api/data'
export default {
  data () {
    return {
      courseId: null,
      discussInfo: {}
    }
  },
  mounted () {
    const discussId = this.$route.params.disid
    this.discussId = discussId
    getDataOne('/Discuss/baseinfo', { id: discussId }).then(res => {
      if (!res) return
      this.discussInfo = res.data.info
    })
  }
}
</script>
