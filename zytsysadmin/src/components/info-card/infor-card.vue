<template>
  <Card :shadow="shadow" class="info-card-wrapper" :style="{background: color}" :padding="0">
    <div class="content-con">
      <div class="left-area">
        <div>
          <slot></slot>
        </div>
      </div>
      <div class="right-area">
        <common-icon class="icon" :type="icon" :size="iconSize" color="#fff"/>
      </div>
    </div>
  </Card>
</template>

<script>
import CommonIcon from '_c/common-icon'
export default {
  name: 'InforCard',
  components: {
    CommonIcon
  },
  props: {
    left: {
      type: Number,
      default: 36
    },
    color: {
      type: String,
      default: '#2d8cf0'
    },
    icon: {
      type: String,
      default: ''
    },
    iconSize: {
      type: Number,
      default: 20
    },
    shadow: {
      type: Boolean,
      default: false
    }
  },
  computed: {

  }
}
</script>

<style lang="less">
.common{
  position: absolute;
  top: 20px;
  height: 100%;
  display: table;
}
.size{
  width: 100%;
  height: 100%;
}
.middle-center{
  display: table-cell;
  vertical-align: middle;
}
.info-card-wrapper{
  .size;
  overflow: hidden;
  color:#fff;
  .ivu-card-body{
    .size;
  }
  .content-con{
    .size;
    position: relative;
    .right-area{
      .common;
      right: 0px;
      width:36%;
      & > .icon{
        opacity:.3;
      }
    }
    .left-area{
      .common;
      left: 20px;
      width:64%;
    }
  }
}
</style>
