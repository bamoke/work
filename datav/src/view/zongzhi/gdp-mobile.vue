<!--
 * @Author: Joy wang
 * @Date: 2021-05-17 02:45:06
 * @LastEditTime: 2021-06-01 02:59:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="m-base-total">
      <div class="item">
        <div class="section">总值(亿)</div>
        <div class="val">837465</div>
      </div>
      <div class="item">
        <div class="section">同比增长</div>
        <div class="val">120%</div>
      </div>
    </div>
    <div class="m-child-nav-box">
      <router-link :to="{ name: 'gdp_chanye' }" class="child-nav-item">
        <div class="nav-name">按产业情况</div>
      </router-link>
      <router-link :to="{ name: 'gdp_hangye' }" class="child-nav-item">
        <div class="nav-name">按行业情况</div>
      </router-link>
      <router-link :to="{ name: 'gdp_company' }" class="child-nav-item">
        <div class="nav-name">重点企业经营情况</div>
      </router-link>
    </div>

    
    <div>
      <ModuleCard title="各区地区生产总值比较" class="item-wrap">
        <template v-slot:extra>
          <ButtonGroup size="small">
            <Button type="primary" @click="handleChangeCompareCounty('gross')"
              >总值</Button
            >
            <Button @click="handleChangeCompareCounty('rise')">增长率</Button>
          </ButtonGroup>
        </template>
        <ChartCompareCounty
          :height="200"
          :mode="compareCountyData.mode"
          :title="compareCountyData.title"
          :chart-data="compareCountyData.data"
        ></ChartCompareCounty>
      </ModuleCard>

      <ModuleCard title="国内部分区域地区生产总值比较" class="item-wrap">
        <ChartCompareDomestic
          :height="200"
          :title="compareDomesticData.title"
          :chart-data="compareDomesticData.data"
        ></ChartCompareDomestic>
      </ModuleCard>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
import { formatStringWrap } from "@/libs/tools.js";
import chartMixin from "@/libs/chart-mixin.js";

export default {
  mixins: [chartMixin],
  components: {},
  data() {
    return {
      sliderIndex: 0,
      totalInfo: {
        all: {
          title: "金湾区",
          num: 155.45,
          measure: "亿元",
          rise: 20.1,
        },
        zhishu: {
          title: "金湾直属",
          num: 73.18,
          measure: "亿元",
          rise: 25.4,
        },
        kaifaqu: {
          title: "经济开发区",
          num: 82.26,
          measure: "亿元",
          rise: 20.7,
        },
      },
      baseData: {},
      echartInstance: {},
      monitorTableList: [
        "工业企业产值监测表",
        "限额以上批发企业统计监测表",
        "限额以上零售业企业统计监测表",
        "限额以上住宿业企业统计监测表",
        "限额以上餐饮业企业统计监测表",
        "规模以上服务业企业统计监测表",
        "建筑业企业产值统计监测表",
        "房地产开发企业销售情况统计监测表",
      ],
      propertyTableList: [],
      showModal: false,
      modalTitle: "地区总产值按产业情况",
      showChild: "",
    };
  },
  methods: {
    handleShowMonitor(tableName) {
      this.$router.push({ name: "gdp_monitor", query: { table: tableName } });
    },
    openChild(title, moduleName) {
      this.showModal = true;
      this.modalTitle = title;
      this.showChild = moduleName;
    },
  },
  mounted() {
    var chartName = [];
    this.chartInit({ chartName });

    /***指标对比 */
    Api.jjzb.get_county().then((res) => {
      this.compareCountyData = {
        mode: "gross",
        title: {},
        data: res.data,
      };
    });

    /*** 国内部分区域指标 */
    Api.jjzb.get_domestic().then((res) => {
      this.compareDomesticData = {
        title: {
          text: res.title,
        },
        data: res.data,
      };
    });

    /***按月 累计增长率 */
    Api.timeline.get_monthdata().then((res) => {
      this.leijizengzhangData = {
        title: {
          text: "2020年3-2021年3月",
        },
        data: res.data,
      };
    });

    /*** 年度数据 */
    Api.timeline.get_yeardata({ params: { cate: "gdp" } }).then((res) => {
      this.timelineYearData = {
        title: {
          text: res.title,
        },
        mode: "gross",
        data: res.data,
        origin: res.data,
      };
    });
  },
};
</script>

<style lang="less" scoped>
.content-wrap {
}

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
}
</style>
