<template>
    <div>
        <Table border :columns="columns" :data="list" :loading="formLoading"></Table>
        <div class="m-paging-wrap">
          <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="changePage" v-show="total > pageSize"></Page>
        </div>
    </div>
</template>
<style>
</style>
<script>
import axios from "@/libs/api.request";
import tableMixin from "@/libs/table-mixin";
export default {
  data() {
    return {
      list: [],
      formLoading: false,
      courseId: null,
      curPage: 1,
      total: 0,
      pageSize: 15,
      tableDataApi: "/Classes/remark",
      columns: [
        {
          title: "#",
          type: "index",
          width: 60
        },
        {
          title: "综合评分",
          width:180,
          render: (h, params) => {
            return h("Rate", {
              props: { value: parseInt(params.row.grade), disabled: true }
            });
          }
        },
        {
          title: "讲师评分",
          width:180,
          render: (h, params) => {
            return h("Rate", {
              props: {
                value: parseInt(params.row.teacher_grade),
                disabled: true
              }
            });
          }
        },
        {
          title: "课程内容评分",
          width:180,
          render: (h, params) => {
            return h("Rate", {
              props: { value: parseInt(params.row.course_grade), disabled: true }
            });
          }
        },
        {
          title: "评价内容",
          key: "comment"
        },
        {
          title: "学员名称",
          key: "membername",
          width: 120
        },
        {
          title: "日期",
          key: "create_time",
          width: 240
        }
      ]
    };
  },
  methods: {
    changePage(page) {
      this.formLoading = true;
      axios
        .request({
          url: "/Classes/remark",
          params: { courseid: this.courseId, page: page },
          method: "get"
        })
        .then(res => {
          if (!res) return false;
          this.list = res.data.list;
          this.total = parseInt(res.data.total);
          this.pageSize = parseInt(res.data.pageSize);
          this.curPage = parseInt(res.data.page);
          this.formLoading = false;
        });
    }
  },
  mounted() {
    const courseId = this.$route.params.courseid;
    this.courseId = courseId;
    this.formLoading = true;
    axios
      .request({
        url: "/Classes/remark",
        params: { courseid: courseId, page: this.curPage },
        method: "get"
      })
      .then(res => {
        if (!res) return false;
        this.list = res.data.list;
        this.total = parseInt(res.data.total);
        this.pageSize = parseInt(res.data.pageSize);
        this.curPage = parseInt(res.data.page);
        this.formLoading = false;
      });
  }
};
</script>


