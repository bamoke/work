/*
 * @Author: joy.wangxiangyin 
 * @Date: 2019-03-07 03:02:27 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-03-07 03:14:53
 */

<template>
  <div>
    <Card>
        <div slot="title">
          <Row :gutter="8">
                <i-col span="8">
                <Input clearable placeholder="输入关键字搜索" class="search-input" v-model="keywords"/>
                </i-col>
                <i-col span="2">
                <Button @click="handleSearch" class="search-btn" type="primary"><Icon type="search"/>&nbsp;&nbsp;搜索</Button>
                </i-col>
          </Row>
        </div>
        <Table border :columns="_customColumns" :data="tableData" :loading="showTableLoading"></Table>
        <div class="m-paging-wrap">
          <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="changePage" v-show="total > pageSize"></Page>
        </div>
    </Card>
  </div>
</template>

<script>
import { getTableList, deleteDataOne } from '@/api/data'
import tableMixin from '@/libs/table-mixin'
export default {
  name: '',
  mixins: [tableMixin],
  props: {},
  data () {
    return {
      columns: [
        { title: '名称', key: 'title', width: 450 },
        {
          title: '类型',
          key: 'type',
          width: 80,
          render: (h, params) => {
            var txt, className
            if (params.row.type == 1) {
              txt = '公开课'
              className = 's-text-info'
            } else {
              txt = '内训'
              className = 's-text-error'
            }
            return h('div', { class: className }, txt)
          }
        },
        { title: '显示状态', key: 'status', width: 100 },
        { title: '创建时间', key: 'create_time', width: 180, sortable: true },
        {
          title: '操作',
          render: (h, params) => {
            return h('div', [
              h(
                'Button',
                {
                  style: {
                    marginRight: '10px'
                  },
                  on: { click: () => this.handleEdit(params) }
                },
                '编辑'
              ),
              h(
                'Button',
                { on: { click: () => this.handleGoClass(params) } },
                '班级管理'
              )
            ])
          }
        }
      ],
      tableDataApi: 'Course/vlist',
      showTableLoading: true,
      tableData: [],
      keywords: '',
      curPage: 1,
      total: 0,
      pageSize: 15,
      showModal: false,
      editRowIndex: null
    }
  },
  methods: {
    handleSearch () {
      let queryData = {}
      if (this.keywords != '') {
        queryData.keywords = this.keywords
      }
      this._toPage(queryData)
    },
    handleAdd () {
      this.$router.push('add')
    },
    handleEdit (params) {
      const id = params.row.id
      this.$router.push({ name: 'course_edit', params: { id } })
    },
    handleDelete (params) {
      const index = params.index
      const id = params.row.id
      const apiUrl = 'Groups/deleteone'
      deleteDataOne(apiUrl, id).then(res => {
        this.$Message.success('删除成功')
        this.tableData.splice(index, 1)
      })
    },
    //
    handleGoClass (params) {
      const courseId = params.row.id
      this.$router.push({ name: 'class_home', params: {courseid: courseId}})
    },

    _finishedFetchData (res) {
      var queryData = this.$route.query
      this.tableData = res.info.list
      this.total = res.info.total
      this.pageSize = parseInt(res.info.pageSize)
      this.keywords = queryData.keywords
      this.curPage =
        typeof queryData.p === 'undefined' ? 1 : parseInt(queryData.p)
    }
  },
  computed: {},
  mounted () {
    this._fetchData(this._finishedFetchData)
  }
}
</script>
