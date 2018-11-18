<template>
    <div class="m-member-list">
        <Table border :columns="_customColumns" :data="list" :loading="formLoading"></Table>
        <div class="m-paging-wrap">
          <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="changePage" v-show="total > pageSize"></Page>
        </div>
    </div>
</template>
<script>
import { getDataOne } from '@/api/data'
import tableMixin from '@/libs/table-mixin'
export default {
  mixins: [tableMixin],
  data () {
    return {
      courseId: null,
      formLoading: true,
      list: [],
      curPage: 1,
      total: 0,
      pageSize: 20,
      columns: [
        {
          title: '序号',
          type: 'index',
          width: 60,
          align: 'center'
        },
        {
          title: '姓名',
          key: 'realname',
          width: 150
        },
        {
          title: '班级身份',
          width: 150,
          render: (h, params) => {
            var txt, className
            if (params.row.type == 4) {
              txt = '班长'
              className = 's-text-error'
            } else if (params.row.type == 3) {
              className = 's-text-info'
              txt = '副班长'
            } else {
              txt = '学员'
            }
            return h('div', { class: className }, txt)
          }
        },
        {
          title: '手机号',
          key: 'phone',
          width: 150
        },
        {
          title: '操作',
          key: 'handle',
          button: ['delete']
        }
      ]
    }
  },
  methods: {
    handleDelete (params) {
      const memberId = params.row.id
      console.log(memberId)
    }
  },
  mounted () {
    const courseId = this.$route.params.courseid
    this.courseId = courseId
    getDataOne('/Classes/member', { courseid: courseId }).then(res => {
      if (!res) return
      this.list = res.data.list
      this.total = parseInt(res.data.total)
      this.pageSize = parseInt(res.data.pageSize)
      this.curPage = parseInt(res.data.page)
      this.formLoading = false
    })
  }
}
</script>
