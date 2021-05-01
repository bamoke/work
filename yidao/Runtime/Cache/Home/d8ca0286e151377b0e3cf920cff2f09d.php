<?php if (!defined('THINK_PATH')) exit();?><!--
 * @Author: Joy wang
 * @Date: 2021-04-14 09:50:30
 * @LastEditTime: 2021-05-01 15:24:06
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>报名</title>

    <script src="//vuejs.org/js/vue.min.js"></script>
    <!-- import stylesheet -->
    <link rel="stylesheet" href="//unpkg.com/view-design/dist/styles/iview.css">
    <!-- import iView -->
    <script src="//unpkg.com/view-design/dist/iview.min.js"></script>
    <script src="//unpkg.com/axios/dist/axios.min.js"></script>

    <style>
        html,
        body {
            background-color: #f8f8f8;
        }

        #app {
            margin: 0 auto;
            width: 1280px;
        }

        .table-ft {
            padding-top: 24px;
        }
        .table-hd {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>
    <div id="app">
        <Card>
            <div slot="title"  class="table-hd">
                <h2>报名表</h2>
                <i-button icon="ios-download-outline" type="primary" @click="handleDownload">导出EXCEL文件</i-button>
            </div>
            <i-table border :columns="columns" :data="tableData"></i-table>
            <div class="table-ft">
                <Page :total="pageInfo.total" :page-size="pageInfo.pageSize" show-total @on-change="handleChangePage" />
            </div>
        </Card>
    </div>

</body>

</html>
<script>
    new Vue({
        el: '#app',
        data: {
            columns: [
                {
                    title: "姓名",
                    key: "name",
                    width: 120
                },
                {
                    title: "工作单位",
                    key: "company",
                    width: 220
                },
                {
                    title: "职务",
                    key: "position",
                    width: 160
                },
                {
                    title: "职称",
                    key: "title",
                    width: 160
                },
                {
                    title: "手机号码",
                    key: "phone",
                    width: 140
                },
                {
                    title: "是否需要午餐",
                    render: (h, params) => {
                        var color = '#c5c8ce', type = 'ios-close', text = '否'
                        if (params.row.lunch == 1) {
                            color = '#19be6b'
                            type = 'ios-checkmark'
                            text = '是'
                        }
                        return h('Icon', {
                            props: {
                                size: 24,
                                type,
                                color
                            }
                        }, text)
                    },
                    width: 80
                },
                {
                    title: "反馈建议",
                    key: "feedback"
                },

            ],
            tableData: [],
            pageInfo: {
                total: 100,
                pageSize: 20,
                page: 1
            }
        },
        methods: {
            show: function () {
                this.visible = true;
            },
            handleDownload(){
                window.open('<?php echo U("download");?>')
            },
            handleChangePage(e){
                axios.get("<?php echo U('enrol_data');?>",{params:{page:e}}).then(result => {
                const res = result.data
                this.tableData = res.data.list
                this.pageInfo = res.data.pageInfo
            })
            }
        },
        mounted() {
            axios.get("<?php echo U('enrol_data');?>").then(result => {
                const res = result.data
                if(res.code == 200) {
                    this.tableData = res.data.list
                    this.pageInfo = res.data.pageInfo
                }else {
                    this.$Message.warning({content:res.msg})
                }
            })
        }
    })
</script>