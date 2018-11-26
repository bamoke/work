<template>
  <Table border :columns="memberColumn" :data="memberList" :loading="tableLoading"></Table>
</template>

<script>
import { getTableList, deleteDataOne } from "@/api/data";
export default {
  data() {
    return {
      memberList: [],
      tableLoading: true,
      memberColumn: [
        {
          title: "姓名",
          key: "realname"
        },
        {
          title: "手机",
          key: "phone"
        },
        {
          title: "类型",
          key: "type",
          render: (h, params) => {
            let typeName = params.row.type == 1 ? "成员" : "项目管理员";
            return h("span", typeName);
          }
        },
        {
          title: "操作",
          key: "handle",
          render: (h, params) => {
            return h(
              "Poptip",
              {
                props: {
                  confirm: true,
                  title: "你确定要删除吗?"
                },
                on: {
                  "on-ok": () => {
                    this.handleDelete(params);
                  }
                }
              },
              [h("Button", {}, "删除")]
            );
          }
        }
      ]
    };
  },
  methods: {
    handleDelete(params) {
      const id = params.row.id;
      const index = params.index
        deleteDataOne('/ParttimeMember/delone',id).then(res=>{
          if(res){
            this.memberList.splice(index,1)
          }
        })
    }
  },
  mounted() {
    const parttimeId = this.$route.params.id;
    getTableList("/ParttimeMember/index", { ptid: parttimeId }).then(res => {
      if (res) {
        this.memberList = res.data.list;
        this.tableLoading = false;
      }
    });
  }
};
</script>

<style>
</style>
