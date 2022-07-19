<template>
  <div class="town-map-wrap">
    <div class="town-item town-hq">
      <div
        class="pillar"
        :style="{ height: pillarHeight(economyInfo.hq.gross) }"
      >
        <div class="info">
          <span class="gross">{{ economyInfo.hq.gross || "--" }}</span>
          <span>{{ economyInfo.hq.measure }}</span>
        </div>
      </div>
      <div class="town-name">{{ economyInfo.hq.name }}</div>
    </div>
    <div class="town-item town-sz">
      <div
        class="pillar"
        :style="{ height: pillarHeight(economyInfo.sz.gross) }"
      >
        <div class="info">
          <span class="gross">{{ economyInfo.sz.gross || "--" }}</span>
          <span>{{ economyInfo.sz.measure }}</span>
        </div>
      </div>
      <div class="town-name">{{ economyInfo.sz.name }}</div>
    </div>
    <div class="town-item town-ns">
      <div
        class="pillar"
        :style="{ height: pillarHeight(economyInfo.ns.gross) }"
      >
        <div class="info">
          <span class="gross">{{ economyInfo.ns.gross || "--" }}</span>
          <span class="measure">{{ economyInfo.ns.measure }}</span>
        </div>
      </div>
      <div class="town-name">{{ economyInfo.ns.name }}</div>
    </div>
    <div class="town-item town-ps">
      <div
        class="pillar"
        :style="{ height: pillarHeight(economyInfo.ps.gross) }"
      >
        <div class="info">
          <span class="gross">{{ economyInfo.ps.gross || "--" }}</span>
          <span>{{ economyInfo.ps.measure }}</span>
        </div>
      </div>
      <div class="town-name">{{ economyInfo.ps.name }}</div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    totalInfo: {
      type: Object,
      default: function () {
        return {};
      },
    },
  },
  data() {
    return {
      maxGross: 0,
      economyInfo: {
        hq: { gross: "", measure: "" },
        sz: { gross: "", measure: "" },
        ns: { gross: "", measure: "" },
        ps: { gross: "", measure: "" },
      },
      backgroundImg: "./assets/img/town-map-bg.png",
    };
  },
  methods: {
    pillarHeight(gross) {
      if (!gross) {
        return "0px";
      } else {
        return (gross / this.maxGross) * 180 + "px";
      }
    },
  },
  watch: {
    totalInfo(newValue, oldValue) {
      var economyInfo = {};
      var grossList = [];
      if (newValue) {
        if (newValue.list.length === 0) {
          return;
        }
        newValue.list.forEach((element) => {
          let gross = element.gross
          if(element.integer){
            gross = parseInt(gross)
          }else {
            gross = parseFloat(gross)
          }
          if (gross) {
            grossList.push(gross);
          }
          if (element.town == "红旗") {
            economyInfo.hq = {
              gross,
              measure: newValue.measure,
              name: "红旗",
            };
          } else if (element.town == "三灶") {
            economyInfo.sz = {
              gross,
              measure: newValue.measure,
              name: "三灶",
            };
          } else if (element.town == "南水") {
            economyInfo.ns = {
              gross,
              measure: newValue.measure,
              name: "南水",
            };
          } else if (element.town == "平沙") {
            economyInfo.ps = {
              gross,
              measure: newValue.measure,
              name: "平沙",
            };
          }
        });
        if (grossList.length) {
          grossList.sort(function (a, b) {
            return a - b;
          });
          this.maxGross = grossList[grossList.length - 1];
        }

        this.economyInfo = economyInfo;
      }
    },
  },
};
</script>

<style lang="less" scoped>
.town-map-wrap {
  flex:0 0 auto;
  position: relative;
  width: 100%;
  height: 3.333333rem;

  background: url(/bi/assets/img/town-map-bg.png) no-repeat;
  background-position: bottom center;
  background-size: contain;
  .town-item {
    position: absolute;
    width: 48px;
    z-index: 99;
    .pillar {
      position: absolute;
      left: 0;
      bottom: 0;
      width: 24px;
      height: 48px;
      background-image: linear-gradient(#f9cb02, #a44d07);
      transition: all 1s;
      .info {
        position: absolute;
        left: 0;
        top: -48px;
        display: flex;
        align-items: center;
        padding: 0 18px;
        height: 36px;
        white-space: nowrap;
        background: #335081;
        color: #fff;
        border: 2px solid #fff;
        border-radius: 18px;
        line-height: 1;
        .gross {
          font-size: 24px;
          color: #f4c700;
          font-weight: bold;
        }
      }
    }
    .pillar::before {
      content: "";
      display: block;
      position: absolute;
      z-index: 998;
      top: -12px;
      left: 0;
      width: 24px;
      height: 12px;
      background: #fffd00;
    }

    .town-name {
      position: absolute;
      left: 24px;
      bottom: 0;
      color: #fff;
      font-size: 18px;
      white-space: nowrap;
    }
  }
  .town-hq {
    right: 340px;
    bottom: 400px;
  }
  .town-sz {
    right: 180px;
    bottom: 360px;
  }
  .town-ns {
    left: 360px;
    bottom: 260px;
  }
  .town-ps {
    left: 220px;
    bottom: 360px;
  }
}
</style>