<template>
  <Table border :columns="memberColumn" :data="memberList" :loading="tableLoading"></Table>
</template>

<script>
import { getTableList, deleteDataOne } from "@/api/data";
import axios from "@/libs/api.request";
export default {
  data() {
    return {
      parttimeId:null,
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
          render: (h, params) => {
            let iconTemp = h("Icon", {
              props: { type: "person", size: 16 },
              style: { marginRight: "5px" }
            });
            if (params.row.type == 2) {
              return h("div", { class: "s-text-primary" }, [
                iconTemp,
                h("span", "项目管理员")
              ]);
            } else {
              return h("div", [iconTemp, h("span", "成员")]);
            }
          }
        },
        {
          title: "操作",
          key: "handle",
          render: (h, params) => {
            let tempComponents = [
              h(
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
              )
            ];
           if (params.row.type != 2) {
              tempComponents.unshift(
                h(
                  "Button",
                  {
                    on: {
                      click: () => {
                        this.handleSetManager(params);
                      }
                    },
                    style: { marginRight: "12px" }
                  },
                  "设为管理员"
                )
              );
            }
            return h("div", tempComponents);

          }
        }
      ]
    };
  },
  methods: {
    handleSetManager(params){
    const curIndex = params.index;
      axios
        .request({
          url: "/ParttimeMember/set_manager",
          params: { parttimeid: this.parttimeId, id: params.row.id },
          method: "get"
        })
        .then(res => {
          if (!res) return;
          this.memberList.forEach((el,index)=>{
            if(curIndex == index) {
              el.type=2
            }else {
              el.type=1
            }
          })
        });
    },
    handleDelete(params) {
      const id = params.row.id;
      const index = params.index;
      deleteDataOne("/ParttimeMember/delone", id).then(res => {
        if (res) {
          this.memberList.splice(index, 1);
        }
      });
    }
  },
  mounted() {
    const parttimeId = this.$route.params.id;
    this.parttimeId = parttimeId
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
