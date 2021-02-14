<template>
  <Card>
    <div slot="title">小程序前端设置</div>
    <Alert show-icon>
      开关说明
      <template slot="desc">助学与抽奖的开启，指的是——是否在首页显示入口</template>
    </Alert>
    <Form
      ref="settingForm"
      :model="formInfo"
      :label-width="120"
      label-position="right"
      style="width:50%"
    >
      <FormItem label="开启助学:">
        <RadioGroup v-model="formInfo.grants_show">
          <Radio label="1">
            <span>是</span>
          </Radio>
          <Radio label="0">
            <span>否</span>
          </Radio>
        </RadioGroup>
      </FormItem>

      <FormItem label="开启抽奖:">
        <RadioGroup v-model="formInfo.choujiang_show">
          <Radio label="1">
            <span>是</span>
          </Radio>
          <Radio label="0">
            <span>否</span>
          </Radio>
        </RadioGroup>
      </FormItem>
      <FormItem label="联系人：">
        <Row>
          <i-col span="12">
            <Input type="text" v-model="formInfo.contact" :maxlength="12" placeholder="人才服务专员称呼"></Input>
          </i-col>
        </Row>
      </FormItem>
      <FormItem label="人才服务热线：">
        <Row>
          <i-col span="12">
            <Input type="text" v-model="formInfo.tel" :maxlength="12" placeholder="手机号或电话号码"></Input>
          </i-col>
        </Row>
      </FormItem>
      <FormItem>
        <Row :gutter="16">
          <i-col span="8">
            <Button
              type="primary"
              size="large"
              long
              @click="handleSubmit('settingForm')"
              :loading="submitIng"
            >提交</Button>
          </i-col>
          <i-col span="4">
            <Button @click="handleCancel" long size="large">取消</Button>
          </i-col>
        </Row>
      </FormItem>
    </Form>
  </Card>
</template>

<script>
import axios from "@/libs/api.request";
export default {
  data() {
    return {
      formInfo: {},
      submitIng: false
    };
  },
  methods: {
    handleSubmit(name) {
      this.submitIng = true;
      axios
        .request({
          url: "Index/setting_save",
          data: { ...this.formInfo },
          method: "post"
        })
        .then(
          res => {
            this.$Message.success("保存成功!");
            this.submitIng = false;
          },
          reject => {
            this.$Message.success(reject.toSting());
            this.submitIng = false;
          }
        );
    },
    handleCancel() {
      this.$store.commit("closeTag", this.$route);
    }
  },
  mounted() {
    axios
      .request({
        url: "Index/setting_get"
      })
      .then(
        res => {
          this.formInfo = res.data.info;
        },
        reject => {
          this.$Message.success(reject.toSting());
        }
      );
  }
};
</script>

<style>
</style>