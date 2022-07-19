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
          height="480"
          stripe
          :columns="hangyeDataZjz.columns"
          :data="hangyeDataZjz.list"
        />
      </div>
    </div>
    <div class="item">
      <div class="section">工业总产值分行业情况</div>
      <div>
        <Table
          size="small"
          height="480"
          stripe
          :columns="hangyeDataZcz.columns"
          :data="hangyeDataZcz.list"
        />
      </div>
    </div>
  </div>
</template>

<script>
import * as Api from "@/api/index";
export default {
  data() {
    return {
      hangyeDataZjz: {},
      hangyeDataZcz: {},
    };
  },
  mounted() {
    Api.base.get_industry_hy({ params: { cate: "all" } }).then((res) => {
      this.hangyeDataZjz = res.data.zjz;
      this.hangyeDataZcz = res.data.zcz;
    });
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
