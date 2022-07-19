<!--
 * @Author: Joy wang
 * @Date: 2021-06-01 06:40:42
 * @LastEditTime: 2021-06-02 04:33:37
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <ModuleCard title="重点企业经营情况" style="min-height: 100%">
      <template v-slot:extra>
        <!-- <router-link :to="{name:'gdp_company_map'}">地图中查看</router-link> -->
      </template>
      <div class="search-bar">
        <div class="item">
          <div class="section">按行业:</div>
          <select>
            <option value="">全部</option>
          </select>
        </div>
        <div class="item">
          <div class="section">关键字:</div>
          <input type="text" placeholder="请输入公司名称" />
        </div>
        <div class="item">
          <van-button type="info" size="small" style="width:100px;">搜索</van-button>
        </div>
      </div>
      <div class="total-bar">
        总计:<strong>{{pageInfo.total}}</strong>
      </div>
      <div class="m-table table-box">
        <table border="0" cellpadding="0" cellspacing="0" class="m-table">
          <tr>
            <th>企业名称</th>
            <th>行业</th>
            <th>累计</th>
            <th>同比增长</th>
            <th>用电量</th>
            <th>同比增长</th>
            <th>增加值率</th>
            <th>情况说明</th>
          </tr>
          <tr v-for="(item, index) in tableData" :key="index">
            <td>{{ item.title }}</td>
            <td>{{ item.industry }}</td>
            <td>{{ item.gross }}</td>
            <td>{{ item.rise }}</td>
            <td>{{ item.electric_gross }}</td>
            <td>{{ item.electric_rise }}</td>
            <td>{{ item.zjzl }}</td>
            <td @click="handleShowDetail(index)">
              查看<van-icon name="arrow" />
            </td>
          </tr>
        </table>
      </div>
    </ModuleCard>
  </div>
</template>


<script>
// import { loadBaiDuMap } from "@/libs/baidumap_gl";
import * as enterprisesApi from "@/api/enterprises";

export default {
  components: {},

  data() {
    return {
      keyword: "",
      curCompany: {},
      tableColumn: {},
      tableData: [],
      pageInfo:{}
    };
  },

  watch: {
    keyword(newValue) {
      if (newValue === "") {
        this.comList = [];
        return;
      }
      var regex = new RegExp(newValue);
      var data = this.originData.filter(function (item) {
        return regex.test(item.title);
      });
      this.comList = data;
    },
  },
  methods: {
    handleShowDetail(index) {
      console.log(index)
    },

    handleGoback() {
      this.$router.back();
    },
  },
  mounted() {
    // 数据获取
    enterprisesApi.get_list().then((res) => {
      this.tableData = res.data;
      this.pageInfo = res.pageInfo
      // this.originData = this.comList = this.transformGeo(res.data);
    });

    // 获取数据
  },
  created() {},
};
</script>

<style lang="less" scoped>

.search-bar {
  display: flex;
  align-items: center;
  padding-bottom:.083333rem;
  width: 100%;
  .item {
    margin-right:12px;
    display: flex;
    align-items: center;
  }
  .input {
    padding-left: 6px;
    width: 100%;
    height: 32px;
    line-height: 32px;
    border: none;
    background-color: transparent;
    outline: none;
    color: #fff;
  }
  .input::placeholder {
    color: rgba(255, 255, 255, 0.8);
  }
}
.total-bar {
  padding-bottom:6px;
}
//***/
.ivu-spin-fix {
  background: rgba(0, 0, 0, 0.6);
}
.demo-spin-icon-load {
  animation: ani-demo-spin 1s linear infinite;
}
@keyframes ani-demo-spin {
  from {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(180deg);
  }
  to {
    transform: rotate(360deg);
  }
}

//
.control-box {
  position: absolute;
  left: 50%;
  bottom: 5%;
  z-index: 990;
  margin-left: -160px;
  width: 320px;
  opacity: 0;
  transform: translate(0px, 60px);
  transition: all 0.3s;
}
.back-btn {
  background: rgba(0, 0, 0, 0.6);
  width: 320px;
  height: 48px;
  line-height: 48px;
  border-radius: 24px;
  font-size: 18px;
  text-align: center;
  cursor: pointer;
  color: #fff;
  transition: opacity 0.2s;
}
.back-btn:hover {
  opacity: 0.8;
}
</style>