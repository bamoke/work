import axios from '@/libs/api.request'
import handleBtns from '@/components/tables/handle-btns'
const tableMixin = {
  data () {
    return {
      tableLoading: true,
      curPage: 1,
      total: 0,
      pageSize: 15
    }
  },
  methods: {
    changePage (e) {
      const queryData = this.$route.query
      var newQueryData = Object.assign({}, queryData)
      newQueryData.page = e
      this._toPage(newQueryData)
    },
    _fetchData (afterFunc) {
      const apiUrl = this.tableDataApi
      var params = this.$route.params
      var queryData = this.$route.query
      var data = Object.assign(params, queryData)
      this.tableLoading = true
      axios.request(
        {
          url: apiUrl,
          params: { ...data }
        }
      ).then(res => {
        this.tableLoading = false
        afterFunc(res)
      })
    },
    _toPage (queryData) {
      let path = this.$route.path
      this.$router.push({
        path: path,
        query: queryData
      })
    }
  },
  watch: {
    '$route': function () {
      const queryData = this.$route.query
      if(typeof queryData.keywords !== 'undefined') {
        this.keywords = queryData.keywords
      }
      this._fetchData(this._finishedFetchData)
    }
  },
  computed: {
    _customColumns () {
      let newColumns = this.columns.map((column, index) => {
        let customColumn = []
        if (column.key === 'handle') {
          column.button.forEach((item, index) => {
            customColumn.push(handleBtns[item])
          })
          column.render = (h, params) => {
            return h('div', customColumn.map(item => item(h, params, this)))
          }
        }

        if (column.key === 'status' && typeof column.render === 'undefined') {
          column.render = (h, params) => {
            let statusText = '正常'
            let className = 's-text-success'
            if (parseInt(params.row.status) === 0) {
              statusText = '不显示'
              className = 's-text-error'
            }
            return h('span', { class: className }, statusText)
          }
        }
        return column
      })
      return newColumns
    }
  }

}
export default tableMixin
