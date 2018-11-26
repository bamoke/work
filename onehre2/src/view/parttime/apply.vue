<template>
<div>
    <Table border :columns="applyColumn" :data="applyList" :loading="tableLoading"></Table>
      <div class="m-paging-wrap">
        <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="changePage" v-show="total > pageSize*curPage"></Page>
      </div>
</div>
</template>

<script>
import { getTableList, deleteDataOne, getDataOne } from "@/api/data";
export default {
  data() {
    return {
      applyList: [],
      tableLoading: true,
      total: 0,
      curPage: 1,
      pageSize: 20,
      applyColumn: [
        {
          title: "姓名",
          key: "realname",
          width: 150
        },
        {
          title: "手机",
          key: "phone",
          width: 150
        },
        {
          title: "邮箱",
          key: "email",
          width: 200
        },
        {
          title: "投递时间",
          key: "create_time",
          width: 200
        },
        {
          title: "状态",
          key: "status",
          width: 100,
          render: (h, params) => {
            const curStatusName = params.row.statusName;
            const curStatusClass = params.row.statusClass;
            return h("span", { class: curStatusClass }, curStatusName);
          }
        },
        {
          title: "操作",
          key: "handle",
          render: (h, params) => {
            let buttonArr = [
              h(
                "Button",
                {
                  on: { click: () => this.viewResume(params.row.resume_id) },
                  style: { marginLeft: "10px" }
                },
                "查看简历"
              )
            ];
            if (parseInt(params.row.status) < 2) {
              let DropdownItemArr = [
                h(
                  "DropdownItem",
                  {
                    props: { divided: true,name:"2" },
                  },
                  "通过"
                ),
                h(
                  "DropdownItem",
                  {
                    props: { divided: true,name:"3" }
                  },
                  "不通过"
                )
              ];
              if (parseInt(params.row.status) === 0) {
                DropdownItemArr.unshift(
                  h(
                    "DropdownItem",
                    {
                      props: { divided: true,name:"1" }
                    },
                    "审核中"
                  )
                );
              }
              let verifyButton = h(
                "Dropdown",
                {
                  props: { trigger: "click" },
                  on: { "on-click": (name) => this.setStatus(name,params.index) }
                },
                [
                  h("Button", [
                    h("span", { style: "marginRight:5px" }, "审核"),
                    h("Icon", { props: { type: "arrow-down-b" } })
                  ]),
                  h("DropdownMenu", { slot: "list" }, DropdownItemArr)
                ]
              );

              buttonArr.unshift(verifyButton);
            }
            return h("div", buttonArr);
          }
        }
      ]
    };
  },
  methods: {
    changePage(e) {
      console.log(e);
    },
    viewResume(resumeId) {
      this.$router.push({ name: "resume_detail", params: { id: resumeId } });
    },
    setStatus(value, index) {
      getDataOne("/ParttimeApply/verify", {
        id: this.applyList[index].id,
        status: value
      }).then(res => {
        if (res) {
          this.$set(this.applyList,index,res.data.info)
          // this.applyList[index] = res.data.info;
        }
      });
    }
  },
  mounted() {
    const parttimeId = this.$route.params.id;
    this.parttimeId = parttimeId;
    getTableList("/ParttimeApply/vlist", { ptid: parttimeId }).then(res => {
      if (res) {
        this.tableLoading = false;
        this.applyList = res.data.list;
        this.total = res.data.total;
        this.curPage = res.data.page;
        this.pageSize = res.data.pageSize;
      }
    });
  }
};
</script>
<style>
.ivu-dropdown-item-divided {
  margin-top: 0;
}
</style>
