/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-14 11:23:01 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-08-18 23:21:52
 */
<template>
<div>
  <input 
  type="file" 
  ref="input" 
  :maxSize="maxSize"
  :format="format"
  :multiple="multiple" 
  @change="handleChange" 
  style="display:none">

  <div class="m-upload-wrap">
    <div class="file-list">
      <div v-bind:class="[type+'-item']" v-for="(item, index) in fileList" :key="item.name">
        <template v-if="type == 'file'">
          <div class="file-name">{{item.name}}</div>
          <div class="operation-box">
            <span>删除</span>
          </div>        
        </template>
        <template v-else>
          <div class="img-box"><img :src="item.url" alt=""></div>
          <div class="operation-box">
            <span @click="handleView(item)" style="margin-right:5px" class="handel-btn">预览</span>
            <Poptip
              confirm
              title="确认删除此图片？"
              @on-ok="handleRemove(index)">
              <span class="handel-btn">删除</span>
            </Poptip>
          </div>          
        </template>
      </div>
    </div>
    <div class="upload-btn" @click="handleSelect" v-show="canAddFile">
      <Icon size="32" type="plus-circled"></Icon>
    </div>
  </div>

  <template v-if="type === 'img'">
    <Modal v-model="showImgView" title="预览">
      <div class="view-img-box">
        <img :src="viewImg.url" :alt="viewImg.name" />
      </div>
    </Modal>
  </template>
</div>
</template>
<script>
import config from "@/config";
import OSS from '@/libs/alioss'
const OSS_URL_BASE = config.aliOss.url

export default {
  props: {
    dir: {
      type: String,
      default: ""
    },
    type: {
      type: String, //img || file
      default: "file"
    },
    multiple: {
      type: Boolean,
      default: false
    },
    format: {
      type: Array,
      default() {
        return [];
      }
    },
    maxSize: {
      type: Number,
      default: 2048
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
      this.uploadFiles(files);
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
      // 待优化，如果是编辑模式，删除应该在保存数据以后进行
      const vm = this;
      let file = this.fileList[index];
      let objectKey = (this.dir == "" ? this.dir : this.dir + "/") + file.name;
      async function deleteFile() {
        try {
          let result = await OSS.delete(objectKey);
          if (result.res) {
            vm.fileList.splice(index, 1);
            let filesName = vm.fileList.map(item => item.name).join(",");
            vm.$emit("file-changed", filesName);
          }
        } catch (e) {
          console.log(e);
        }
      }
      deleteFile();
    },
    onFileError(file, error) {
      this.$Notice.error({
        title: "错误提示",
        desc: file.name + error
      });
    },
    uploadFiles(files) {
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
    upload(file) {
      let index = this.fileList.length;
      if (this.format.length) {
        // check format
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
      }

      // check maxSize
      if (this.maxSize) {
        if (file.size > this.maxSize * 1024) {
          this.onFileError(file, "超出最大限制");
          return false;
        }
      }

      // check the some file
      let isSome = this.fileList.some(item => item.name == file.name);
      if (isSome) {
        this.onFileError(file, "文件已经存在");
        return false;
      }

      let fileItem = {
        name: file.name,
        finished: false,
        type: this.type
      };

      // if is image,create img thumb view
      if (this.type == "img") {
        let imgReader = new FileReader();
        imgReader.readAsDataURL(file);
        imgReader.onload = e => {
          fileItem.url = e.currentTarget.result;
          this.fileList.push(fileItem);
        };
      } else {
        this.fileList.push(fileItem);
      }

      let fileReader = new FileReader();
      let vm = this;
      let objectKey = (this.dir == "" ? this.dir : this.dir + "/") + file.name;
      fileReader.readAsArrayBuffer(file);
      fileReader.onload = e => {
        let fileBlob = e.currentTarget.result;
        // start upload
        async function put() {
          try {
            let result = await OSS.put(objectKey, new Buffer(fileBlob));
            // update upload list
            if (result) {
              vm.fileList[index].finished = true;
              let filesName = vm.fileList.map(item => item.name).join(",");
              vm.$emit("file-changed", filesName);
            }
          } catch (e) {
            console.log(e);
          }
        }
        put();
      };


    },
    _setFileList(){
    let newFileList = []
    if(this.initFileList.length > 0){
      let dir = this.dir === '' ? this.dir : (this.dir + '/')
      newFileList = this.initFileList.map(item => {
        return {
          name: item,
          url: OSS_URL_BASE + dir + item
        }
      })
    }
    this.fileList = newFileList
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
    'initFileList':function(newValue){
      this._setFileList()
    }
  },
  mounted() {
    // update file list
    this._setFileList()
    // end update file list

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
</style>

