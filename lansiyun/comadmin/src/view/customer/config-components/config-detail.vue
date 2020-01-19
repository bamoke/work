<template>
  <div>
    <Row :gutter="32">
      <Col span="12">
        <CellGroup>
          <Cell title="产品名称">
            <div class="operation-box" slot="extra">
              <div class="pro-name">{{configInfo.productName}}</div>
              <Button
                type="primary"
                class="operat-btn"
                icon="md-trending-up"
                @click="handleUpgrade"
              >产品升级</Button>
            </div>
          </Cell>
          <Cell title="功能模块">
            <div class="operation-box" slot="extra">
              <Button size="small" type="text" @click="handleShowModule">查看详情</Button>
              <Button type="primary" class="operat-btn" icon="md-grid" @click="handleAddModule">增加模块</Button>
            </div>
          </Cell>
          <Cell title="账号数">
            <div slot="extra">
              <Badge type="info" :count="configInfo.accountNum" />
              <Button
                type="primary"
                class="operat-btn"
                icon="md-happy"
                @click="handleAddAccount"
              >增加账号</Button>
            </div>
          </Cell>
          <Cell title="单据量">
            <div slot="extra">
              <Badge type="info" :count="configInfo.billNum" />万条
              <Button
                type="primary"
                class="operat-btn"
                icon="md-document"
                @click="handleAddBill"
              >增加数量</Button>
            </div>
          </Cell>
        </CellGroup>
      </Col>
      <Col span="12">
        <CellGroup>
          <Cell title="开通日期" :extra="configInfo.product_start"></Cell>
          <Cell title="到期日期" :extra="configInfo.product_deadline"></Cell>
          <Cell :title="'剩余'+configInfo.restDays+'天'" class="h40">
            <Button slot="extra" type="success" style="width:120px" @click="handlRenew">续费</Button>
          </Cell>
        </CellGroup>
      </Col>
    </Row>
    <Divider />
    <Drawer
      :title="drawerTitle"
      :closable="false"
      v-model="showDrawer"
      width="400"
      @on-close="hideDrawer"
    >
      <Tree :data="configInfo.module" v-show="drawerContent == 'module'"></Tree>
      <div class v-show="drawerContent == 'product'">
        <div v-if="productList.length > 0">
          <div class="product-list">
            <RadioGroup v-model="productIndex" vertical @on-change="selectProduct">
              <Radio :label="index" v-for="(product,index) of productList" :key="index">
                <span>{{product.title}}</span>
              </Radio>
            </RadioGroup>
          </div>
          <div class="amount-box">
            金额：
            <span class="s-text-error price">{{amount}}</span>
          </div>
          <div class="pay-type-box">
            <strong>付款方式：</strong>
            <RadioGroup v-model="payType">
              <Radio :label="1">
                <span>余额</span>
              </Radio>
              <Radio :label="2">
                <span>微信</span>
              </Radio>
              <Radio :label="3">
                <span>支付宝</span>
              </Radio>
            </RadioGroup>
          </div>
          <Button
            size="large"
            type="primary"
            :loading="submiting"
            @click="submitProduct"
            style="width:100%;"
          >提交</Button>
        </div>
        <div v-else>暂无可升级产品</div>
      </div>
      <div class v-show="drawerContent == 'addmodule'">
        <Spin size="large" fix v-if="spinShow"></Spin>
        <div>
          <Tree :data="moduleList" show-checkbox @on-check-change="selectModule"></Tree>
          <div class="amount-box">
            金额：
            <span class="s-text-error price">{{amount}}</span>
          </div>
          <div class="pay-type-box">
            <strong>付款方式：</strong>
            <RadioGroup v-model="payType">
              <Radio :label="1">
                <span>余额</span>
              </Radio>
              <Radio :label="2">
                <span>微信</span>
              </Radio>
              <Radio :label="3">
                <span>支付宝</span>
              </Radio>
            </RadioGroup>
          </div>
          <Button
            size="large"
            type="primary"
            :loading="submiting"
            @click="submitModule"
            style="width:100%"
          >提交</Button>
        </div>
      </div>
      <div class v-show="drawerContent == 'addaccount'">
        <div class="product-list">
          <RadioGroup v-model="newAccountNum" @on-change="selectAccount">
            <Radio :label="10">
              <span>10</span>
            </Radio>
            <Radio :label="20">
              <span>20</span>
            </Radio>
            <Radio :label="50">
              <span>50</span>
            </Radio>
            <Radio :label="100">
              <span>100</span>
            </Radio>
          </RadioGroup>
        </div>
        <div class="amount-box">
          金额：
          <span class="s-text-error price">{{amount}}</span>
        </div>
        <div class="pay-type-box">
          <strong>付款方式：</strong>
          <RadioGroup v-model="payType">
            <Radio :label="1">
              <span>余额</span>
            </Radio>
            <Radio :label="2">
              <span>微信</span>
            </Radio>
            <Radio :label="3">
              <span>支付宝</span>
            </Radio>
          </RadioGroup>
        </div>
        <Button
          size="large"
          type="primary"
          :loading="submiting"
          @click="submitAccount"
          style="width:100%;"
        >提交</Button>
      </div>
      <div class v-show="drawerContent == 'addbill'">
        <div class="product-list">
          <RadioGroup v-model="newBillNum" @on-change="selectBill">
            <Radio :label="1">
              <span>1万</span>
            </Radio>
            <Radio :label="2">
              <span>2万</span>
            </Radio>
            <Radio :label="5">
              <span>5万</span>
            </Radio>
            <Radio :label="10">
              <span>10万</span>
            </Radio>
          </RadioGroup>
        </div>
        <div class="amount-box">
          金额：
          <span class="s-text-error price">{{amount}}</span>
        </div>
        <div class="pay-type-box">
          <strong>付款方式：</strong>
          <RadioGroup v-model="payType">
            <Radio :label="1">
              <span>余额</span>
            </Radio>
            <Radio :label="2">
              <span>微信</span>
            </Radio>
            <Radio :label="3">
              <span>支付宝</span>
            </Radio>
          </RadioGroup>
        </div>

        <Button
          size="large"
          type="primary"
          :loading="submiting"
          @click="submitBill"
          style="width:100%;"
        >提交</Button>
      </div>
    </Drawer>
  </div>
