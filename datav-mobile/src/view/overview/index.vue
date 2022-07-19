<template>
  <div class="overview-wrap">
    <HeadBar></HeadBar>

    <div class="tab-wrap">
      <div class="tab-card">
        <div
          class="item"
          :class="[{ active: activeTab == 'jinwan' }]"
          @click="activeTab = 'jinwan'"
        >
          金湾区
        </div>
        <div
          class="item"
          :class="[{ active: activeTab == 'town' }]"
          @click="activeTab = 'town'"
        >
          各镇
        </div>
        <div
          class="item"
          :class="[{ active: activeTab == 'county' }]"
          @click="activeTab = 'county'"
        >
          珠海市各区
        </div>
        <div
          class="item"
          :class="[{ active: activeTab == 'country' }]"
          @click="activeTab = 'country'"
        >
          全国、广东省、珠海市
        </div>
      </div>

      <!--tab content--->
      <div class="tab-content">
        <div class="tab-content-item" v-show="activeTab == 'jinwan'">
          <div class="enocomy-introduce-box">
            <div class="item-bar">
              <span class="title-text">经济运行简况</span>
            </div>
            <div class="enocomy-introduce-preface">
              摘要：{{ economyIntroduce.preface }}
            </div>
            <div class="enocomy-introduce-content" v-show="showIntroduceDetail" v-html="economyIntroduce.content"></div>
            <div class="open-btn" @click="showEconomyIntroduceDetail">
              {{showIntroduceDetail?'收起':'展开'}}<van-icon name="arrow-down" class="icon" />
            </div>
          </div>

          <div class="item-bar">
            <span class="title-text">主要经济指标</span>
          </div>
          <div class="list-wrap">
            <div class="item" v-for="(item, index) of totalInfo" :key="index">
              <div class="l-row">
                <van-icon :name="item.icon" class="icon" :size="64" />
                <div class="info">
                  <div class="title">
                    {{ item.title
                    }}<span class="subtext">({{ item.measure }})</span>
                  </div>
                  <div class="top-box">
                    <div class="gross">
                      <span class="subtxt">总量:</span>{{ item.gross }}
                    </div>
                    <div class="rise">
                      <span class="subtxt">同比:</span
                      ><Trend
                        :size="14"
                        :rate="item.rise"
                        v-if="item.rise"
                      ></Trend
                      ><span class="subtxt" v-else>--</span>
                    </div>
                  </div>
                  <div class="two-year-data-box" v-if="item.before_last_rise">
                    <div>
                      <span class="subtxt">比{{ twoYearName }}年同期:</span
                      ><Trend :size="12" :rate="item.before_last_rise"></Trend>
                    </div>
                    <div>
                      <span class="subtxt">两年平均:</span
                      ><Trend :size="12" :rate="item.two_year_rise"></Trend>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!---各镇-->
        <div class="county-wrap" v-show="activeTab == 'town'">
          <div class="title-box">
            <div class="title-bar">
              <van-icon name="wap-nav" /><span style="margin-left: 4px"
                >指标名称</span
              >
            </div>
            <div class="title-list">
              <div
                class="title-item"
                :class="[{ active: curTownDataIndex == index }]"
                v-for="(item, index) of townData"
                :key="index"
                @click="showTownTableData(index)"
              >
                <div>
                  {{ item.title }}
                </div>
                <van-icon name="arrow" class="icon" />
              </div>
            </div>
          </div>
          <div class="table-box">
            <div class="economy-card">
              <div class="title">
                {{ selectedTownData.title
                }}<span class="subtext">({{ selectedTownData.measure }})</span>
              </div>
              <div class="town-wrap">
                <div class="town-item">
                  <div class="town-name">三灶镇</div>
                  <div class="gross">
                    <span class="subtxt">总量:</span
                    >{{ selectedTownData.sz_gross }}
                  </div>
                  <div class="rise">
                    <span class="subtxt">同比:</span
                    ><Trend
                      :size="12"
                      :rate="selectedTownData.sz_rise"
                      v-if="selectedTownData.sz_rise"
                    ></Trend
                    ><span class="subtxt" v-else>--</span>
                  </div>
                </div>
                <div class="town-item">
                  <div class="town-name">红旗镇</div>
                  <div class="gross">
                    <span class="subtxt">总量:</span
                    >{{ selectedTownData.hq_gross }}
                  </div>
                  <div class="rise">
                    <span class="subtxt">同比:</span
                    ><Trend
                      :size="12"
                      :rate="selectedTownData.hq_rise"
                      v-if="selectedTownData.hq_rise"
                    ></Trend
                    ><span class="subtxt" v-else>--</span>
                  </div>
                </div>
                <div class="town-item">
                  <div class="town-name">南水镇</div>
                  <div class="gross">
                    <span class="subtxt">总量:</span
                    >{{ selectedTownData.ns_gross }}
                  </div>
                  <div class="rise">
                    <span class="subtxt">同比:</span
                    ><Trend
                      :size="12"
                      :rate="selectedTownData.ns_rise"
                      v-if="selectedTownData.ns_rise"
                    ></Trend
                    ><span class="subtxt" v-else>--</span>
                  </div>
                </div>

                <div class="town-item">
                  <div class="town-name">平沙镇</div>
                  <div class="gross">
                    <span class="subtxt">总量:</span
                    >{{ selectedTownData.ps_gross }}
                  </div>
                  <div class="rise">
                    <span class="subtxt">同比:</span
                    ><Trend
                      :size="12"
                      :rate="selectedTownData.ps_rise"
                      v-if="selectedTownData.ps_rise"
                    ></Trend
                    ><span class="subtxt" v-else>--</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="county-wrap" v-show="activeTab == 'county'">
          <div class="title-box">
            <div class="title-bar">
              <van-icon name="wap-nav" /><span style="margin-left: 4px"
                >指标名称</span
              >
            </div>
            <div class="title-list">
              <div
                class="title-item"
                :class="[{ active: curCountyDataIndex == index }]"
                v-for="(item, index) of countyData"
                :key="index"
                @click="showCountyTableData(index)"
              >
                <div>
                  {{ item.title }}
                </div>
                <van-icon name="arrow" class="icon" />
              </div>
            </div>
          </div>
          <div class="table-box">
            <div class="selectd-info">
              <van-icon name="description" size="14" /><span class="title"
                >各区{{ selectedCountyData.title }}情况</span
              ><span class="measure"
                >(单位:{{ selectedCountyData.measure }})</span
              >
            </div>
            <Table
              size="small"
              stripe
              :columns="countyColumns"
              :data="selectedCountyData.child"
            />
          </div>
        </div>
        <div class="county-wrap" v-show="activeTab == 'country'">
          <div class="title-box">
            <div class="title-bar">
              <van-icon name="wap-nav" /><span style="margin-left: 4px"
                >指标名称</span
              >
            </div>
            <div class="title-list">
              <div
                class="title-item"
                :class="[{ active: curCountryDataIndex == index }]"
                v-for="(item, index) of countryData"
                :key="index"
                @click="showCountryData(index)"
              >
                <div>
                  {{ item.title }}
                </div>
                <van-icon name="arrow" class="icon" />
              </div>
            </div>
          </div>
          <div class="table-box">
            <div class="economy-card">
              <div class="title">
                {{ selectedCountryData.title
                }}<span class="subtext"
                  >({{ selectedCountryData.measure }})</span
                >
              </div>
              <div class="economy-item-wrap">
                <div class="economy-item">
                  <div class="name">全国</div>
                  <div class="gross">
                    <span class="subtxt">总量:</span
                    >{{ selectedCountryData.country_gross }}
                  </div>
                  <div class="rise">
                    <span class="subtxt">同比:</span
                    ><Trend
                      :size="12"
                      :rate="selectedCountryData.country_rise"
                      v-if="selectedCountryData.country_rise"
                    ></Trend
                    ><span class="subtxt" v-else>--</span>
                  </div>
                </div>
                <div class="economy-item">
                  <div class="name">广东省</div>
                  <div class="gross">
                    <span class="subtxt">总量:</span
                    >{{ selectedCountryData.province_gross }}
                  </div>
                  <div class="rise">
                    <span class="subtxt">同比:</span
                    ><Trend
                      :size="12"
                      :rate="selectedCountryData.province_rise"
                      v-if="selectedCountryData.province_rise"
                    ></Trend
                    ><span class="subtxt" v-else>--</span>
                  </div>
                </div>
                <div class="economy-item">
                  <div class="name">珠海市</div>
                  <div class="gross">
                    <span class="subtxt">总量:</span
                    >{{ selectedCountryData.city_gross }}
                  </div>
                  <div class="rise">
                    <span class="subtxt">同比:</span
                    ><Trend
                      :size="12"
                      :rate="selectedCountryData.city_rise"
                      v-if="selectedCountryData.city_rise"
                    ></Trend
                    ><span class="subtxt" v-else>--</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import HeadBar from "@/components/main/header-bar.vue";
