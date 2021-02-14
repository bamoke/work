<template>
  <Card>
    <h3 slot="title">问题详情</h3>
    <h1>{{questionInfo.title}}</h1>
    <Row type="flex" justify="start" align="middle" class="code-row-bg">
      <i-col span="3">{{questionInfo.create_time}}</i-col>
      <i-col span="3">
        <Tag color="success" v-if="questionInfo.stage==1">已解决</Tag>
        <Tag color="error" v-else>未解决</Tag>
      </i-col>
    </Row>
    <div>{{questionInfo.content}}</div>
    <Divider />
    <template v-if="answerList.length">
        <List item-layout="vertical">
        <ListItem v-for="item in answerList" :key="item.id">
            <ListItemMeta :title="item.adviser_name" :description="item.adviser_description" />
            {{ item.content }}
            <template slot="action">
            <li>
                有用：{{item.satisfaction_num}}
            </li>
            <li>
                感谢：{{item.think_num}}
            </li>
            <li>
                没用：{{item.dissatisfaction_num}}
            </li>
            </template>

        </ListItem>
        </List>
    </template>
     <Alert show-icon v-else>
        暂无回答
        <Icon type="ios-bulb-outline" slot="icon"></Icon>
        <template slot="desc">还没有顾问回答该问题 </template>
    </Alert>
  </Card>
</template>

<script>
import axios from "@/libs/api.request";
export default {
  data() {
    return {
      questionInfo: {},
      answerList: []
    };
  },
  mounted() {
    const curId = parseInt(this.$route.params.id);
    axios
      .request({
        url: `AdviserQuestion/detail/id/${curId}`,
        method: "get"
      })
      .then(res => {
        this.questionInfo = res.data.questionInfo;
        this.answerList = res.data.answerList;
      });
  }
};
</script>

<style>
</style>