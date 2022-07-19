<template>
  <div>
    <Card>
      <div slot="title">数据上传管理</div>
      <div class="m-table-list">
        <div class="item" v-for="(item, index) of tableList" :key="item.key">
          <div class="title">{{ item.name }}</div>
          <div class="date">数据所属月份：{{ item.date }}</div>
          <div class="operation">
            <Button icon="md-download" @click="handleDownload(index)">下载模板</Button>
            <Button icon="md-cloud-upload" @click="showModal=true">上传数据</Button>
          </div>
        </div>
      </div>
    </Card>
    <Modal ref="userform-modal" v-model="showModal" draggable scrollable>
      <p slot="header" style="text-align: left">
        <Icon type="ios-compose" size="18"></Icon>
        <span>数据上传</span>
      </p>
      <Upload
        name="file"
        type="drag"
        :action="uploadUrl"
      >
        <div style="padding: 20px 0">
          <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
          <p>请选择对应的数据表格</p>
        </div>
      </Upload>
      <p slot="footer"></p>
    </Modal>
  </div>
</template>

<script>
import axios from "@/libs/api.request";

export default {
  name: "",
  props: {},
  data() {
    return {
      uploadUrl:"/datav-backend/admin.php/Upload/upload",
      showModal: false,
      tableList: [],
    };
  },
  methods: {
    handleDownload(index){
      const item = this.tableList[index]
      window.open('/datav-backend/Uploads/datatemplate/'+item.name+'.xlsx')
    }
  },
  computed: {},
  mounted() {
    axios
      .request({
        url: "DataTable/getlist",
      })
      .then((res) => {
        this.tableList = res.data.list;
      });
  },
};
</script>

<style lang="less">
.m-table-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  .item {
    margin-bottom: 12px;
    padding: 16px;
    width: 22%;
    border: 1px solid #e8e8e8;
    line-height: 1;
    .title {
      font-weight: bold;
    }
    .date {
      padding: 12px 0;
    }
    .operation {
      display: flex;
      justify-content: space-between;
    }
  }
}
</style>