import * as baseApi from "@/api/base.js";
export default {
  components: {
    HeadBar,
  },
  data() {
    return {
      showIntroduceDetail:false,
      economyIntroduce: { preface: "" },
      activeTab: "jinwan",
      totalInfo: [],
      twoYearName: "",
      townData: [],
      selectedCountyData: { child: [] },
      selectedCountryData: { child: [] },
      selectedTownData: { child: [] },
      curCountyDataIndex: 0,
      curTownDataIndex: 0,
      curCountryDataIndex: 0,
      countyData: [],
      countyColumns: [
        {
          title: "区域",
          key: "county",
        },
        {
          title: "总量",
          key: "gross",
        },
        {
          title: "同比",
          key: "rise",
        },
        {
          title: "占全市比重",

          key: "proportion",
        },
        {
          title: "增速位次",
          key: "zs_ranking",
        },
      ],
      countryData: [],
    };
  },
  methods: {
    showEconomyIntroduceDetail(){
      this.showIntroduceDetail = !this.showIntroduceDetail
    },
    showTownTableData(index) {
      var newData = Object.assign({}, this.townData[index]);
      this.selectedTownData = newData;
      this.curTownDataIndex = index;
    },
    showCountyTableData(index) {
      var newData = Object.assign({}, this.countyData[index]);
      this.selectedCountyData = newData;
      this.curCountyDataIndex = index;
    },
    showCountryData(index) {
      var newData = Object.assign({}, this.countryData[index]);
      this.selectedCountryData = newData;
      this.curCountryDataIndex = index;
    },
  },
  computed: {
    curCountyTableData() {
      return this.countyData[this.countyDataIndex].child;
    },
  },
  mounted() {
    baseApi.get_total({ cate: "all" }).then((res) => {
      this.totalInfo = res.data.list;
      this.twoYearName = res.data.beforeLastYear;
    });
    baseApi.get_economy_introduce().then((res) => {
      this.economyIntroduce = res.data.info;
    });

    baseApi.get_all_by_town().then((res) => {
      this.townData = res.data.list;
      this.selectedTownData = res.data.list[0];
    });

    baseApi.get_all_by_county().then((res) => {
      this.countyData = res.data.list;
      // this.curCountyData = res.data.list[0]
      this.selectedCountyData = res.data.list[0];
    });

    baseApi.get_all_by_country().then((res) => {
      this.countryData = res.data.list;
      // this.curCountyData = res.data.list[0]
      this.selectedCountryData = res.data.list[0];
    });
  },
};
</script>

