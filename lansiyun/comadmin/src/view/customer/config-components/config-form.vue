<template>
  <div v-show="pageLoaded">
    <Form
      ref="configForm"
      :model="configInfo"
      :rules="ruleForm"
      :label-width="120"
      label-position="right"
    >
      <FormItem label="选择产品:" prop="product">
        <div class="m-pro-list">
          <div
            class="item"
            :class="{selected:item.isSelected}"
            v-for="(item , index) of productList"
            :key="index"
            @click="selectProduct(index)"
          >
            <div class="title">{{item.title}}</div>
            <div class="price">￥{{item.price}}</div>
          </div>
        </div>
      </FormItem>
      <FormItem label="账号数:">
        <Slider
          v-model="totalAccountNum"
          :step="5"
          :min="0"
          :max="100"
          style="width:300px;"
          show-input
          @on-change="checkAccount"
        ></Slider>
      </FormItem>
      <FormItem label="单据量(万):">
        <Slider
          v-model="totalBillNum"
          :step="1"
          :min="0"
          :max="20"
          style="width:300px;"
          show-input
          @on-change="checkBill"
        ></Slider>
      </FormItem>
      <FormItem label="开通时长(年):">
        <Slider
          v-model="timeLong"
          :step="1"
          :min="0"
          :max="10"
          style="width:300px;"
          show-input
          @on-change="checkYear"
        ></Slider>
      </FormItem>
      <FormItem label="价格总计:">
        <div class="u-total-amount">￥{{totalAmount}}</div>
      </FormItem>
      <FormItem>
        <Row :gutter="16">
          <i-col span="8">
            <Button
              type="primary"
              size="large"
              @click="handleSubmit('configForm')"
              :loading="submitIng"
              long
            >提交</Button>
          </i-col>
        </Row>
      </FormItem>
    </Form>
  </div>
</template>
<script>
import axios from "@/libs/api.request";
export default {
  props: {
    pageLoaded: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      comId: null,
      submitIng: false,
      productList: [],
      configInfo: {},
      productAmount: 0,
      timeLong: 1,
      totalAccountNum: 0, //账号总数
      minAccountNum: 0, //设置最低账号数
      accountPrice: 0, //设置单个账号金额
      totalBillNum: 0, //单据量总数
      minBillNum: 0, //设置最低单据量
      billPrice: 0, //设置万个单据金额
      ruleForm: {
        product: [{ required: true, message: "请选择产品类型" }]
      }
    };
  },
  watch: {
    pageLoaded: function(newVal) {
      axios
        .request({
          url: "CustomerConfig/product",
          method: "get"
        })
        .then(res => {
          this.productList = res.data.list;
          this.accountPrice = res.data.accountPrice;
          this.billPrice = res.data.billPrice;
        });
    }
  },
  methods: {
    checkAccount() {
      if (this.totalAccountNum < this.minAccountNum) {
        this.$Message.error("账号数不可小于产品最低配置");
        this.totalAccountNum = this.minAccountNum;
      }
    },
    checkBill() {
      if (this.totalBillNum < this.minBillNum) {
        this.$Message.error("单据数量不可小于产品最低配置");
        this.totalBillNum = this.minBillNum;
      }
    },
    checkYear() {
      if (this.timeLong < 1) {
        this.$Message.error("产品最低需要开通1年");
        this.timeLong = 1;
      }
    },
    selectProduct(index) {
      var newList = this.productList.slice(0);
      var curItem = newList[index];
      newList.forEach((item, i) => {
        item.isSelected = index == i ? true : false;
      });
      this.configInfo.product = curItem.id;
      this.productAmount = curItem.price;
      this.minAccountNum = this.totalAccountNum = parseInt(curItem.account_num);
      this.minBillNum = this.totalBillNum = parseInt(curItem.bill_num);
      this.productList = newList;
    },
    handleSubmit(name) {
      // this.submitIng = true;
      this.configInfo.account_num = this.totalAccountNum - this.minAccountNum;
      this.configInfo.bill_num = this.totalBillNum - this.minBillNum;
      this.configInfo.year_num = this.timeLong;
      this.configInfo.com_id = this.comId;
      if (!this.configInfo.product) {
        this.$Message.error("请选择产品");
        return;
      }
      if (this.configInfo.account_num < 0) {
        this.$Message.error("账号数不可小于产品最低配置");
        this.totalAccountNum = this.minAccountNum;
        return;
      }
      if (this.configInfo.bill_num < 0) {
        this.$Message.error("单据数量不可小于产品最低配置");
        this.totalBillNum = this.minBillNum;
        return;
      }
      axios
        .request({
          url: "CustomerConfig/save",
          data: { ...this.configInfo },
          method: "post"
        })
        .then(res => {
          this.$Message.success("Success!");
          this.$emit("on-success", res.data.info);
          this.submitIng = false;
        });
    },
    handleCancel() {}
  },
  computed: {
    totalAmount() {
      return (
          (this.productAmount * 100 +
          ((this.totalAccountNum - this.minAccountNum) * this.accountPrice * 100) +
          ((this.totalBillNum - this.minBillNum) * this.billPrice * 100)) * this.timeLong /100

      );
    }
  },
  mounted() {
    const comId = parseInt(this.$route.params.comid);
    this.comId = comId;
  }
};
</script>
<style>
.m-pro-list {
  display: flex;
  width: 100%;
}
.m-pro-list .item {
  margin-right: 12px;
  padding: 12px;
  width: 100px;
  line-height: 1.5;
  border: 1px solid #ddd;
  cursor: pointer;
}
.m-pro-list .item:hover {
  border-color: #19be6b;
}
.m-pro-list .item .title {
  font-weight: bold;
}
.price {
  color: #ed4014;
}
.u-total-amount {
  color: #ed4014;
  font-size: 18px;
  font-weight: bold;
}
.m-pro-list .selected {
  border-color: #19be6b;
  background: #19be6b;
  color: #fff;
}
.m-pro-list .selected .price {
  color: #fff;
}
</style>