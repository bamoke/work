<template>
  <div>
    <Row type="flex" justify="space-between" style="margin-bottom:20px;">
      <i-col span="16">
        <Input
          @on-click="handleSearch"
          v-model="keywords"
          icon="ios-search"
          placeholder="请输入姓名"
          style="width: 400px"
        />
      </i-col>
      <i-col span="6" style="text-align:right;">
        <Button type="primary" icon="ios-plus-outline" @click="handleAdd">添加成员</Button>
      </i-col>
    </Row>
    <Table border :columns="memberColumns" :data="memberList" :loading="tableLoading"></Table>
    <div class="m-paging-wrap">
      <Page
        :total="total"
        :current="page"
        :page-size="pageSize"
        @on-change="changePage"
        v-show="total > pageSize"
      ></Page>
    </div>
    <Modal width="640" v-model="showOtherMember" ok-text="确认选择" @on-ok="confirmSelect" title="选择成员">
      <Table
        border
        :columns="libColumns"
        :data="libMemberInfo.list"
        @on-selection-change="handleSelectMember"
      ></Table>
    </Modal>
  </div>
</template>
<script>
import axios from "@/libs/api.request";
export default {
  data() {
    return {
      discussId: null,
      memberList: [],
      page: 1,
      pageSize: 20,
      total: 0,
      keywords: "",
      tableLoading: true,
      memberColumns: [
        {
          title: "#",
          type: "index",
          width: 60
        },
        {
          title: "姓名",
          key: "realname",
          width: 200
        },
        {
          title: "成员类型",
          render: (h, params) => {
            let iconTemp = h("Icon", {
              props: { type: "person", size: 16 },
              style: { marginRight: "5px" }
            });
            if (params.row.type == 2) {
              return h("div", { class: "s-text-primary" }, [
                iconTemp,
                h("span", "组长")
              ]);
            } else {
              return h("div", [iconTemp, h("span", "成员")]);
            }
          }
        },
        {
          title: "操作",
          width: 200,
          render: (h, params) => {
            let tempComponents = [
              h(
                "Button",
                {
                  on: {
                    click: () => {
                      this.handleDel(params);
                    }
                  }
                },
                "移除"
              )
            ];
            if (params.row.type != 2) {
              tempComponents.unshift(
                h(
                  "Button",
                  {
                    on: {
                      click: () => {
                        this.handleSetHeadman(params);
                      }
                    },
                    style: { marginRight: "12px" }
                  },
                  "设为组长"
                )
              );
            }
            return h("div", tempComponents);
          }
        }
      ],
      showOtherMember: false,
      selectedMember: [], //已选择的成员
      libMemberInfo: {
        page: 1,
        pageSize: 20,
        total: 0,
        list: []
      },
      libColumns: [
        {
          type: "selection",
          width: 60,
          align: "center"
        },
        {
          title: "姓名",
          key: "realname"
        }
      ]
    };
  },
  methods: {
    _fetchData(params) {
      axios
        .request({
          url: "/DiscussMember/vlist",
          params,
          method: "get"
        })
        .then(res => {
          if (!res) return;
          this.memberList = res.data.list;
          this.page = res.data.page;
          this.pageSize = res.data.pageSize;
          this.total = res.data.total;
          this.tableLoading = false;
        });
    },
    handleSetHeadman(params) {
      //设为组长
      const curIndex = params.index;
      axios
        .request({
          url: "/DiscussMember/set_headman",
          params: { discussid: this.discussId, id: params.row.id },
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
    handleDel(params) {
      const index = params.index;
      const id = params.row.id;
      axios
        .request({
          url: "/DiscussMember/delone",
          params: { id },
          method: "get"
        })
        .then(res => {
          if (!res) return;
          this.memberList.splice(index, 1);
        });
    },
    handleAdd() {
      this.selectedMember = []; //清空已选择的成员
      axios
        .request({
          url: "/DiscussMember/other_member",
          params: { discussid: this.discussId },
          method: "get"
        })
        .then(res => {
          if (!res) return;
          this.showOtherMember = true;
          this.libMemberInfo = res.data.info;
        });
    },
    handleSearch() {
      let params = {
        discussid: this.discussId
      };
      if (this.keywords) {
        params.keywords = this.keywords;
      }
      this._fetchData(params);
    },
    handleSelectMember(e) {
      this.selectedMember = e;
    },
    confirmSelect() {
      if (this.selectedMember.length === 0) return;
      const seletedId = this.selectedMember.map(item => {
        return item.id;
      });
      axios
        .request({
          url: "/DiscussMember/add",
          params: {
            discussid: this.discussId,
            newid: JSON.stringify(seletedId)
          },
          method: "get"
        })
        .then(res => {
          if (!res) return;
          this.memberList.push(...res.data.newMember);
        });
    },
    changePage(newPage) {}
  },
  mounted() {
    const discussId = this.$route.params.disid;
    this.discussId = discussId;
    this._fetchData({ discussid: discussId });
  }
};
</script>