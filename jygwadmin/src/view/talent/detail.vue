<template>
  <Card :title="title">
    <Row>
      <Col span="8">姓名：</Col>
      <Col span="8"></Col>
    </Row>
    <Row>
      <Col span="8">手机号：</Col>
      <Col span="8"></Col>
    </Row>
  </Card>
</template>
<script>
export default {
  data() {
    return {
      title: "s"
    };
  }
};
</script>