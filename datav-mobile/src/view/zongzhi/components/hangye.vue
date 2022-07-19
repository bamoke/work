<!--
 * @Author: Joy wang
 * @Date: 2021-05-31 05:00:41
 * @LastEditTime: 2021-05-31 09:26:34
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
  <div class="content-wrap">
    <div class="item-wrap">
      <ModuleCard title="地区生产总值分行业情况">
        <div class="hangye-wrap">
          <div id="chart-chanye-gross" style="height: 280px"></div>

          <div class="btn-list-wrap">
            <template v-for="(item, index) of comCateList">
              <div class="item" :key="index">
                <div class="hangye-name">{{ item.name }}</div>
                <div class="btn" @click="goHangyeChild(item.name)">
                  查看行业详情<van-icon name="arrow" />
                </div>
                <div class="comcate-btn-box" v-if="item.comCate">
                  <template v-if="Array.isArray(item.comCate)">
                    <div
                      class="btn"
                      v-for="(cate, cateIndex) of item.comCate"
                      :key="cateIndex"
                      @click="goSishangCom(cate)"
                    >
                      {{ cate }}企业<van-icon name="arrow" />
                    </div>
                  </template>
                  <template v-else
                    ><div class="btn" @click="goSishangCom(item.comCate)">
                      查看企业<van-icon name="arrow" /></div
                  ></template>
                </div>
              </div>
            </template>
          </div>
        </div>
      </ModuleCard>
    </div>

    <div class="item-wrap">
      <ModuleCard title="分行业拉动GDP增长(百分点)">
        <div class="item item-long">
          <div id="chart-chanye-gdp" style="height: 280px"></div>
        </div>
      </ModuleCard>
    </div>

    <div class="item-wrap">
      <ModuleCard title="各行业占总计比重">
        <div class="item">
          <div id="chart-chanye-proportion" style="height: 280px"></div>
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
      showChild: false,
      chartData: [],
      comCateList: [],
      echartInstanceGross: null,
      echartInstanceProportion: null,
      echartInstanceGdp: null,
      echartInstanceNongye: null,
      echartInstanceChild: null,
    };
  },
  methods: {
    isArray() {},
    goHangyeChild(name) {
      console.log(name)
      var routerName = "gdp_hangye_child"
      if(name =='工业') {
        routerName = 'gongye_zjz'
        this.$router.push({name:'gongye_zjz'});
      }else if(name == '批发和零售业' || name == '住宿和餐饮业') {
        this.$router.push({name:'gdp_hangye_child_multiple',query:{cate:name}});
      }else {
        this.$router.push({name:'gdp_hangye_child',query:{cate:name}});
      }
    },
    goSishangCom(name) {
      this.$router.push({name:'gdp_monitor',query:{cate:name,town:'金湾区'}});
    },
    nimabi() {
      const _that = this;
      this.echartInstanceGross.setOption({
        dataset: { source: this.chartData },
        grid: {
          top: 40,
          left: 60,
          right: 60,
          bottom: 80,
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        xAxis: {
          type: "category",
          triggerEvent: true,
          axisLabel: {
            fontSize: "12px",
            // rotate: -45,
            formatter: function (value) {
              return formatStringWrap(value, 3);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: "{value}",
            },
            splitLine: {
              show: true,
            },
          },
          {
            type: "value",
            axisLabel: {
              formatter: "{value}" + "%",
            },
            splitLine: {
              show: true,
            },
          },
        ],
        series: [
          {
            type: "bar",
            showBackground: true,
          },
          {
            type: "line",
            yAxisIndex: 1,
          },
        ],
      });

      // gross chart evets
      // this.echartInstanceGross.on("click", "xAxis", (params) => {
      //   let cate = params.value;
      //   this.hanleShowChildCate(cate);
      // });

      // proportion bizhong

      this.echartInstanceProportion.setOption({
        dataset: { source: this.chartData },
        tooltip: {
          trigger: "item",
        },
        legend: {
          show: true,
          left: "right",
          top: "top",
          orient: "vertical",
        },

        series: [
          {
            type: "pie",
            radius: ["0", "70%"],
            center: ["40%", "50%"],
            label: {
              show: true,
              formatter: "{b}\n占比:{d}%",
            },
            labelLine: {
              show: true,
            },
          },
        ],
      });

      //

      this.echartInstanceGdp.setOption({
        dataset: { source: this.chartData },

        grid: {
          top: 40,
          left: 60,
          right: 20,
          bottom: 80,
        },
        tooltip: { trigger: "axis" },
        legend: {
          show: true,
          left: "right",
          top: "top",
        },
        xAxis: {
          type: "category",
          axisLabel: {
            // rotate: -45,
            formatter: function (value) {
              return formatStringWrap(value, 4);
            },
          },
        },
        yAxis: [
          {
            type: "value",
            axisLabel: {
              formatter: "{value}",
            },
            splitLine: {
              show: true,
            },
          },
        ],
        series: [
          {
            name: "百分点",
            type: "bar",
            showBackground: true,
            label: {
              show: true,
              position: "top",
            },
            encode: {
              x: 0,
              y: 5,
            },
          },
        ],
      });
    },
  },

  mounted() {
    const echart = this.$echarts;
    this.echartInstanceGross = echart.init(
      document.getElementById("chart-chanye-gross"),
      this.$config.chartTheme
    );

    this.echartInstanceProportion = echart.init(
      document.getElementById("chart-chanye-proportion"),
      this.$config.chartTheme
    );

    this.echartInstanceGdp = echart.init(
      document.getElementById("chart-chanye-gdp"),
      this.$config.chartTheme
    );

    ///
    Api.base.get_gdp_hangye({ cate: "按行业" }).then((res) => {
      this.chartData = res.data.list;
      this.comCateList = res.data.comCate;
      this.nimabi();
    });
  },
};
</script>

<style lang="less" scoped>
.hangye-wrap {
  width: 100%;

  .item {
    margin-bottom: 0.0625rem;
    flex: 0 0 auto;
    width: 50%;

    .section {
      font-size: 18px;
    }
  }
  .item-long {
    width: 100%;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  }
}

.btn-list-wrap {
  display: flex;
  flex-wrap: wrap;
  align-items: flex-start;
  padding-bottom: 0.041667rem;
  border-top: 1px solid #e8e8e8;
  .btn-bar {
    color: #000;
  }
  .item {
    padding-top: 0.0625rem;
    width: 20%;
    line-height: 1;
    .hangye-name {
      margin-bottom: 8px;
      font-weight: bold;
    }
    .btn {
      cursor: pointer;
    }
    .btn:hover {
      text-decoration: underline;
      color: #1989fa;
    }
    .comcate-btn-box {
      margin-top: 8px;
      display: flex;
      .btn {
        margin-right: 0.0625rem;
      }
    }
  }
}
</style>
