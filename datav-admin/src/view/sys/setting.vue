<template>
  <Card>
    <Tabs :value="curTab">
      <TabPane label="系统数据月份" name="date">
        <DatePicker
          type="month"
          placeholder="请选择"
          style="width: 200px"
          :value="sysDate"
        ></DatePicker
      ></TabPane>
      <!-- <TabPane label="图标设置" name="icon">标签二的内容</TabPane> -->
    </Tabs>
  </Card>
</template>

<script>
import axios from "@/libs/api.request";
export default {
  data() {
    return {
      curTab: "date",
      sysDate:new Date()
    };
  },
  mounted() {
    axios
      .request({
        url: "SysSetting/get_sys_info",
      })
      .then((res) => {
        this.sysDate = new Date(res.data.sysDate)
      });
  },
};
</script>

<style lang="less" scoped>
</style>