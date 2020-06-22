<template>
  <div class="module-body">
    <div class="department-tree-area">
      <div class="operation-box">
        <Button type="primary">部门管理</Button>
      </div>
      <Menu theme="light" class="department-tree">
        <MenuItem name="1-1">
          <Icon type="ios-people" />未分配部门
        </MenuItem>

        <Submenu name="2">
          <template slot="title">
            <Icon type="ios-people" />研发部
          </template>
          <MenuItem name="2-1">新增用户</MenuItem>
          <MenuItem name="2-2">活跃用户</MenuItem>
          <Submenu name="3">
            <template slot="title">Submenu</template>
            <MenuItem name="3-1">Option 7</MenuItem>
            <MenuItem name="3-2">Option 8</MenuItem>
          </Submenu>
        </Submenu>
      </Menu>
    </div>

    <div class="member-list-wrap">
      <Card :bordered="false" dis-hover>
        <div slot="title">
          <Input
            prefix="ios-search"
            enter-button
            clearable
            style="width:300px;"
            placeholder="姓名/工号/用户名"
          />
        </div>
        <Button slot="extra" type="primary" icon="md-add">添加成员</Button>
        <Table border :columns="columns" :data="memberList" :loading="formLoading"></Table>
        <div class="m-paging-wrap">
          <Page
            :total="pageInfo.total"
            :current="pageInfo.page"
            :page-size="pageInfo.pageSize"
            @on-change="changePage"
          ></Page>
        </div>
      </Card>
    </div>
        <Modal
        v-model="showModal"
        title="Title"
        >
        <p>After you click ok, the dialog box will close in 2 seconds.</p>
        <div slot="footer" class="no-border"></div>
    </Modal>
  </div>
  
</template>

<script>
import axios from "@/libs/api.request";
export default {
  components: {},
  data() {
    return {
      columns: [
        {
          type: "selection",
          width: 60,
          align: "center"
        },
        { title: "姓名", key: "realname", width: 250 },
        { title: "工号", key: "workno", width: 200 },
        { title: "手机/邮箱号", key: "account", width: 200, sortable: true },
        {
          title: "操作",
          render: (h, params) => {
            return h(
              "Button",
              {
                props: {
                  type: "primary",
                  ghost: true
                },
                on: {
                  'click': () => this.settingMember(params)
                }
              },
              "设置"
            );
          }
        }
      ],
      memberList: [
        {
          id: 1,
          realname: "老王",
          workno: "2910283",
          account: "15015964846"
        }
      ],
      formLoading: false,
      pageInfo: {
        total: 0,
        page: 1,
        pageSize: 20
      },
      department: [
        {
          nanme: "研发部",
          child: [
            {
              name: "前端",
              child: [
                {
                  name: "UI"
                },
                { name: "Javescript" },
                { name: "Html" }
              ]
            },
            {
              name: "服务器",
              child: [
                {
                  name: "PHP"
                },
                {
                  name: "Api接口"
                },
                {
                  name: "数据库"
                }
              ]
            }
          ]
        }
      ],
      showModal: false
    }
  },
  methods: {
    handleReset() {
      console.log("reset");
    },
    changePage () {},
    settingMember (params) {
      this.showModal = true
      console.log(params)
    }
  },
  mounted() {
    // axios.request({
    //   url: 'Account/index'
    // }).then(res => {
    //   this.accountInfo = res.data.account
    //   this.orgInfo = res.data.org
    // })
  }
};
</script>
<style lang="less">
.ivu-menu-vertical.ivu-menu-light:after {
  display: none;
}
.module-body {
  display: flex;
  width: 100%;
  height: 100%;
  background: #fff;
}
.department-tree {
  flex: 1 1 0;
}
.department-tree-area {
  flex-grow: 0;
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  width: 242px;
  height: 100%;
  border-right: 1px solid #f3f3f3;
  overflow: auto;
  background: #fff;
}
.member-list-wrap {
  flex-shrink: 1;
  width: 100%;
}
.ivu-modal-footer {
  display: none;
}
</style>>
