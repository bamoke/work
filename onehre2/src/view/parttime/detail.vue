<template>
  <Card>
    <h3 class="" slot="title">当前项目：【{{baseInfo.title}}】</h3>
    <Menu mode="horizontal" @on-select="selectTab" :active-name="curTab" style="margin-bottom:20px">
        <MenuItem name="parttime_introduce">
            <Icon type="ios-paper"></Icon>
            项目介绍
        </MenuItem>
        <MenuItem name="parttime_progress">
            <Icon type="compass"></Icon>
            项目进度
        </MenuItem>
        <MenuItem name="parttime_member">
          <Icon type="ios-people"></Icon>
            项目成员
        </MenuItem>
        <MenuItem name="parttime_discuss">
          <Icon type="chatboxes"></Icon>
            讨论组
        </MenuItem>
        <MenuItem name="parttime_apply">
          <Icon type="share"></Icon>
            申请记录
        </MenuItem>
    </Menu>
    <router-view style=""></router-view>
  </Card>
</template>
<style>
.m-tab {
  display: flex;
}
.m-tab .item {
  width: 120px;
}
</style>

<script>
import { getTableList, deleteDataOne, getDataOne } from "@/api/data";
import {routeReplace} from '@/libs/util'
export default {
  data() {
    return {
      curTab: "introduce",
      parttimeId:null,
      baseInfo:{}
    };
  },
  methods: {
    selectTab(e) {
      routeReplace({name:e},this)
    }
  },

  mounted() {
    this.curTab = this.$route.name;
    const parttimeId = this.$route.params.id;
    this.parttimeId = parttimeId;
    getDataOne("Parttime/base", { id: parttimeId }).then(res => {
      this.baseInfo = res.info;
    });
  }
};
</script>
