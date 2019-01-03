<template>
  <div style="position:relative;">
    <Row :gutter="24">
      <i-col span="6">
        <div class="m-node-list">
          <div
            class="node-item"
            :class="{active:item.id==curNodeId}"
            v-for="(item,index) in nodeList"
            :key="index"
            @click="handleShow(item)"
          >{{item.title}}</div>
        </div>
      </i-col>
      <i-col span="18">
        <div class="m-content-wrap" v-if="contentInfo.total > 0">
          <Row class="content-item" v-for="(item,index) in contentInfo.list" :key="index">
            <i-col span="20">
              <div class="top">
                <span class="name">{{item.realname}}</span>
                <span class="time">发表于:{{item.create_time}}</span>
              </div>
              <div class="content">{{item.content}}</div>
            </i-col>
            <i-col span="4">
              <div class="comment-btn" @click="handleShowComment(item)">
                <Icon size="24" type="chatbubble-working"></Icon>
                <p>查看评论</p>
              </div>
            </i-col>
          </Row>
          <div class="m-paging-wrap">
            <Page
              :total="contentInfo.total"
              :current="contentInfo.page"
              :page-size="contentInfo.pageSize"
              @on-change="changePage"
              v-show="contentInfo.total > contentInfo.pageSize"
            ></Page>
          </div>
        </div>
        <div v-else>暂无记录</div>
      </i-col>
    </Row>
    <Modal width="640" v-model="showComment" title="内容评论">
      <Table border :columns="commentColumns" :data="commentInfo.list" :loading="commentLoading"></Table>
      <div slot="footer"></div>
    </Modal>
  </div>
</template>
<script>
import { getDataOne } from "@/api/data";
import axios from "@/libs/api.request";
export default {
  data() {
    return {
      discussId: null,
      curNodeId: null,
      nodeList: [],
      contentInfo: {
        page: 1,
        total: 0,
        pageSize: 20,
        list: []
      },
      showComment: false,
      commentInfo: {
        page: 1,
        pageSize: 20,
        total: 0,
        list: []
      },
      commentLoading:false,
      commentColumns: [
        {
          title: "#",
          type: "index",
          width: 60
        },
        {
          title: "姓名",
          key: "realname",
          width: 80
        },
        {
          title: "评论内容",
          key: "content"
        },
        {
          title: "日期",
          key: "create_time",
          width: 160
        },
        {
          title: "操作",
          width:80,
          render: (h, params) => {
            return h(
              "Button",
              {
                on: {
                  click: () => {
                    this.handleDelComment(params);
                  }
                }
              },
              "删除"
            );
          }
        }
      ]
    };
  },
  methods: {
    handleShow(curItem) {
      const nodeId = curItem.id;
      if (this.curNodeId == nodeId) return;
      this.curNodeId = nodeId;
    },
    handleShowComment(curItem) {
      const contentId = curItem.id;
      const discussid = curItem.dc_id
      this.showComment = true;
      this.commentLoading = true;
        axios.request({
          url: "/DiscussComment/vlist",
          params: {
            discussid:discussid,
            contentid: contentId
          },
          method: "get"
        })
        .then(res => {
          if (!res) return false;
          this.commentInfo = res.data.comment
          this.commentLoading = false
        });
    },
    handleDelComment(params) {
      const index = params.index;
      const commentId = params.row.id;
      axios
        .request({
          url: "/DiscussComment/delone",
          params: {
            id: commentId
          },
          method: "get"
        })
        .then(res => {
          if (!res) return false;
          this.commentInfo.list.splice(index,1)
        });
    },
    changePage(newPage) {
      axios
        .request({
          url: "/DiscussContent/vlist",
          params: {
            discussid: this.discussId,
            nodeid: this.curNodeId,
            page: newPage
          },
          method: "get"
        })
        .then(res => {
          if (!res) return false;
          this.contentInfo = res.data.content;
        });
    }
  },
  watch: {
    curNodeId(newVal) {
      if (newVal) {
        axios
          .request({
            url: "/DiscussContent/vlist",
            params: { discussid: this.discussId, nodeid: newVal },
            method: "get"
          })
          .then(res => {
            if (!res) return false;
            this.contentInfo = res.data.content;
          });
      }
    }
  },
  mounted() {
    const discussId = this.$route.params.disid;
    this.discussId = discussId;
    if (this.$route.params.nodeid) {
      this.curNodeId = this.$route.params.nodeid;
    }
    axios
      .request({
        url: "/DiscussContent/index",
        params: { id: discussId },
        method: "get"
      })
      .then(res => {
        if (!res) return;
        this.nodeList = res.data.list;
        if (!this.curNodeId) {
          this.curNodeId = res.data.list[0].id;
        }
      });
  }
};
</script>
<style>
.node-item {
  margin-bottom: 24px;
  padding: 12px;
  border: 1px solid #ddd;
  font-size: 16px;
  transition: all 0.3s;
  cursor: pointer;
  background: #f1f1f1;
}
.node-item:hover,
.active {
  color: #fff;
  background-color: #2d8cf0;
}
.m-content-wrap .content-item {
  padding: 12px 0;
  border-bottom: 1px solid #ddd;
}
.m-content-wrap .content-item .time {
  margin-left: 12px;
  color: #9c9c9c;
  font-size: 12px;
}
.m-content-wrap .content-item .comment-btn {
  display: none;
  color: #2d8cf0;
  text-align: center;
  line-height: 1;
  font-size: 12px;
  cursor: pointer;
}
.m-content-wrap .content-item:hover .comment-btn {
  display: block;
}
</style>

