<template>
  <div class="content-wrap">
    <ModuleCard title="四上企业" style="min-height: 100%">
      <template v-slot:extra>
        <div class="tips">
          <van-icon name="info-o" />点击数值查看企业统计情况
        </div>
      </template>
      <div class="m-sishang-wrap" style="display: none">
        <div class="item" v-for="(item, index) in data" :key="index">
          <div></div>
          <div class="title">{{ item.title }}</div>
          <div class="num-box">
            <span>企业数量:</span><span class="num">{{ item.num }}</span>
          </div>
        </div>
      </div>
      <div class="m-table table-box">
        <table border="0" cellpadding="0" cellspacing="0" class="m-table">
          <tr>
            <th>区/街镇</th>
            <th>小计</th>
            <th>工业</th>
            <th>建筑业</th>
            <th>批发零售业</th>
            <th>住宿餐饮业</th>
            <th>重点服务业</th>
            <th>房地产业</th>
          </tr>
          <tr v-for="(item,index) in tableData" :key="index">
            <td>{{item.title}}</td>
            <td @click="handleGoCom(item.title,'')">{{item.total}}</td>
            <td @click="handleGoCom(item.title,'gy')">{{item.gy}}</td>
            <td @click="handleGoCom(item.title,'jzy')">{{item.jzy}}</td>
            <td @click="handleGoCom(item.title,'pflsy')">{{item.pflsy}}</td>
            <td @click="handleGoCom(item.title,'zscyy')">{{item.zscyy}}</td>
            <td @click="handleGoCom(item.title,'zdfwy')">{{item.zdfwy}}</td>
            <td @click="handleGoCom(item.title,'fdcy')">{{item.fdcy}}</td>
          </tr>
        </table>
      </div>
    </ModuleCard>
  </div>
</template>

<script>
export default {
  data() {
    return {
      total: 1010,
      data: [
        {
          title: "工业",
          num: 569,
        },
        {
          title: "建筑业",
          num: 42,
        },
        {
          title: "批发零售业",
          num: 141,
        },
        {
          title: "住宿餐饮业",
          num: 37,
        },
        {
          title: "重点服务业",
          num: 123,
        },
        {
          title: "房地产业",
          num: 93,
        },
      ],
      tableData: [
        {
          title: "金湾区",
          total: 1010,
          gy: 527,
          jzy: 43,
          pflsy: 141,
          zscyy: 37,
          zdfwy: 123,
          fdcy: 94,
        },
        {
          title: "三灶",
          total: 344,
          gy: 12,
          jzy: 124,
          pflsy: 24,
          zscyy: 15,
          zdfwy: 62,
          fdcy: 27,
        },
        {
          title: "红旗",
          total: 344,
          gy: 12,
          jzy: 124,
          pflsy: 24,
          zscyy: 15,
          zdfwy: 42,
          fdcy: 27,
        },
        {
          title: "南水",
          total: 344,
          gy: 12,
          jzy: 124,
          pflsy: 24,
          zscyy: 15,
          zdfwy: 42,
          fdcy: 34,
        },
        {
          title: "平沙",
          total: 344,
          gy: 12,
          jzy: 124,
          pflsy: 24,
          zscyy: 15,
          zdfwy: 42,
          fdcy: 29,
        },
      ],
    };
  },
  methods: {
    handleGoCom(area,trade) {
      this.$router.push({
        name:"gdp_monitor",
        query:{area,trade}
      })
    }
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