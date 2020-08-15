<template>
  <div>
    <Card title="基本资料" icon="ios-options" shadow>
      <Row :gutter="16">
        <i-col span="6">
          <div class="talent-detail-cell">姓名：</div>
          <div class="talent-detail-cell">{{detail.realname}}</div>
        </i-col>
        <i-col span="6">
          <div class="talent-detail-cell">人才类型：</div>
          <div class="talent-detail-cell">{{detail.typename}}</div>
        </i-col>
        <i-col span="6">
          <div class="talent-detail-cell">手机号：</div>
          <div class="talent-detail-cell">{{detail.phone}}</div>
        </i-col>
        <i-col span="6">
          <div class="talent-detail-cell">证件号码：</div>
          <div class="talent-detail-cell">{{detail.papers_no}}</div>
        </i-col>
      </Row>
      <Divider />
      <div class="paper-list">
        <div
          v-for="item in detail.papers_list"
          v-bind:key="item"
          class="item"
          :style="{backgroundImage:'url('+item+')'}"
          @click="showBig(item)"
        ></div>
      </div>
    </Card>
    <Card dis-hover>
      <Row>
        <i-col span="6">
          <div class="talent-detail-cell">申请日期：</div>
          <div class="talent-detail-cell">{{detail.create_time}}</div>
        </i-col>
        <i-col span="6">
          <div class="talent-detail-cell">审核状态：</div>
          <div class="talent-detail-cell">
            <span :class="['s-text-'+detail.verifyname.style]">{{detail.verifyname.name}}</span>
          </div>
        </i-col>
        <i-col span="6">
          <div class="talent-detail-cell">审核人：</div>
          <div class="talent-detail-cell">{{detail.verifyuser}}</div>
        </i-col>
        <i-col span="6">
          <div class="talent-detail-cell">审核时间：</div>
          <div class="talent-detail-cell">{{detail.verify_time}}</div>
        </i-col>
      </Row>
      <Row v-if="detail.verify_status==2 || detail.verify_status==5">
        <i-col span="18">
          <div class="talent-detail-cell">未通过原因：</div>
          <div class="talent-detail-cell">{{detail.reason}}</div>
        </i-col>
      </Row>
      <Divider/>
      <div style="text-align:center;" v-if="detail.verify_status != 6">
        <Button type="primary" size="large" @click="handleVerify" style="width:300px">审核</Button>
      </div>
    </Card>
    <Modal ref="verify-modal" v-model="showImgModal" scrollable width="1200">
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>图片查看</span>
      </p>
      <div style="width:100%;">
        <img :src="curShowImg" alt style="width:100%" />
      </div>
      <!-- <p slot="footer"></p> -->
    </Modal>

    <Modal ref="verify-modal" v-model="showModal" draggable scrollable>
      <p slot="header" style="text-align:left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>人才卡申领审核</span>
      </p>
      <VerifyForm
        :talent-info="editApplyInfo"
        @form-saved="handleVerifySave"
        @form-cancel="handleVerifyCancel"
      ></VerifyForm>
      <p slot="footer"></p>
    </Modal>
  </div>
</template>
<script>
import axios from "@/libs/api.request";
import VerifyForm from "./verify-form"
export default {
  components: {VerifyForm},
  data() {
    return {
      detail: { verifyname: {} },
      showModal: false,
      showImgModal: false,
      curShowImg: "",
      editApplyInfo: {}
    };
  },
  methods: {
    showBig(img) {
      this.showImgModal = true;
      this.curShowImg = img;
    },
    handleVerify() {
      this.showModal =true
      this.editApplyInfo = {
        realname: this.detail.realname,
        id: this.detail.id,
        verify_status: this.detail.verify_status
      };
    },
    handleVerifySave(res) {
      let newDetail = {...this.detail}
      this.showModal = false
      newDetail.verifyname = res.data.info.verifyname
      newDetail.verify_status = res.data.info.verify_status
      newDetail.verify_time = res.data.info.verify_time
      newDetail.reason = res.data.info.reason
      this.detail = newDetail
    },
    handleVerifyCancel() {
      this.showModal = false;
    }
  },
  mounted() {
    const id = this.$route.params.id;
    axios
      .request({
        url: `Talent/apply_detail/id/${id}`,
        method: "get"
      })
      .then(
        res => {
          this.detail = res.data.info;
        },
        reject => {
          this.$Message.error("系统错误");
        }
      );
  }
};
</script>
<style>
.talent-detail-cell {
  display: table-cell;
  line-height: 20px;
}
.paper-list {
  width: 100%;
  display: flex;
}
.paper-list .item {
  box-sizing: border-box;
  flex: 0 0 width;
  margin-right: 12px;
  padding: 4px;
  width: 300px;
  height: 300px;
  overflow: hidden;
  border: 1px solid #eee;
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
  cursor:pointer;
}
.paper-list img {
  max-width: 100%;
}
</style>