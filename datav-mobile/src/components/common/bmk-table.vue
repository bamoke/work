<template>
  <div class="">
    <table border="0" cellpadding="0" cellspacing="0" class="bmk-table">
      <tr>
        <th v-for="(value, index) of columns" :key="index">{{ value }}</th>
      </tr>
      <tr v-for="(item, index) of data" :key="index">
        <td v-for="(val, name) in item" :key="name">{{ val }}</td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    columns: {
      type: Array,
      default: function () {
        return [];
      },
    },
    data: {
      type: Array,
      default: function () {
        return [];
      },
    },
  },
};
</script>

<style lang="less" scoped>
.bmk-table {
  margin: 0;
  padding: 0;
  width: 100%;
  tr:last-child td {
    border-bottom: 1px solid #dfedf6;
  }
  tr:nth-child(2n + 1) td {
    background-color: #f2f9fe;
  }
  th {
    padding: 0.0625rem;
    text-align: left;
    border-left: 1px solid #dfedf6;
    border-top: 1px solid #dfedf6;
    background-color: #e2f3fe;
  }
  th:last-child {
    border-right: 1px solid #dfedf6;
  }
  td {
    padding: 8px 12px;
    text-align: left;
    border-left: 1px solid #dfedf6;
    border-top: 1px solid #dfedf6;
  }
  td:last-child {
    border-right: 1px solid #dfedf6;
  }
}
</style>