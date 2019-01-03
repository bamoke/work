<template>
  <div class="m-node-list">
    <div class="node-item" v-for="(item,index) in nodeList" :key="index">
      {{item.title}}
    </div>
  </div>
</template>
<script>
import { getDataOne } from '@/api/data'
export default {
  data () {
    return {
      discussId: null,
      nodeList: []
    }
  },
  mounted () {
    const discussId = this.$route.params.disid
    this.discussId = discussId

  }
}
</script>
