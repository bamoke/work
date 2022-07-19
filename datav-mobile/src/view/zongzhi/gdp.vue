<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:45:06
 * @LastEditTime: 2021-06-01 02:59:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div style="width: 100%; height: 100%">
    <div class="m-child-nav-box">
      <router-link :to="{ name: 'gdp_gross' }" class="child-nav-item">
        <div class="nav-name">总量及增长率</div>
      </router-link>
      <router-link :to="{ name: 'gdp_sishang' }" class="child-nav-item">
        <div class="nav-name">四上企业</div>
      </router-link>

      <router-link :to="{ name: 'gdp_chanye' }" class="child-nav-item">
        <div class="nav-name">按产业情况</div>
      </router-link>
      <router-link :to="{ name: 'gdp_hangye' }" class="child-nav-item">
        <div class="nav-name">按行业情况</div>
      </router-link>
      <router-link :to="{ name: 'gdp_company' }" class="child-nav-item">
        <div class="nav-name">重点企业情况</div>
      </router-link>
 
    </div>
    <router-view></router-view>
  </div>
</template>

<script>


export default {
  components: {},
  data() {
    return {

    };
  },
  methods: {

  },
  mounted() {
    
  },
};
</script>

<style lang="less" scoped>
.item-wrap {
  margin-bottom: 0.083333rem;
}

#chart-timelineyear {
  height: 1.666667rem;
}
.chart-cate-height {
  height: 1.666667rem;
}

/** */
.m-shujujiance {
  .item {
    padding: 0 0.125rem;
    height: 0.1875rem;
    line-height: 0.1875rem;
    text-align: left;
    cursor: pointer;
  }
  .item:nth-child(2n + 1) {
    background-color: rgba(180, 180, 180, 0.1);
  }
}

.m-base-total {
  display: flex;
  justify-content: space-between;
  .item {
    box-sizing: border-box;
    flex: 0 0 auto;
    padding: 0.0625rem;
    width: 49.25%;
    display: flex;
    align-items: center;
    background: #fff;
    line-height: 1;
    .icon {
      flex: 0 0 auto;
      margin-right: 12px;
    }
  }
  // .item-gross {
  //   color:#0066ff;
  // }
  //   .item-rise {
  //   color:#dd2416;
  // }
  .val {
    margin-top: 8px;
    font-weight: 500;
    font-size: 24px;
    font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
  }
}
.m-content-row .item-wrap {
  flex: 0 0 auto;
  width: 49.25%;
}
</style>
