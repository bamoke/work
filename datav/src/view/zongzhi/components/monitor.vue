<!--
 * @Author: Joy wang
 * @Date: 2021-05-31 05:00:41
 * @LastEditTime: 2021-06-01 02:36:16
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="wrap">
    <div class="top-bar">
      <div style="width:440px">
        <div class="title">{{ title }}</div>
        <div class="tips" v-if="tips">{{ tips }}</div>
      </div>
      <div class="search-box">
        <Icon type="ios-search" :size="18" color="rgba(255,255,255,.6)" />
        <input class="input" maxlength="24" v-model="keyword" placeholder="搜素过滤" type="text"/>
      </div>
    </div>
    <div class="table-wrap">
      <Table size="small" stripe :columns="tableColumn" :data="tableData" />
    </div>
  </div>
</template>

<script>
import * as MonitorApi from "@/api/monitor";
export default {
  data() {
    return {
      title: "",
      tips: "",
      tableColumn: [],
      tableData: [],
      originTableData:[],
      keyword:""
    };
  },
  methods: {},
  watch:{
    keyword(newValue){
      var regex = new RegExp(newValue)
      var data = this.originTableData.filter(function(item){
        return regex.test(item.title)
      })
      this.tableData = data
    }
  },

  mounted() {
    ///
    MonitorApi.get_data({ params: { table: "default" } }).then((res) => {
      var tableColumn = [];
      this.title = res.title;
      this.tips = res.tips;
      this.tableData = this.originTableData = res.data;
      var tempItem = {};
      for (var i in res.column) {
        tempItem = {
          title: res.column[i],
          key: i,
        };
        if (i == "title") {
          tempItem.width = 300;
        }
        if (i == "gross" || i == "rise") {
          tempItem.sortable = true;
        }
        tableColumn.push(tempItem);
      }
      this.tableColumn = tableColumn;
    });
  },
};
</script>

<style lang="less" scoped>


.wrap {
  width: 1200px;
  .table-wrap {
    height: 440px;
    overflow-y: auto;
  }
  .top-bar {
    display: flex;
    align-items: flex-start;
    .search-box {
      display: flex;
      align-items: center;
      padding:0 18px 0 6px;
      width:320px;
      height:36px;
      border-radius: 18px;
      border:1px solid rgba(255, 255, 255, 1);
      .input {
        padding-left:6px;
        width:100%;
        height: 36px;
        line-height: 36px;
        border:none;
        background-color:transparent;
        outline: none;
        color:#fff;
      }
      .input::placeholder {
        color:rgba(255, 255, 255, 0.6)
      }
    }
  }
  .title {
    margin-bottom: 12px;
    text-align: left;
    color: #fff;
    font-size: 24px;
  }
  .tips {
    margin-bottom: 12px;
    text-align: left;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.6);
  }
}
</style>