<style lang="less" scoped>
.overview-wrap {
  padding-top: 0.354167rem;

  // padding-top: 0.291667rem;
  // background-color: #031527;
  // background-image: url(../../assets/images/child-bg.jpg);
  // background-position: top center;
  // background-repeat: no-repeat;
  // background-size: cover;
}
.tab-wrap {
  display: flex;
  flex-direction: column;
  height: 100%;
  .tab-card {
    display: flex;
    flex: 0 0 auto;
    justify-content: space-between;
    align-items: center;
    padding: 0 0.083333rem;

    .item {
      width: 25%;
      height: 0.166667rem;
      line-height: 0.166667rem;
      border-right: 1px solid #e8e8e8;
      font-size: 14px;
      text-align: center;
      background-color: #fff;
    }
    .active {
      background-color: #0561f9 !important;
      color: #fff;
    }
  }
  .tab-content {
    flex-grow: 1;
    overflow-y: auto;
  }
}
.item-bar {
  position: relative;
  margin:0 auto .166667rem;
  text-align: center;
  .title-text {
    font-size: 16px;
    font-weight: bold;
  }
  .title-text::before {
    width: 100%;
    height: 1px;
    background: #969696;
    position: absolute;
    left: 0;
    right: 0;
    content: "";
    bottom: -6px;
  }
  .title-text::after {
    display: block;
    overflow: hidden;
    content: "";
    background: #969696;
    position: absolute;
    left: 50%;
    width: 8px;
    bottom: -10px;
    height: 8px;
    border-radius: 100%;
    margin-left: -4px;
  }
}
.list-wrap {
  width: 100%;

  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;

  .item {
    flex: 0 0 auto;
    margin-bottom: 0.125rem;
    padding: 12px;
    width: 49%;
    background-color: rgba(255, 255, 255, 0.9);
    .icon {
      flex: 0 0 auto;
    }
    .title {
      font-size: 14px;
      font-weight: bold;
      .subtext {
        margin-left: 4px;
        font-size: 12px;
        color: #969696;
        font-weight: 100;
      }
    }
    .info {
      flex-grow: 1;
      margin-left: 12px;
      .top-box {
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        .subtxt {
          font-size: 12px;
          color: #969696;
          font-weight: 300;
        }
        .gross {
          font-weight: bold;
          color: #003399;
        }
      }
      .two-year-data-box {
        opacity: 0.6;
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        .subtxt {
          color: #969696;
        }
      }
    }
  }
}
.economy-card {
  .title {
    padding: 0.041667rem 0.083333rem;
    background: #f8f8f9;
    border-bottom: 1px solid #e8e8e8;
    font-size: 12px;
    font-weight: bold;
    .subtext {
      margin-left: 4px;
      font-size: 11px;
      color: #969696;
      font-weight: 100;
    }
  }
  .economy-item-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.041667rem 0.083333rem;
    .economy-item {
      flex: 0 0 auto;
      margin-bottom: 0.125rem;
      width: 30%;
      background-color: rgba(255, 255, 255, 0.9);
      border-right: 1px solid rgba(0, 0, 0, 0.1);
      .name {
        font-weight: bold;
      }
    }
    .economy-item:last-child {
      border-right: none;
    }
  }
}
.county-wrap {
  display: flex;
  height: 100%;
  padding: 0.083333rem;
  .title-box {
    flex: 0 0 auto;
    display: flex;
    flex-direction: column;
    width: 40%;
    height: 100%;
    background: #fff;
    .title-list {
      flex-grow: 1;
      overflow-y: auto;
    }
    .title-bar {
      flex: 0 0 auto;
      padding: 8px 12px;
      font-weight: bold;
      background: #f8f8f9;
    }
    .title-item {
      position: relative;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 0.0625rem;
      height: 40px;
      line-height: 40px;
      border-top: 1px solid #e8e8e8;
      .subtxt {
        margin-left: 4px;
        font-size: 12px;
        color: #969696;
        font-weight: 100;
      }
      .icon {
        // display: none;
        // position: absolute;
        // top:0;
        // right:-128px;
        // z-index: 90;
        color: #969696;
      }
    }
    .active {
      background-color: #0561f9;
      color: #fff;
      font-weight: bold;
      .icon {
        color: #fff;
      }
    }
  }
  .table-box {
    flex: 1 1 auto;
    margin-left: 12px;
    background: #fff;
    .selectd-info {
      padding: 0.041667rem 0.083333rem;
      background: #f8f8f9;
      border-bottom: 1px solid #e8e8e8;
      .title {
        font-weight: bold;
      }
      .measure {
        margin-left: 4px;
        font-size: 11px;
        color: #969696;
      }
    }
  }
}
.town-wrap {
  padding: 0.083333rem;
  display: flex;
  justify-content: space-between;
  .town-item {
    flex: 0 0 auto;
    margin-bottom: 0.125rem;
    width: 22%;
    background-color: rgba(255, 255, 255, 0.9);
    border-right: 1px solid rgba(0, 0, 0, 0.1);
  }
  .town-item:last-child {
    border-right: none;
  }
}
.tab-content-item {
  padding: 0.083333rem;
}
.enocomy-introduce-box {
  padding: 0.083333rem;
  margin-bottom: 0.125rem;
  background: #fff;
  font-size: 14px;
  text-align: center;
  background-color: #3f84da;
  color: #fff;
  // background: url("/assets/img/login-bg.jpg");
  // background-repeat: no-repeat;
  // background-position: top center;
  // background-size: cover;
  .item-bar {
    width:70%;
    .title-text::before {
      background:#fff;
    }
    .title-text::after {
      background:#fff;
    }
  }
  .enocomy-introduce-preface {
    margin: 0.0625rem auto;
    width: 70%;
    text-align: left;
  }
  .enocomy-introduce-content {
    margin: 0 auto .625rem;
    width:70%;
    text-align: left;
    margin-bottom:.0625rem;
  }
  .open-btn {
    margin: 0 auto;
    width: 200px;
    height: 0.1875rem;
    line-height: 0.1875rem;
    border: 1px solid rgba(255, 255, 255, 0.7);
  }
  .open-btn:hover {
    background-color: #fff;
    color: #0561f9;
  }
}
</style>