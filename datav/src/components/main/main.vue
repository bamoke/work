<!--
 * @Author: Joy wang
 * @Date: 2021-05-06 12:30:09
 * @LastEditTime: 2021-06-01 10:48:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<template>
<<<<<<< HEAD
  <div style="width:100%;height:100%;">
        <video
=======
  <div style="width: 100%; height: 100%">
    <video
      v-if="showBgVideo"
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
      x5-video-player-type="h5"
      playsinline=""
      webkitplaysinline="true"
      width="1920"
      height="1080"
      autoplay
      loop
      src="/assets/bg-effects.mp4"
      poster=""
      x5-playsinline=""
      webkit-playsinline=""
      controlslist="nodownload"
      class="bg-video"
      style="
        width: 100%;
        height: 100%;
        object-fit: fill;
        opacity: 1;
        transform: none;
      "
    ></video>
    <HeadBar></HeadBar>
    <router-view></router-view>
  </div>
</template>

<script>
import HeadBar from "@/components/main/header-bar.vue";
export default {
  name: "Main",
  components: {
    HeadBar,
  },
<<<<<<< HEAD
=======
  data() {
    return {
      key: "value",
    };
  },
  computed: {
    showBgVideo() {
      return this.$store.state.theme.showBgVideo;
    },
  },
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
  mounted() {},
};
</script>

<style lang="less">
<<<<<<< HEAD


=======
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
*:before,
*:after {
  box-sizing: border-box;
}
<<<<<<< HEAD


=======
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
</style>