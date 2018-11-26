<template>
    <div class="progress-nodes">
        <div v-for="item in progressList" :key="item.id" class="item" :class="['status-'+item.status]">
          <div class="title">
            <span class="caption">{{item.title}}</span>
            <span class="stage">{{stageArr[item.status]}}</span>
          </div>
          <div class="desc">{{item.description}}</div>
        </div>
    </div>
</template>
<script>
import { getTableList, deleteDataOne, getDataOne } from "@/api/data";
export default {
  data() {
    return {
      progressList: [],
      stageArr: ['未开始','进行中','待审核','审核已完成','审核未完成']
    };
  },
  mounted() {
    const parttimeId = this.$route.params.id;
    this.parttimeId = parttimeId;
    getDataOne("/ParttimeProgress/index", { ptid: parttimeId }).then(res => {
      if (res) {
        this.progressList = res.data.list;
      }
    });
  }
};
</script>
<style>
.m-progress {
  padding-top: 20px;
}
.m-progress .title .caption {
  font-size: 16px;
}
.m-progress .title .stage {
  display: inline-block;
  padding: 0 10px;
  height:24px;
  line-height: 24px;
  border-radius:12px;
}

.progress-nodes {
  padding: 20px 20px 20px 40px;
}

.progress-nodes > .item {
  position: relative;
  padding-left: 12px;
  padding-bottom: 24px;
  border-left: 1px dotted #ccc;
}
.progress-nodes .title .caption {font-size:16px;}
.progress-nodes .desc {margin-top:10px;padding:10px;color:#9c9c9c;border:1px solid #f1f1f1;background:#f8f8f8;}
.progress-nodes .item::before {
  content: "";
  position: absolute;
  top: 5px;
  left: -6px;
  display: inline-block;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: #ddd;
}
.progress-nodes > .item .stage {margin-left:6px;font-size:12px;}
.progress-nodes .status-1 .stage{
  color:#1b7dd5;
}
.progress-nodes .status-2 .stage {
  color:#1bd5ca;
}
.progress-nodes .status-3 .stage{
  color:#1bd535;
}
.progress-nodes .status-4 .stage {
  color:#d5311b;
}

.progress-nodes .status-1::before {
  background:#1b7dd5;
}
.progress-nodes .status-2::before {
  background:#1bd5ca;
}
.progress-nodes .status-3::before {
  background:#1bd535;
}
.progress-nodes .status-4::before {
  background:#d5311b;
}
</style>
