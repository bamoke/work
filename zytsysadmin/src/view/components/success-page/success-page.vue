<template>
  <Card dis-hover>
    <slot>
      <div class="success-page-wrap">
        <Icon type="checkmark-circled" size="64" color="#19be6b"/>
        <h2 class="tips-text s-text-success">操作成功</h2>
      </div>
    </slot>
  </Card>
</template>
<script>
  export default {
    data(){
      return {

      }
    }
  }
</script>
<style>
.success-page-wrap {padding:40px 0;text-align: center;}
.success-page-wrap .tips-text {margin-top:20px;}
</style>

