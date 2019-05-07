<template>
  <div>
    <Card>
      <div slot="title">
        <Row :gutter="8">
          <i-col span="8">
            <Input clearable placeholder="输入问卷名称关键字" class="search-input" v-model="keywords"/>
          </i-col>
          <i-col span="2">
            <Button @click="handleSearch" class="search-btn" type="primary">
              <Icon type="search"/>&nbsp;&nbsp;搜索
            </Button>
          </i-col>
        </Row>
      </div>
      <div slot="extra">
        <Button type="primary" @click.prevent="handleAdd" icon="plus-circled">新建问卷</Button>
        <Button type="success" icon="plus-circled" @click="handlePaste">通过复制新建</Button>
      </div>
      <Table border :columns="_customColumns" :data="tableData" :loading="formLoading"></Table>
      <div class="m-paging-wrap">
        <Page
          :total="total"
          :current="curPage"
          :page-size="pageSize"
          @on-change="changePage"
          v-show="total > pageSize"
        ></Page>
      </div>
    </Card>
  </div>
</template>

<script>
import axios from "@/libs/api.request";
import tableMixin from "@/libs/table-mixin";
export default {
  name: "",
  mixins: [tableMixin],
  props: {},
  data() {
    return {
      curCourseId: null,
      columns: [
        { title: "问卷名称", key: "title", width: 300 },
        {
          title: "发布状态",
          key: "stage",
          width: 100,
          render: (h, params) => {
            let isReleased = parseInt(params.row.is_released);
            let tempObj;
            if (1 === isReleased) {
              tempObj = h("span", { class: "s-text-success" }, "已发布");
            } else {
              tempObj = h("span", "未发布");
            }
            return tempObj;
          }
        },
        { title: "显示状态", key: "status", width: 100 },
        { title: "创建时间", key: "date", width: 150, sortable: true },
        {
          title: "操作",
          key: "",
          render: (h, params) => {
            let isReleased = parseInt(params.row.is_released);
            let tempArr = [
              h(
                "Button",
                {
                  style: { marginRight: "12px" },
                  on: { click: () => this.handleEdit(params) }
                },
                "编辑"
              ),
              h(
                "Button",
                {
                  style: { marginRight: "12px" },
                  on: { click: () => this.handleView(params) }
                },
                "详情"
              ),
              h(
                "Button",
                {
                  style: { marginRight: "12px" },
                  on: { click: () => this.handleCopy(params) }
                },
                "复制"
              )
            ];
            if (0 === isReleased) {
              let deleBtn = h(
                "Poptip",
                {
                  props: {
                    confirm: true,
                    title: "确认删除？"
                  },
                  on: {
                    "on-ok": () => this.handleDelete(params)
                  }
                },
                [h("Button", "删除")]
              );
              tempArr.push(deleBtn);
            }
            return h("div", tempArr);
          }
        }
      ],
      tableDataApi: "/Survey/vlist",
      formLoading: false,
      tableData: [],
      keywords: "",
      curPage: 1,
      total: 0,
      pageSize: 0,
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
      let queryData = {};
      if (this.$route.params.courseid) {
        queryData.courseid = this.$route.params.courseid;
      }
      this.$router.push({ name: "survey_add", query: queryData });
    },
    handleEdit(params) {
      const id = params.row.id;
      this.$router.push({ name: "survey_edit", params: { id } });
    },
    handleRelease(params) {},
    handleView(params) {
      const id = params.row.id;
      this.$router.push({ name: "survey_detail", params: { id } });
    },
    handleDelete(params) {
      const index = params.index;
      const id = params.row.id;
      axios
        .request({
          url: "/survey/deleteone",
          params: { id },
          method: "get"
        })
        .then(res => {
          if (res) {
            this.$Message.success("删除成功");
            this.tableData.splice(index, 1);
          }
        });
    },
    handleCopy(params) {
      this.$store.commit({
        type: "setCopySurvey",
        data: { id: parseInt(params.row.id), title: params.row.title }
      });
      this.$Message.success("已复制");
    },
    handlePaste() {
      const copySurvey = this.$store.state.app.copySurvey;
      if (!copySurvey.id) {
        return this.$Message.error("请先复制问卷");
      }

      this.$Modal.confirm({
        content:
          '确认对<strong class="s-text-error">“' +
          copySurvey.title +
          "”</strong>的数据进行拷贝？",
        onOk: () => {
          let requestParams = {
            surveyid: copySurvey.id
          };
          if (this.curCourseId !== null) {
            requestParams.courseid = this.curCourseId;
          }
          axios
            .request({
              url: "/Survey/docopy",
              params: requestParams,
              method: "get"
            })
            .then(res => {
              this.tableData.unshift(res.data.surveyInfo);
              this.$store.commit({
                type: "setCopySurvey",
                data: {}
              });
            });
        }
      });
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
    if (typeof this.$route.params.courseid !== "undefined") {
      this.curCourseId = parseInt(this.$route.params.courseid);
    }
    this._fetchData(this._finishedFetchData);
  }
};
</script>