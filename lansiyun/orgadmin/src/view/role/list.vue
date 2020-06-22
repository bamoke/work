<template>
  <Row>
    <Col span="6">
        <Row>
            <Col span="10">
                <Button type="sucess">新建角色</Button>
            </Col>
            <Col span="4"></Col>
            <Col span="10">
                <Button>新建分组</Button>
            </Col>
        </Row>
      <Menu theme="light" class="department-tree" @on-select="selectedDepartment">
        <MenuItem name="0">
          <Icon type="ios-people" />未分配部门
        </MenuItem>
        <template v-for="(item,i) of department">
        <Submenu :name="i" :key="i" v-if="item.child.length">
          <template slot="title">
            <Icon type="ios-people" />{{item.name}}
          </template>
          <MenuItem :name="child.id" v-for="child of item.child" :key="child.id">{{child.name}}</MenuItem>
        </Submenu>
        <MenuItem :name="item.id"  :key="i" v-else>
          <Icon type="ios-people" :key="i" />{{item.name}}
        </MenuItem>
        </template>

      </Menu>
    </Col>

    <Col span="18">
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
        <Button slot="extra" type="primary" icon="md-add" @click="handleAdd">添加成员</Button>
        <Table border :columns="columns" :data="memberList" :loading="formLoading"></Table>
        <div class="m-paging-wrap">
          <Page
            :total="pageInfo.total"
            :current="pageInfo.page"
            :page-size="pageInfo.pageSize"
            @on-change="changePage"
            v-if= "pageInfo.total > pageInfo.pageSize"
          ></Page>
        </div>
      </Card>
    </Col>
        <Modal
        v-model="showModal"
        :title="modalTitle"
        >
        <div slot="footer" class="no-border"></div>
    </Modal>
  </Row>
</template>

<script>
import axios from '@/libs/api.request'
export default {
  components: { },
  data () {
    return {
      columns: [
        {
          type: 'selection',
          width: 60,
          align: 'center'
        },
        { title: '姓名', key: 'realname', width: 250 },
        { title: '工号', key: 'work_no', width: 200 },
        { title: '手机', key: 'phone', width: 200, sortable: true },
        { title: '部门', key: 'department_name', width: 200 },
        {
          title: '操作',
          render: (h, params) => {
            return h(
              'Button',
              {
                props: {
                  type: 'primary',
                  ghost: true
                },
                on: {
                  'click': () => this.settingMember(params)
                }
              },
              '设置'
            )
          }
        }
      ],
      memberList: [],
      formLoading: false,
      pageInfo: {
        total: 0,
        page: 1,
        pageSize: 20
      },
      roleList: [],
      showModal: false,
      modalTitle: '',
      modalContent: 'role',
      curEditMember: {}
    }
  },
  watch: {
    '$route': function () {
      const queryData = this.$route.query
      if (typeof queryData.dpid !== 'undefined') {
        this.keywords = queryData.keywords
      }
      this._fetchData(this._finishedFetchData)
    }
  },
  methods: {
    handleReset () {
      console.log('reset')
    },
    changePage () {},
    // 添加成员
    handleAdd () {
      this.modalContent = 'add'
      this.showModal = true
      this.modalTitle = '添加成员'
    },
    // 取消添加
    handleCloseModal () {
      this.showModal = false
    },
    // 添加完成
    handleCompleted (newInfo) {
      this.memberList.push(newInfo)
      this.showModal = false
    },
    settingMember (params) {
      this.modalContent = 'setting'
      this.showModal = true
      this.modalTitle = '用户设置'
      this.curEditMember = {
        id: parseInt(params.row.id),
        index: params.index
      }
    },
    // 更新基本信息完成
    handleUpdateBase (newInfo) {
      this.showModal = false
      console.log(newInfo)
      this.$set(this.memberList, this.curEditMember.index, newInfo)
    },
    // 选择部门
    selectedDepartment (id) {
      // this.$router.replace({ name: 'auth_members', query: { d: id } })
      axios.request({
        url: 'Members/vlist',
        params: { dpid: id }
      }).then(res => {
        this.memberList = res.data.members
        this.pageInfo = res.data.pageInfo
        this.department = res.data.department
      })
    },
    // 获取数据
    _fetchData () {
      axios.request({
        url: 'Members/vlist'
      }).then(res => {
        this.memberList = res.data.members
        this.pageInfo = res.data.pageInfo
        this.department = res.data.department
      }).catch(reject => {
      })
    }
  },
  mounted () {
    // this._fetchData()
  }
}
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
