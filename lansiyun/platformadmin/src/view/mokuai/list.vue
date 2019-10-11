<template>
  <div>
    <Card>
      <div slot="title">模块管理</div>
      <Tree :data="treeData" :render="renderContent" style="width:600px;"></Tree>
    </Card>
    <Modal v-model="showModal" title="添加模块">
      <MainForm
        @form-saved="handleSaved"
        @form-cancel="hanldeCancelSave"
        :id="editModuleId"
        :pid="modulePid"
      ></MainForm>
      <div slot="footer"></div>
    </Modal>
  </div>
</template>

<script>
import MainForm from "./main-form";
import axios from "@/libs/api.request";
export default {
  name: "",
  props: {},
  components: { MainForm },
  data() {
    return {
      moduleFormData: {},
      treeData: [
        {
          title: "系统模块",
          id: 0,
          level: 0,
          expand: true,
          render: (h, { root, node, data }) => {
            return h(
              "span",
              { style: { display: "inline-block", width: "100%" } },
              [
                h("span", { style: { fontWeight: "bold" } }, data.title),
                h(
                  "Button",
                  {
                    props: { size: "small", type: "primary" },
                    style: {
                      marginLeft: "24px",
                      width: "64px",
                      float: "right"
                    },
                    on: {
                      click: () => {
                        this.addModule(root, node, data);
                      }
                    }
                  },
                  "添加模块"
                )
              ]
            );
          },
          children: []
        }
      ],
      showModal: false,
      editModuleId: null,
      modulePid: 0,
      curNodeData: []
    };
  },
  methods: {
    // 子模块渲染
    renderContent(h, { root, node, data }) {
      let buttons = [
        h("Button", {
          props: {
            type: "default",
            size: "small",
            icon: "ios-remove"
          },
          on: {
            click: () => {
              this.removeModule(root, node, data);
            }
          }
        })
      ];
      if (data.level === 1) {
        let tempButton = h("Button", {
          props: {
            type: "default",
            size: "small",
            icon: "ios-add"
          },
          style: {
            marginRight: "8px"
          },
          on: {
            click: () => {
              this.addModule(root, node, data);
            }
          }
        });
        buttons.unshift(tempButton);
      }
      var contentNode = [h("span", { class: "tree-li-title" }, data.title)];
      if (data.level === 2) {
        contentNode.push(h("span", { class: ["tree-li-price"] }, `${data.price}元/年`));
      }
      return h(
        "span",
        { class: "tree-li" },
        contentNode.concat([
          h(
            "span",
            {
              style: {
                display: "inline-block",
                textAlign: "right",
                float: "right"
              }
            },
            buttons
          )
        ])
      );
    },
    addModule(root, node, data) {
      this.showModal = true;
      this.modulePid = parseInt(data.id);
      this.curNodeData = data;
    },
    // 删除模块
    removeModule(root, node, data) {
      // console.log(data);
      if (typeof data.children !== "undefined" && data.children.length > 0) {
        this.$Message.error("有子模块不可删除");
        return;
      }
      this.$Modal.confirm({
        title: "确认删除？",
        onOk: () => {
          axios
            .request({
              url: "Mokuai/deleteone",
              params: { id: data.id },
              method: "get"
            })
            .then(res => {
              const parentKey = root.find(el => el === node).parent;
              const parent = root.find(el => el.nodeKey === parentKey).node;
              const index = parent.children.indexOf(data);
              parent.children.splice(index, 1);
            });
        }
      });
    },

    // 模块保存成功
    handleSaved(e) {
      var curNodeData = this.curNodeData;
      this.showModal = false;
      const children = curNodeData.children || [];
      let newData = e.data.info;
      newData.level = curNodeData.level + 1;
      newData.expand = true;
      children.push(newData);
      this.$set(curNodeData, "children", children);
    },
    hanldeCancelSave() {
      this.showModal = false;
    },
    handleEdit(params) {
      const id = params.row.id;
      this.$router.push({ name: "event_edit", params: { id } });
    }
  },
  computed: {},
  mounted() {
    axios
      .request({
        url: "Mokuai/vlist",
        method: "get"
      })
      .then(res => {
        let oldTreeData = this.treeData;
        this.treeData[0].children = res.data.list;
      });
  }
};
</script>

<style>
.tree-li {
  display: inline-block;
  width: 100%;
}
.tree-li-title {
  display: inline-block;
  width: 200px;
}
.tree-li-price {
  font-weight: bold;
}
</style>