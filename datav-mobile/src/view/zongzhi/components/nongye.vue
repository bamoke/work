<!--
 * @Author: Joy wang
 * @Date: 2021-05-31 05:00:41
 * @LastEditTime: 2021-05-31 09:05:17
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
      <div class="item-wrap">
        <ModuleCard title="农业相关指标完成情况">
          <template v-slot:extra><van-icon name="info-o" />模拟数据</template>
          <div class="" style="height: 260px">
            <BmkTable :columns="tableColumn" :data="tableData" />
          </div>
        </ModuleCard>
      </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import { formatStringWrap } from "@/libs/tools.js";
export default {
  data() {
    return {
      activeClass: "show-chart",
      zczTableColumn: ["指标名称", "总量", "同比(%)"],
      zczTableData: [],
      nongyeData: {},
      tableColumn: ["指标名称", "单位", "总量", "同比(%)"],
      tableData: [
        ["粮食作物播种面积", "亩", 5282, 78.6],
        ["粮食总产量", "吨", 2204, 58.4],
        ["蔬菜播种面积", "亩", 40167, 8.0],
        ["蔬菜产量", "吨", 45688, 3.2],
        ["园林水果产量", "吨", 76119, 4.9],
        ["水产品产量", "吨", 48991, 0.4],
      ],
    };
  },
  methods: {
    handleChangeMode(e) {
      this.nongyeData.mode = e;
      if (e == "table") {
        this.activeClass = "show-table";
        // this.drawEchart();
      } else {
        this.activeClass = "show-chart";
      }
    },
  },

  mounted() {

  },
};
</script>

<style lang="less" scoped>
.industry-wrap {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  color: #fff;
  .item {
    flex: 0 0 auto;
    margin-bottom: 24px;
    width: 49.75%;
    .section {
      font-size: 18px;
    }
  }
}
</style>
