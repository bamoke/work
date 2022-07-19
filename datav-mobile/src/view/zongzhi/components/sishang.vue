<template>
  <div class="content-wrap">
    <ModuleCard title="在库“四上”企业" style="min-height: 100%">
      <template v-slot:extra>
        <div class="tips">
          <van-icon name="info-o" />点击各镇数值查看企业情况
        </div>
      </template>

      <div class="m-sishang-box">
        <div class="item" v-for="(item, index) of list" :key="index">
          <div class="cate-box">
            <van-icon name="wap-nav" />
            <span class="cate-name">{{ item.name }}</span>
            <span class="cate-total">
              (<span class="subtext">企业数:</span
              ><span class="num">{{ item.total }}</span
              >)
            </span>
          </div>
          <div class="town-box">
            <div
              class="town-item"
              v-for="(town, i) of item.town"
              :key="i"
              @click="handleGoCom(item.name, town.name)"
            >
              <div>
                <span class="town-name">{{ town.name }}:</span>
                <span class="town-total">{{ town.total }}</span>
              </div>
              <div class="viewmore">查看企业</div>
            </div>
          </div>
        </div>
      </div>
    </ModuleCard>
  </div>
</template>

<script>
import * as sishangApi from "@/api/sishang.js";
export default {
  data() {
    return {
      list: [],
    };
  },
  methods: {
    handleGoCom(cate, town) {
      this.$router.push({
        name: "gdp_monitor",
        query: { cate, town },
      });
    },
  },
  mounted() {
    sishangApi.get_total().then((res) => {
      this.list = res.data.list;
    });
  },
};
</script>

<style lang="less" scoped>
.m-sishang-box {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: flex-start;
  .item {
    margin-bottom: 0.0625rem;
    padding: 0.0625rem;
    width: 48%;
    // border: 1px solid rgba(0, 0, 0, 0.05);
    background: #edf5fb;
    // box-shadow: 0 2px 2px rgba(0,0,0,.1);
    .cate-box {
      display: flex;
      // justify-content: space-between;
      align-items: center;
      // margin-bottom:.03125rem;
      padding-bottom: 0.0625rem;
      line-height: 1;
      // border-bottom:1px solid #e8e8e8;
      .cate-name {
        margin:0 4px;
        font-weight: bold;
      }
      .cate-total {
        .num {
          font-weight: bold;
        }
        .subtext {
          color: #969696;
          font-size: 11px;
        }
      }
    }
    .town-box {
      display: flex;
      justify-content: space-between;
      align-items: center;
      line-height: 1;
      .town-item {
        width: 25%;
        padding-left: 0.0625rem;
        // text-align: center;
        border-left: 1px solid #e8e8e8;
        color: #696969;
        cursor: pointer;
        .town-total {
          margin-bottom: 6px;
          font-weight: bold;
        }
        .viewmore {
          margin-top: 0.03125rem;
          font-size: 10px;
          // color: #969696;
          text-decoration: underline;
        }

      }
      .town-item:first-child {
        padding-left: 0;
        border-left: none;
      }
      .town-item:hover {
         color:#1989fa;
      }
    }
  }
}

.tips {
  color: #969696;
}
</style>