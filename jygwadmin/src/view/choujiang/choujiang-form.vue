<template>
  <div>
    <Tabs :value="editContent">
      <TabPane label="基本资料" name="base">
        <Form
          ref="eventForm"
          :model="formInfo"
          :label-width="100"
          :rules="ruleForm"
          label-position="right"
        >
          <FormItem label="活动标题:" prop="title">
            <Input v-model.trim="formInfo.title" placeholder="请输入抽奖活动标题" />
          </FormItem>
          <FormItem label="参加次数:" prop="join_type">
            <Select v-model="formInfo.join_type" placeholder="请选择" style="width:200px">
              <Option value="1">每人仅限一次</Option>
              <Option value="2">每人每天一次</Option>
            </Select>
          </FormItem>

          <FormItem label="背景图片:">
            <Row>
              <i-col span="8">
                <ImgUpload
                  :upload-url="thumbUploadUrl"
                  :delete-url="thumbDeleteUrl"
                  :initFileList="thumbList"
                  @file-changed="handleFileChanged"
                />
              </i-col>
              <i-col span="8">图片尺寸建议:1080px*480px</i-col>
            </Row>
          </FormItem>

          <FormItem label="活动开始日期:" prop="start_date">
            <DatePicker
              :value="formInfo.start_date"
              type="date"
              format="yyyy-MM-dd"
              placeholder="请选择"
              style="width: 200px"
              @on-change="handleStartDateChange"
            ></DatePicker>
          </FormItem>

          <FormItem label="截至日期:" prop="end_date">
            <DatePicker
              :value="formInfo.end_date"
              type="date"
              format="yyyy-MM-dd"
              placeholder="请选择"
              style="width: 200px"
              @on-change="handleEndDateChange"
            ></DatePicker>
          </FormItem>

          <FormItem label="显示状态:">
            <i-switch v-model="formInfo.status" size="large" true-value="1" false-value="0">
              <span slot="open">启用</span>
              <span slot="close">下架</span>
            </i-switch>
          </FormItem>
          <FormItem label="抽奖规则:">
            <Editor
              v-model="formInfo.content"
              :cache="false"
              :menus="editorMenus"
              :upload-url="contentUploadUrl"
              :init-content="initContent"
            />
          </FormItem>
          <FormItem>
            <Row :gutter="16">
              <i-col span="8">
                <Button @click="handleCancel" size="large" long>取消</Button>
              </i-col>
              <i-col span="8">
                <Button
                  type="primary"
                  size="large"
                  @click="handleSubmit('eventForm')"
                  :loading="submitIng"
                  long
                >提交</Button>
              </i-col>
            </Row>
          </FormItem>
        </Form>
      </TabPane>
      <TabPane label="奖品设置" name="award">
        <Alert type="error">
          重要提醒：
          <template slot="desc">
            <div>1.中奖几率：数值越高，中奖率越高，系统计算方法（单个奖项中奖几率除以所有奖项中奖几率之和）</div>
            <div>2.奖项数量：奖品数量设置,不中奖的选项请输入"-1"，必须注意，这是不中奖的标识，参考测试。</div>
            <div>3.奖项设置：建议6-8项较为合适，不够这么多项，可将某个奖项拆分，数量分开，中奖几率保持不变。参考测试的幸运奖，把90个奖品数量拆分了。</div>
            <div>4.奖项保存：奖项设置好记得点击后面的保存按钮，单项保存。</div>
          </template>
        </Alert>
        <Row>
          <i-col span="10">奖品名称</i-col>
          <i-col span="2" offset="1">奖品数量</i-col>
          <i-col span="2" offset="1">中奖几率</i-col>
          <i-col span="2" offset="1">排序</i-col>
        </Row>
        <Form v-for="(item, index) in awardInfo" :key="index" :model="item">
          <FormItem>
            <Row class="award-list-item">
              <i-col span="9">
                <FormItem
                  prop="name"
                  :rules="{required: true, message: '奖项 ' + (index+1) +' 名称不能为空', trigger: 'blur'}"
                >
                  <Input type="text" v-model="item.name" :maxlength="24" placeholder="请输入奖项名称"></Input>
                </FormItem>
              </i-col>
              <i-col span="2" offset="1">
                <FormItem
                  prop="num"
                  :rules="{required: true, message: '奖项 ' + (index+1) +' 数量必须为数字', trigger: 'blur'}"
                >
                  <Input type="text" v-model="item.num" :maxlength="5" placeholder="请输入奖项数量"></Input>
                </FormItem>
              </i-col>
              <i-col span="2" offset="1">
                <FormItem
                  prop="random_num"
                  :rules="{required: true, message: '奖项 ' + (index+1) +' 中奖几率必须为数字', trigger: 'blur'}"
                >
                  <Input
                    type="text"
                    v-model="item.random_num"
                    :maxlength="12"
                    placeholder="请输入中奖几率"
                  ></Input>
                </FormItem>
              </i-col>
              <i-col span="2" offset="1">
                <FormItem>
                  <Input type="text" v-model="item.sort" :maxlength="12" placeholder></Input>
                </FormItem>
              </i-col>
              <i-col span="4" offset="1">
                <Button @click="handleSaveItem(index)" type="primary" style="margin-right:12px">保存</Button>
                <Button @click="handleRemoveItem(index)">删除</Button>
              </i-col>
            </Row>
          </FormItem>
        </Form>
        <Row>
          <Col span="10">
            <Button type="dashed" long @click="handleAddItem" icon="md-add">添加奖项</Button>
          </Col>
        </Row>
      </TabPane>
    </Tabs>
  </div>
