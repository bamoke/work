<template>
  <Card>
    <div slot="title"><h2>{{baseInfo.realname}}的简历</h2></div>
      <Button type="primary" slot="extra" @click.prevent="handlePrint">
        <Icon type="printer" size="18px"></Icon>
        打印
      </Button>
        <div id="resume-view">
      <table width="100%" border="0" class="base-info-table" style="border-bottom:1px solid #999;padding-bottom:24px;">
        <tr>
          <td width="10%">性别：</td>
          <td>{{baseInfo.sex}}</td>
          <td width="15%">出生年月：</td>
          <td>{{baseInfo['birth']}}</td>
        </tr>
        <tr>
          <td>学历：</td>
          <td>{{baseInfo.edu}}</td>
          <td>工作经验：</td>
          <td>{{baseInfo.experince}}</td>
        </tr>
        <tr>
          <td>手机：</td>
          <td>{{baseInfo['phone']}}</td>
          <td>邮箱：</td>
          <td>{{baseInfo['email']}}</td>
        </tr>
      </table>
      <br>
      <h3 class="bar">教育经历</h3>
      <table width="100%" border="0" style="border-bottom:1px solid #999;padding-bottom:20px;">
          <tr v-for="(item,index) in eduInfo" v-bind:key="index">
            <td width="35%"><strong>{{item['school']}}</strong></td>
            <td width="30%">{{item['start_time']}}至{{item['end_time']}}</td>
            <td width="20%">{{item['major']}}</td>
            <td width="15%">{{item['level']}}</td>
          </tr>
      </table>
      <br>
      <h3 class="bar">工作经历</h3>
      <table width="100%" border="0" style="border-bottom:1px solid #999;padding-bottom:20px;">
          <template v-for="work in workInfo">
          <tr class="work-base" >
            <td width="40%"><strong>{{work['company']}}</strong></td>
            <td width="30%">{{work['start_time']}}至{{work['end_time']}}</td>
            <td width="30%">{{work['position']}}</td>
          </tr>
          <tr>
            <td colspan="3" class="work-desc" v-html="work['content']"></td>
          </tr>
          </template>

      </table>
      <br>
      <h3 class="bar">自我介绍</h3>
      <div v-html="baseInfo['introduce']"></div>
    </div>
  </Card>
</template>
<style>
@media print{
  .ivu-layout-sider,.ivu-layout-header,.tag-nav-wrapper,.ivu-card-extra {display: none;}
}
</style>

<script>
  import { getDataOne } from "@/api/data";
  export default {
  name: "",
  data() {
    return {
      id:null,
      baseInfo:{},
      eduInfo:[],
      workInfo:[]
    };
  },
  methods: {
    handlePrint() {
      window.print()
    }
  },
  mounted(){
    const curId = this.$route.params.id
    this.id = parseInt(curId)
    getDataOne('Resume/detail',{id:curId}).then(res=>{
      if(res){
          this.baseInfo = res.data.baseInfo
          this.eduInfo = res.data.eduInfo
          this.workInfo = res.data.workInfo
          window.document.title = res.data.baseInfo.realname +"的简历"
      }
    })
  }
};
</script>