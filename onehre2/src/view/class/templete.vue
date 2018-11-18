<template>
    <Card>
        <h3 slot="title">班级名称:【{{courseInfo.title}}】</h3>
        <router-view></router-view>
    </Card>
</template>
<script>
import { getDataOne } from '@/api/data'
export default {
  data () {
    return {
      courseId: null,
      courseInfo: {}
    }
  },
  mounted () {
    const courseId = this.$route.params.courseid
    this.courseId = courseId
    getDataOne('/Classes/index', { id: courseId }).then(res => {
      if (!res) return
      this.courseInfo = res.data.courseInfo
    })
  }
}
</script>
