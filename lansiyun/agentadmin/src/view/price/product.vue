<template>
  <Card title="产品价格">
    <div class="row">
      <div class="item" v-for="(item, index) of list" :key="index">
        <div class="name">{{item.title}}</div>
        <div class="desc s-text-light">{{item.description}}</div>
        <div class="price">
          价格：
          <span class="sell-price">{{item.price}}</span>
        </div>
        <div class="price">
          销售数量：
          <span class="s-text-light">0</span>
        </div>
      </div>
    </div>
  </Card>
</template>
<script>
import axios from "@/libs/api.request";
export default {
  data() {
    return {
      list: [],
      editIndex: 0,
      editForm: {},
      showModal: false,
      submitting: false
    };
  },
  methods: {
    handleSetPrice(index) {
      var curItem = Object.assign({}, this.list[index]);
      this.editIndex = index;
      this.editForm = curItem;
      this.showModal = true;
      // console.log(this.editForm)
    },
    doSave() {
      const newPrice = this.editForm.new_price;
      if (!newPrice) {
        this.$Message.error("请输入销售价格");
        return;
      }
      this.submitting = true;
      axios
        .request({
          url: "Price/dosave",
          data: { actype: 1, ...this.editForm },
          method: "post"
        })
        .then(
          res => {
            this.submitting = false;
            this.showModal = false;
            if (res.data.priceid) {
              this.editForm.price_id = res.data.priceid;
            }
            this.$set(this.list, this.editIndex, this.editForm);
          },
          reject => {
            this.submitting = false;
            this.showModal = false;
          }
        );
    }
  },
  mounted() {
    axios
      .request({
        url: "Price/product",
        method: "get"
      })
      .then(res => {
        this.list = res.data.list;
      });
  }
};
</script>
<style>
.row {
  display: flex;
  flex-wrap: wrap;
  flex-direction: row;
  justify-content: space-between;
}

.row .item {
  padding: 20px;
  width: 25%;
  border: 1px solid #ddd;
  cursor: pointer;
}
.row .item .name {
  font-size: 16px;
  font-weight: bold;
}
.row .item .desc {
  padding: 12px 0;
}
.row .item .sell-price {
  font-size: 16px;
  color: #ed4014;
}
.btn-box {
  padding-top: 20px;
}
</style>