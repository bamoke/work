<template>
  <div>
    <Row :gutter="32">
      <Col span="12">
        <CellGroup>
          <Cell title="产品名称" v-bind:extra="configInfo.productName" />
          <Cell title="功能模块">
            <Button size="small" type="primary" ghost slot="extra" @click="showModule=true">查看详情</Button>
          </Cell>
          <Cell title="账号数">
            <Badge type="info" :count="configInfo.accountNum" slot="extra" />
          </Cell>
        </CellGroup>
      </Col>
      <Col span="12">
        <CellGroup>
          <Cell title="开通日期">
            <div slot="extra" class>{{configInfo.product_start}}</div>
          </Cell>
          <Cell title="到期日期">
            <div slot="extra" class>{{configInfo.product_deadline}}</div>
          </Cell>
        </CellGroup>
      </Col>
    </Row>
    <Divider />
    <div>
      <Button type="success" size="large" style="width:120px;margin-right:20px;">续费</Button>
      <Button type="primary" size="large" style="width:120px;">升级</Button>
    </div>
    <Drawer title="功能模块" :closable="false" v-model="showModule" width="400">
      <Tree :data="configInfo.module"></Tree>
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
      configInfo: {},
      showModule: false
    };
  },
  watch: {
    configId: function(newVal) {}
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