</template>

<script>
import Editor from "_c/editor";
import ImgUpload from "_c/img-upload";
import axios from "@/libs/api.request";
export default {
  name: "eventForm",
  components: { Editor, ImgUpload },
  props: {
    id: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
      editorMenus: [
        "head",
        "bold",
        "italic",
        "underline",
        "justify",
        "list",
        "undo",
        "redo",
        "image"
      ],
      submitIng: false,
      ruleForm: {
        title: [{ required: true, message: "请输入活动标题" }],
        join_type: [{ required: true, message: "请选择可参与次数" }],
        start_date: [{ required: true, message: "请填写活动开始时间" }],
        end_date: [{ required: true, message: "请填写活动截至时间" }],
        content: [{ required: true, message: "请填写项目描述120字符内" }]
      },
      itemRule: {
        name: [{ required: true, message: "奖品名称必须填写" }],
        num: [{ required: true, message: "奖品数量必须填写" }],
        random_num: [{ required: true, message: "中奖几率必须填写" }]
      },
      formInfo: {
        status: "1",
        award: [{ name: "", num: 1, random: "" }],
        start_date: "",
        end_date: ""
      },
      curId: null,
      thumbList: [],
      awardInfo: [],
      thumbUploadUrl: "/Uploads/save/f/thumb",
      thumbDeleteUrl: "/Uploads/delete",
      contentUploadUrl: "/jygw/admin.php/Uploads/save/f/images",
      initContent: "",
      editContent: "base"
    };
  },
  watch: {
    id: function(newValue) {
      if (!newValue) {
        return;
      }
      axios
        .request({
          url: `Choujiang/edit/id/${newValue}`,
          method: "get"
        })
        .then(res => {
          this.formInfo = res.data.info;
          this.thumbList = res.data.thumbList;
          this.curId = newValue;
          this.awardInfo = res.data.awardInfo;
          this.initContent = res.data.info.content;
        });
    }
  },
  methods: {
    handleRemoveItem(index) {
      const id = this.awardInfo[index].id;
      if (id) {
        axios
          .request({
            url: "Choujiang/deleteone",
            params: { id, type: 2 },
            method: "get"
          })
          .then(res => {
            this.$Message.success("删除成功");
            this.awardInfo.splice(index, 1);
          });
      } else {
        this.awardInfo.splice(index, 1);
      }
    },
    handleSaveItem(index) {
      const curItem = this.awardInfo[index];
      if (!this.curId) {
        this.$Message.error("请先完成基本信息填写");
        return;
      }
      if (curItem.name == "" || !curItem.num || !curItem.random_num) {
        this.$Message.error("有数据填写错误");
        return;
      }
      axios
        .request({
          url: "Choujiang/saveaward",
          data: { cid: this.curId, ...curItem },
          method: "post"
        })
        .then(
          res => {
            this.$Message.success("Success!");
          },
          reject => {
            this.$Message.error(reject.toSting());
            console.log(reject);
          }
        );
    },
    handleAddItem() {
      this.awardInfo.push({
        id: "",
        name: "",
        num: 10,
        random: 10,
        sort: 99
      });
    },
    handleStartDateChange(e) {
      this.formInfo.start_date = e;
    },
    handleEndDateChange(e) {
      this.formInfo.end_date = e;
    },
    setFileList() {},
    handleFileChanged(data) {
      this.formInfo.thumb = data;
    },
    handleEditorChange(html, text) {
      this.newContent = html;
    },
    handleSubmit(name) {
      // this.submitIng = true;
      this.$refs[name].validate(valid => {
        if (valid) {
          axios
            .request({
              url: "Choujiang/save",
              data: { ...this.formInfo },
              method: "post"
            })
            .then(
              res => {
                this.$Message.success("Success!");
                this.$emit("form-saved", res);
                this.submitIng = false;
              },
              reject => {
                this.$Message.success(reject.toSting());
                this.submitIng = false;
                console.log(reject);
              }
            );
        } else {
          // this.$Message.error("Error!");
          this.submitIng = false;
        }
      });
    },
    handleCancel() {
      this.$store.commit("closeTag", this.$route);
    }
  },
  computed: {},
  mounted() {}
};
</script>
<style>
.award-list-item:not(:last-child) {
  margin-bottom: 24px;
}
</style>
