<template>
  <div class="content-wrap">
    <ModuleCard title="在库“四上”企业" style="min-height: 100%">
      <template v-slot:extra>
        <div class="tips">
          <van-icon name="info-o" />点击各镇数值查看企业情况
        </div>
      </template>

      <div class="m-table table-box">
        <Table size="small" stripe :columns="tableColumn" :data="tableData" :loading="tableLoading" @on-cell-click="handleGoCom" show-summary sum-text="合计" />
      </div>
    </ModuleCard>
  </div>
</template>

<script>
import * as sishangApi from "@/api/sishang.js";
export default {
  data() {
    return {
      tableLoading:true,
      tableColumn: [],
      tableData: [],
    };
  },
  methods: {
    handleGoCom(row, column, data, event) {
      var cate = column.title =="小计"?"全部行业":column.title
      var town = row.town
      if(data == 0) return
      this.$router.push({
        name: "gdp_monitor",
        query: { cate, town },
      });
    },
  },
  mounted() {
    sishangApi.get_total().then((res) => {
      this.tableColumn = res.data.tableColumn;
      this.tableData = res.data.tableData;
      this.tableLoading = false
    });
  },
};
</script>

<style lang="less" scoped>
.m-sishang-wrap {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: flex-start;
  .item {
    margin-bottom: 0.0625rem;
    padding: 0.0625rem;
    width: 31%;
    border: 1px solid rgba(0, 0, 0, 0.05);
    // color:#696969;
    .title {
      font-weight: bold;
    }
    .num {
      font-weight: bold;
    }
  }
}

.tips {
  color: #969696;
}
</style>