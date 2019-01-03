<template>
  <div>
    <div class="progress-nodes">
      <div
        v-for="(item,index) in progressList"
        :key="item.id"
        class="item"
        :class="['status-'+item.status]"
      >
        <Row>
          <i-col span="18">
            <div class="title">
              <span class="caption">{{item.title}}</span>
              <span class="stage">{{stageArr[item.status]}}</span>
            </div>
          </i-col>
          <i-col class="6"><Button type="default" v-if="item.status == 0" @click="handleEditNode(index)">编辑</Button></i-col>
        </Row>
        <div class="desc">{{item.description}}</div>
      </div>
      <div class="item">
        <Button icon="plus" type="primary" @click="handleAddNode">添加项目进度节点</Button>
      </div>
    </div>
    <Modal v-model="showNodeModal" width="640">
      <p slot="header">
        <Icon type="information-circled"></Icon>
        <span>{{modalActName}}</span>
      </p>
      <div>
        <Form ref="nodeForm" :model="nodeDetail" :label-width="80" :rules="nodeFormRule">
          <FormItem label="标题:" prop="title">
            <Input type="text" v-model="nodeDetail.title" placeholder="请输入标题"/>
          </FormItem>
          <FormItem label="类型:" prop="description">
            <Input type="textarea" v-model="nodeDetail.description" placeholder="请输入描述"/>
          </FormItem>
          <FormItem>
            <Row :gutter="16">
              <i-col span="6">
                <Button size="large" long @click="showNodeModal=false">取消</Button>
              </i-col>
              <i-col span="12">
                <Button
                  type="primary"
                  size="large"
                  :loading="nodeSubmiting"
                  long
                  @click="handleSubmit"
                >保存</Button>
              </i-col>
            </Row>
          </FormItem>
        </Form>
      </div>
      <div slot="footer" style="margin-left:80px;"></div>
    </Modal>
  </div>
</template>
<script>
import { getTableList, deleteDataOne, getDataOne, saveData } from "@/api/data";
import axios from "@/libs/api.request";
export default {
  data() {
    return {
      progressList: [],
      curUpdateNodeIndex: 0,
      showNodeModal: false,
      nodeSubmiting: false,
      modalActName: "",
      nodeDetail: {},
      stageArr: ["未开始", "进行中", "待审核", "审核已完成", "审核未完成"],
      nodeFormRule: {
        title: [{ required: true, message: "标题名称不能为空" }],
        description: [{ required: true, message: "节点描述不能为空" }]
      }
    };
  },
  methods: {
    handleAddNode() {
      this.nodeDetail.pt_id = this.parttimeId;
      this.showNodeModal = true;
      this.modalActName = "添加节点";
    },
    handleEditNode(index) {
      this.curUpdateNodeIndex = index;
      this.nodeDetail = this.progressList[index];
      this.showNodeModal = true;
      this.modalActName = "编辑节点";
    },
    handleSubmit() {
      this.$refs["nodeForm"].validate(valid => {
        if (valid) {
          if (this.nodeSubmiting) return;
          this.nodeSubmiting = true;
          let apiUrl = "";
          let postData = Object.assign({}, this.nodeDetail);
          if (this.modalActName == "添加节点") {
            saveData("/ParttimeProgress/doadd", postData).then(
              res => {
                if (res) {
                  this.$Message.success("Success!");
                  this.nodeSubmiting = false;
                  this.showNodeModal = false;
                  this.progressList.push(res.data.info);
                }
              },
              reject => {
                this.nodeSubmiting = true;
              }
            );
          } else {
            saveData("/ParttimeProgress/update", postData).then(
              res => {
                if (res) {
                  let index = this.curUpdateNodeIndex;
                  this.$Message.success("Success!");
                  this.nodeSubmiting = false;
                  this.showNodeModal = false;
                  this.progressList[index] = this.nodeDetail;
                }
              },
              reject => {
                this.questionSubmiting = true;
              }
            );
          }
        }
      });
    }
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
  height: 24px;
  line-height: 24px;
  border-radius: 12px;
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
.progress-nodes .title .caption {
  font-size: 16px;
}
.progress-nodes .desc {
  margin-top: 10px;
  padding: 10px;
  color: #9c9c9c;
  border: 1px solid #f1f1f1;
  background: #f8f8f8;
}
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
.progress-nodes > .item .stage {
  margin-left: 6px;
  font-size: 12px;
}
.progress-nodes .status-1 .stage {
  color: #1b7dd5;
}
.progress-nodes .status-2 .stage {
  color: #1bd5ca;
}
.progress-nodes .status-3 .stage {
  color: #1bd535;
}
.progress-nodes .status-4 .stage {
  color: #d5311b;
}

.progress-nodes .status-1::before {
  background: #1b7dd5;
}
.progress-nodes .status-2::before {
  background: #1bd5ca;
}
.progress-nodes .status-3::before {
  background: #1bd535;
}
.progress-nodes .status-4::before {
  background: #d5311b;
}
</style>
