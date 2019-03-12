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
      tableDataApi: "/Classes/dynamic",
      columns: [
        {
          title: "#",
          type: "index",
          width: 60
        },
        {
          title: "学员名称",
          key: "membername",
          width: 120
        },
        {
          title: "动态描述",
          key: "content"
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
          url: "/Classes/dynamic",
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
        url: "/Classes/dynamic",
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


