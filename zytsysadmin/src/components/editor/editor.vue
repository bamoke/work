<template>
  <div class="editor-wrapper">
    <div :id="editorId"></div>
  </div>
</template>

<script>
import Cookies from 'js-cookie'
import { TOKEN_KEY } from '@/libs/util'
import Editor from "wangeditor";
import "wangeditor/release/wangEditor.min.css";
import { oneOf } from "@/libs/tools";
export default {
  name: "Editor",
  props: {
    value: {
      type: String,
      default: ""
    },
    /**
     * 绑定的值的类型, enum: ['html', 'text']
     */
    valueType: {
      type: String,
      default: "html",
      validator: val => {
        return oneOf(val, ["html", "text"]);
      }
    },
    /**
     * reset menu
     */
    menus: {
      type: Array,
      default: []
    },
    /**
     * @description 设置change事件触发时间间隔
     */
    changeInterval: {
      type: Number,
      default: 200
    },
    /**
     * @description 是否开启本地存储
     */
    cache: {
      type: Boolean,
      default: false
    },
    uploadUrl: {
      type: String,
      default: ""
    }
  },
  computed: {
    editorId() {
      return `editor${this._uid}`;
    }
  },
  watch: {
    value: function(newValue) {
      if (this.valueType === "html") {
        this.editor.txt.html(newValue);
      } else {
        this.editor.txt.text(newValue);
      }
    }
  },
  mounted() {
    this.editor = new Editor(`#${this.editorId}`);
    if (this.uploadUrl) {
      this.editor.customConfig.uploadImgServer = this.uploadUrl;
      this.editor.customConfig.uploadFileName = "img";
      this.editor.customConfig.uploadImgHeaders = {
        "x-access-token": Cookies.get(TOKEN_KEY)
      };
    }
    this.editor.customConfig.onchange = html => {
      let text = this.editor.txt.text();
      if (this.cache) localStorage.editorCache = html;
      this.$emit("input", this.valueType === "html" ? html : text);
      this.$emit("on-change", html, text);
    };
    this.editor.customConfig.onchangeTimeout = this.changeInterval;
    if (this.menus.length > 0) {
      this.editor.customConfig.menus = this.menus;
    }
    // create这个方法一定要在所有配置项之后调用
    this.editor.create();

    // 如果本地有存储加载本地存储内容
    // let html = localStorage.editorCache;
    // if (html) this.editor.txt.html(html);
  }
};
</script>

<style>
[class*=" w-e-icon-"],
[class^="w-e-icon-"] {
  font-size: 14px;
}
</style>
