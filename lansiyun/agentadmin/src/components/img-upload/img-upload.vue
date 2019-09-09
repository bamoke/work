/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-14 11:23:01 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2019-05-22 02:02:45
 */
<template>
  <div>
    <input
      type="file"
      ref="input"
      :maxSize="maxSize"
      :multiple="multiple"
      @change="handleChange"
      style="display:none"
    >

    <div class="m-upload-wrap">
      <div class="file-list">
        <div class="img-item" v-for="(item, index) in fileList" :key="item.name">
          <div class="img-box">
            <img :src="item.url" alt>
          </div>
          <div class="operation-box">
            <span @click="handleView(item)" style="margin-right:5px" class="handel-btn">预览</span>
            <Poptip confirm title="确认删除此图片？" @on-ok="handleRemove(index)">
              <span class="handel-btn">删除</span>
            </Poptip>
          </div>
        </div>
      </div>
      <div class="upload-btn" @click="handleSelect" v-show="canAddFile">
        <Icon type="ios-add-circle" size="32"/>
      </div>
    </div>

    <Modal v-model="showImgView" title="预览">
      <div class="view-img-box">
        <img :src="viewImg.url" :alt="viewImg.name">
      </div>
    </Modal>
  </div>
</template>
<script>
import config from "@/config";
import axios from "@/libs/api.request";
export default {
  props: {
    uploadUrl: {
      type: String,
      default: ""
    },
    deleteUrl: {
      type: String,
      default: ""
    },
    multiple: {
      type: Boolean,
      default: false
    },
    maxSize: {
      type: Number,
      default: 2
    },
    initFileList: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  data() {
    return {
      format: ["jpg", "png", "gif", "jpeg"],
      fileList: [],
      showImgView: false,
      viewImg: {}
    };
  },
  methods: {
    handleSelect() {
      this.$refs.input.click();
    },
    handleChange(e) {
      const files = e.target.files;
      if (!files) {
        return;
      }
      this.uploadImages(files);
      this.$refs.input.value = null;
    },
    handleView(file) {
      let url = file.url;
      this.showImgView = true;
      this.viewImg = {
        name: file.name,
        url: file.url
      };
    },
    handleRemove(index) {
      let curItem = this.fileList[index];
      axios
        .request({
          url: this.deleteUrl,
          params: { filename: curItem.name },
          method: "get"
        })
        .then(res => {
          let filenameList;
          this.fileList.splice(index, 1);
          filenameList = this.fileList.map(item => {
            return item.name;
          });
          this.$emit("file-changed", filenameList.join(";"));
        });
    },
    onFileError(file, error) {
      this.$Notice.error({
        title: "错误提示",
        desc: file.name + error
      });
    },
    uploadImages(files) {
      let postFiles = Array.prototype.slice.call(files);
      if (postFiles.length === 0) return;
      if (!this.multiple) {
        postFiles = postFiles.slice(0, 1);
      } else {
        postFiles = postFiles.slice(0, 5);
      }

      postFiles.forEach(file => {
        this.upload(file);
      });
    },

    // 上传图片
    upload(file) {
      const _file_format = file.name
        .split(".")
        .pop()
        .toLocaleLowerCase();
      const checked = this.format.some(
        item => item.toLocaleLowerCase() === _file_format
      );
      if (!checked) {
        this.onFileError(file, "文件格式不正确");
        return false;
      }

      // check maxSize
      if (file.size > this.maxSize * 1024 * 1024) {
        this.onFileError(file, "图片大小不能超过" + this.maxSize + "M");
        return false;
      }

      let imgReader = new FileReader();
      imgReader.readAsDataURL(file);
      imgReader.onload = e => {
        let curFormData = new FormData();
        curFormData.append("img", file);
        axios
          .request({
            url: this.uploadUrl,
            data: curFormData,
            method: "post"
          })
          .then(res => {
            var filenameList;
            if (res.errno === 0) {
              this.fileList.push({ name: res.filename, url: res.data[0] });
              filenameList = this.fileList.map(item => {
                return item.name;
              });
              this.$emit("file-changed", filenameList.join(";"));
            }
          });
      };
    }
  },
  computed: {
    canAddFile() {
      if (!this.multiple) {
        return this.fileList.length === 0;
      }
      return this.fileList.length <= 5;
    }
  },
  watch: {
    initFileList: function(newValue) {
      this.fileList = newValue
    }
  },
  mounted() {
    this.fileList = this.initFileList
  }
};
</script>
<style>
.view-img-box {
  text-align: center;
}
.view-img-box img {
  max-width: 100%;
}

.m-upload-wrap {
  display: flex;
  justify-content: flex-start;
  align-items: center;
}
.m-upload-wrap .upload-btn {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 64px;
  height: 64px;
  line-height: 60px;
  text-align: center;
  border: 1px dashed #9c9c9c;
  color: #9c9c9c;
}
.upload-btn:hover {
  /* color: @primary-color; */
  /* border-color: @primary-color; */
  cursor: pointer;
}
.file-list {
  display: inline-block;
}
.file-list .img-item {
  display: inline-block;
  position: relative;
  margin-right: 12px;
  padding: 2px;
  box-sizing: border-box;
  min-width: 64px;
  height: 64px;
  border: 1px solid #eee;
  vertical-align: middle;
}
.img-box {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}
.img-box img {
  max-width: 128px;
}
.operation-box {
  display: none;
  position: absolute;
  left: 0;
  top: 0;
  z-index: 1;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}
.handel-btn {
  cursor: pointer;
  color: #fff;
}
.img-item:hover .operation-box {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>