</template>
<script>
import axios from "@/libs/api.request";
export default {
  props: {
    configId: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      orgInfo: {},
      configInfo: {},
      showDrawer: false,
      drawerTitle: "",
      drawerContent: "",

      submiting: false,
      spinShow: false,
      yearNum: 0,
      productIndex: "", //已选择产品索引
      newAccountNum: 0, //新增加账号数
      newBillNum: 0, //新增加单据数
      newModule: "", //已选择模块
      amount: 0,
      productList: [], //剩余产品
      moduleList: [], //剩余模块
      payType: 1 //付款方式
    };
  },
  watch: {
    configId: function(newVal) {}
  },
  methods: {
    handlRenew() {},
    handleShowModule() {
      this.showDrawer = true;
      this.drawerTitle = "功能模块";
      this.drawerContent = "module";
    },
    handleUpgrade() {
      this.showDrawer = true;
      this.drawerTitle = "产品升级";
      this.drawerContent = "product";
      axios
        .request({
          url: "CustomerConfig/getpartdata",
          params: { configid: this.configId, type: "product" },
          method: "get"
        })
        .then(res => {
          this.productList = res.data.list;
        });
    },
    handleAddModule() {
      this.showDrawer = true;
      this.drawerTitle = "增加模块";
      this.drawerContent = "addmodule";
      this.spinShow = true;
      axios
        .request({
          url: "CustomerConfig/getpartdata",
          params: { configid: this.configId, type: "module" },
          method: "get"
        })
        .then(
          res => {
            this.moduleList = res.data.list;
            this.spinShow = false;
          },
          reject => {
            this.spinShow = false;
          }
        );
    },
    handleAddAccount() {
      this.showDrawer = true;
      this.drawerTitle = "增加账号数";
      this.drawerContent = "addaccount";
    },
    handleAddBill() {
      this.showDrawer = true;
      this.drawerTitle = "增加单据数量";
      this.drawerContent = "addbill";
    },
    selectProduct(index) {
      const productList = this.productList;
      var newPrice = parseFloat(productList[index].price) * 100;
      var oldPrice = parseFloat(this.configInfo["product_price"]) * 100;
      this.amount =
        (parseInt((newPrice - oldPrice) / 365) * this.configInfo.restDays) /
        100;
    },
    selectModule(newModule) {
      var newAmount = 0;
      var newModuleId = [];
      if (newModule.length == 0) {
        this.amount = newAmount;
        this.newModule = "";
        return;
      }
      newModule.forEach(element => {
        newAmount += element.price * 100;
        newModuleId.push(element.id);
        if (element.pid != 0) {
          newModuleId.push(element.pid);
        }
      });
      this.newModule = newModuleId.sort().join(",");
      this.amount =
        (parseInt(newAmount / 365) * this.configInfo.restDays) / 100;
    },
    selectAccount(num) {
      this.amount =
        (parseInt(((num * this.configInfo.accountPrice) / 365) * 100) *
          this.configInfo.restDays) /
        100;
    },
    selectBill(num) {
      this.amount =
        (parseInt(((num * this.configInfo.billPrice) / 365) * 100) *
          this.configInfo.restDays) /
        100;
    },
    submitProduct() {
      var formData;

      if (this.productIndex === "") {
        this.$Message.error("请选择需要升级的产品");
        return false;
      }
      formData = {
        type: "product",
        configid: this.configInfo.id,
        productid: this.productList[this.productIndex].id
      };
      if (!this._beforerSubmit()) return;

      this.submiting = true;
      axios
        .request({
          url: "CustomerConfig/savepart",
          data: formData,
          method: "post"
        })
        .then(
          res => {
            const resData = res.data.info;
            var newConfigInfo = Object.assign(this.configInfo, resData);
            this.configInfo = newConfigInfo;
            this._drawerReset();

          },
          reject => {
            this.submiting = false;
          }
        );
    },
    submitModule() {
      var formData = {
        type: "module",
        configid: this.configInfo.id,
        module: this.newModule
      };
      if (this.newModule == "") {
        this.$Message.error("请选择模块");
        return;
      }
      if (!this._beforerSubmit()) return;

      this.submiting = true;
      axios
        .request({
          url: "CustomerConfig/savepart",
          data: formData,
          method: "post"
        })
        .then(
          res => {
            const resData = { module: res.data.list };
            var newConfigInfo = Object.assign(this.configInfo, resData);
            this.configInfo = newConfigInfo;
            this._drawerReset();

          },
          reject => {
            this.submiting = false;
          }
        );
    },
    submitAccount() {
      var formData = {
        type: "account",
        configid: this.configInfo.id,
        num: this.newAccountNum
      };
      if (this.newAccountNum == 0) {
        this.$Message.error("请选择需要增加的账号数");
        return;
      }
      if (!this._beforerSubmit()) return;

      this.submiting = true;
      axios
        .request({
          url: "CustomerConfig/savepart",
          data: formData,
          method: "post"
        })
        .then(
          res => {
            const resData = {
              accountNum: this.configInfo.accountNum + this.newAccountNum
            };
            console.log(resData);
            var newConfigInfo = Object.assign(this.configInfo, resData);
            this.configInfo = newConfigInfo;
            this._drawerReset();
          },
          reject => {
            this.submiting = false;
          }
        );
    },
    submitBill() {
      var formData = {
        type: "bill",
        configid: this.configInfo.id,
        num: this.newBillNum
      };
      if (this.newBillNum == 0) {
        this.$Message.error("请选择需要增加的单据数量");
        return;
      }
      if (!this._beforerSubmit()) return;
      this.submiting = true;
      axios
        .request({
          url: "CustomerConfig/savepart",
          data: formData,
          method: "post"
        })
        .then(
          res => {
            const resData = {
              billNum: this.configInfo.billNum + this.newBillNum
            };

            var newConfigInfo = Object.assign(this.configInfo, resData);
            this.configInfo = newConfigInfo;
            this._drawerReset();
          },
          reject => {
            this.submiting = false;
          }
        );
    },
    _drawerReset() {
      this.productIndex =''
      this.newModule = []
      this.newAccountNum = 0;
      this.newBillNum = 0;
      this.amount = 0;
      this.payType = 1
      this.showDrawer = false;
      this.drawerContent = "";
      this.drawerTitle = "";
      this.submiting = false;
    },
    _beforerSubmit() {
      // 检查
      if (this.payType > 1) {
        this.$Message.error("功能开发中……");
        return false;
      }
      return true;
    },
    hideDrawer() {
      this._drawerReset()
    }
  },
  mounted() {
    axios
      .request({
        url: "CustomerConfig/detail",
        params: { id: this.configId },
        method: "get"
      })
      .then(res => {
        this.configInfo = res.data.info;
      });
  }
};
</script>
<style>
.operation-box {
  display: flex;
  align-items: center;
}
.operat-btn {
  margin-left: 20px;
}
.pro-name {
  font-size: 14px;
  font-weight: bold;
}
.h40 {
  height: 40px;
}
.price {
  font-size: 16px;
  font-weight: bold;
}
.amount-box {
  margin-top: 20px;
  padding: 12px 0;
  border-bottom: 1px solid #eee;
  border-top: 1px solid #eee;
  font-weight: bold;
}
.pay-type-box {
  margin-bottom: 20px;
  padding: 12px 0;
  border-bottom: 1px solid #eee;
}
</style>