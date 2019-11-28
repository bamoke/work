<template>
  <div class="editor-wrapper">
    <div :id="editorId"></div>
  </div>
</template>

<script>
import Cookies from "js-cookie";
import { TOKEN_KEY } from "@/libs/util";
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
  methods: {
    setHtml(val) {
      this.editor.txt.html(val);
    }
  },
  mounted() {
    this.editor = new Editor(`#${this.editorId}`);

    if (this.uploadUrl) {
      this.editor.customConfig.uploadImgServer = this.uploadUrl;
      this.editor.customConfig.uploadFileName = "img";
      this.editor.customConfig.uploadImgMaxSize = 2 * 1024 * 1024
      this.editor.customConfig.uploadImgHeaders = {
        "x-access-token": Cookies.get(TOKEN_KEY)
      }
    }
    this.editor.customConfig.menus = [
        'head',
        'bold',
        'italic',
        'underline',
        'justify',
        'image',  
        // 'table',  
        'undo',
        'redo'
    ]
    this.editor.customConfig.zIndex = 99
    this.editor.customConfig.onchange = html => {
      let text = this.editor.txt.text();
      if (this.cache) localStorage.editorCache = html;
      // 每次触发change事件都上报事件，会产生光标变动，因为都是同一数据源，注释“input”事件上报,v-model数据双向绑定
      // 通过on-change去设置内容
      // this.$emit("input", this.valueType === "html" ? html : text);
      this.$emit("on-change", html, text);
    };
    this.editor.customConfig.onchangeTimeout = this.changeInterval;
    // create这个方法一定要在所有配置项之后调用
    this.editor.create();
    // 如果本地有存储加载本地存储内容
    // let html = this.value || localStorage.editorCache;
    let html = this.value ;
    if (html) this.editor.txt.html(html);
  }
};
</script>

<style lang="less">

</style>
