/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-13 22:30:57 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-08-18 14:32:30
 */
 <template>
  <div>
    <Card>
        <div slot="title">
          <Row :gutter="8">
                <i-col span="8">
                <Input clearable placeholder="请输入名字关键字" class="search-input" v-model="keywords"/>
                </i-col>
                <i-col span="2">
                <Button @click="handleSearch" class="search-btn" type="primary"><Icon type="search"/>&nbsp;&nbsp;搜索</Button>
                </i-col>
          </Row>
        </div>
        <Button type="primary" slot="extra" @click.prevent="handleAdd">
          <Icon type="plus-circled" size="18px"></Icon>
          添加讲师
        </Button>
        <Table border :columns="_customColumns" :data="tableData" @></Table>
        <div class="m-paging-wrap">
          <Page :total="total" :current="curPage" :page-size="pageSize" @on-change="changePage" v-show="total > pageSize"></Page>
        </div>
    </Card>
  </div>
</template>

<script>
import { getTableList, deleteDataOne } from "@/api/data";
import tableMixin from "@/libs/table-mixin";
import config from "@/config";
import aliOss from "@/libs/alioss";

export default {
  name: "teacher-index",
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      columns: [
        {
          title: "头像",
          key: "avatar",
          width: 120,
          render: (h, params) => {
            let props = {
              size: "large",
              icon: "person"
            };
            if (params.row.avatar) {
              props.src = config.aliOss.url + "avatar/" + params.row.avatar;
            }
            return h("Avatar", { props });
          }
        },
        { title: "名称", key: "fullname", width: 150 },
        { title: "职位/头衔", key: "position" },
        { title: "状态", key: "status", width: 100 },
        { title: "创建时间", key: "create_time", width: 150, sortable: true },
        { title: "操作", key: "handle", width: 200, button: ["edit", "delete"] }
      ],
      tableDataApi: "Teacher/vlist",
      tableData: [],
      keywords: "",
      editRowIndex: null
    };
  },
  methods: {
    handleSearch() {
      let queryData = {};
      if (this.keywords != "") {
        queryData.keywords = this.keywords;
      }
      this._toPage(queryData);
    },
    handleAdd() {
      this.$router.push("add");
    },
    handleEdit(params) {
      const id = params.row.id;
      this.$router.push({name:'teacher_edit',params:{id}})
    },
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      const avatarName = params.row.avatar;
      const apiUrl = "teacher/deleteone";
      const vm = this;
      let objectKey = "avatar/" + avatarName;

      // async delete
      async function deleteFile() {
        try {
          let deleteData = await deleteDataOne(apiUrl, id);
          let deleteAvatar = await aliOss.delete(objectKey);
          vm.$Message.success("删除成功");
          vm.tableData.splice(index, 1);
        } catch (e) {
          console.log(e);
        }
      }
      deleteFile();
    },
    _finishedFetchData(res) {
      var queryData = this.$route.query;
      this.tableData = res.info.list;
      this.total = res.info.total;
      this.pageSize = parseInt(res.info.pageSize);
      this.keywords = queryData.keywords;
      this.curPage =
        typeof queryData.p === "undefined" ? 1 : parseInt(queryData.p);
    }
  },
  computed: {},
  mounted() {
    this._fetchData(this._finishedFetchData);
  }
};
</script>
