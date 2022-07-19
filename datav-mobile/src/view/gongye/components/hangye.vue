<!--
 * @Author: Joy wang
 * @Date: 2021-06-02 05:46:12
 * @LastEditTime: 2021-06-02 08:02:55
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
--><template>
  <div class="wrap">
    <div class="item">
      <div class="section">工业增加值分行业情况</div>
      <div>
        <Table
          size="small"
          height="320"
          stripe
          :columns="zjzHyData.column"
          :data="zjzHyData.data"
        />
      </div>
    </div>
    <div class="item">
      <div class="section">工业总产值分行业情况</div>
      <div>
        <Table
          size="small"
          height="320"
          stripe
          :columns="zjzHyData.column"
          :data="zjzHyData.data"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      zjzHyData: {
        column: [
          {
            title: "指标名称",
            key: "title",
            fixed: "left",
          },
          {
            title: "公司数量",
            key: "com_num",
            sortable: true,
            width: "120",
          },
          {
            title: "总量(万元)",
            key: "jw_total",
            sortable: true,
            width: "120",
          },
          {
            title: "同比增长",
            key: "jw_rise",
            sortable: true,
            width: "120",
          },
        ],

        data: [
          {
            title: "石油和天然气开采业",
            com_num: 1,
            jw_total: 190525,
            jw_rise: 16.4,
          },
          {
            title: "农副食品加工业",
            com_num: 6,
            jw_total: 1443,
            jw_rise: -13.1,
          },
          {
            title: "食品制造业",
            com_num: 13,
            jw_total: 123137,
            jw_rise: 9.5,
          },
          {
            title: "食品制造业",
            com_num: 13,
            jw_total: 123137,
            jw_rise: 9.5,
          },
          {
            title: "酒、饮料和精制茶制造业",
            com_num: 13,
            jw_total: 123137,
            jw_rise: 9.5,
          },
          {
            title: "纺织业",
            com_num: 6,
            jw_total: 13298,
            jw_rise: -7.8,
          },
          {
            title: "纺织服装、服饰业",
            com_num: 4,
            jw_total: 6107,
            jw_rise: 22.0,
          },
          {
            title: "皮革、皮毛、羽毛及其制品和制鞋业",
            com_num: 1,
            jw_total: 744,
            jw_rise: 116.1,
          },
          {
            title: "铁路、船舶、航空航天和其他运输设备制造业",
            com_num: 17,
            jw_total: 212891,
            jw_rise: 42.7,
          },
          {
            title: "燃气生产和供应业",
            com_num: 1,
            jw_total: 239581,
            jw_rise: 33.6,
          },
          {
            title: "水的生产和供应业",
            com_num: 2,
            jw_total: 1055,
            jw_rise: -20.0,
          },
        ],
      },
    };
  },
};
</script>

<style lang="less" scoped>
.wrap {
  width: 1600px;
  display: flex;
  justify-content: space-between;
  color: #fff;
  .item {
    margin-bottom: 24px;
    width: 45%;
    height: 320px;
    .section {
      margin-bottom: 12px;
      font-size: 18px;
    }
  }
}
.chart-box {
  height: 320px;
}
</style>
