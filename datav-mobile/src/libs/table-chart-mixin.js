/*
 * @Author: Joy wang
 * @Date: 2021-05-18 18:51:45
 * @LastEditTime: 2021-05-31 02:00:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */


const tableChartMixin = {
    props: {
        vmode: {
            type: String,
            default: "chart",
        },
        cmode: {
            type: String,
            default: "gross"
        },
        height: {
            type: Number,
            default: 200,
        },
        title: {
            type: Object,
            default: function () {
                return {};
            },
        },
        mdata: {
            type: Object,
            default: function () {
                return {};
            },
        },
    },

    data() {
        return {
            activeClass: "show-chart",
            tableColumn: [],
            tableData: [],
            chartData: [],
        }
    },


    mounted() {

    },
    watch: {
        vmode(newValue) {
            if (newValue) {
                if (newValue == "table") {
                    this.activeClass = "show-table";
                    // this.drawEchart();
                } else {
                    this.activeClass = "show-chart";
                }
            }
        },
        cmode(newValue) {
            if (newValue) {
                this.drawChart()
            }
        },
        mdata(newValue, oldValue) {
            if (newValue) {
                this.tableData = newValue.tableData
                this.tableColumn = newValue.tableColumn
                this.chartData = this.$formatTableToChart(newValue.tableData, newValue.tableColumn)
                this.drawChart()
            }
        },
    },
    mounted() {
        const appTheme = this.$store.state.theme;
        this.chartInstance = this.$echarts.init(
            document.getElementById(this.chartId),
            appTheme.echartTheme
        );
    },

};

export default tableChartMixin
