/*
 * @Author: Joy wang
 * @Date: 2021-05-18 18:51:45
 * @LastEditTime: 2021-05-31 02:00:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import * as Api from "@/api/index";
import { ChartMonth, ChartYear, ChartCompareCounty, ChartCompareDomestic } from "@/components/bmk-chart"
import EffectCircleCount3D from "@/components/effects/effect-circle-count-3d.vue";
<<<<<<< HEAD
=======
import echartTheme from "@/config/echarts-theme.js"
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3

const chartMixin = {
    components: {
        ChartMonth, ChartYear, ChartCompareCounty, ChartCompareDomestic,EffectCircleCount3D
    },
    data() {
        return {
            leijizengzhangData: {},
            timelineYearData: {},
            compareCountyData: {},
            compareDomesticData: {},
        }
    },
    methods: {
        handleChangeRise(e) {
            Api.timeline.get_monthdata({ params: { cate: e } }).then((res) => {
                this.leijizengzhangData = {
                    title: {
                        text: "2020年3-2021年3月",
                    },
                    data: res.data,
                };
            });
        },
        handleChangeCompareCounty(e,dataName) {
            var chartDataName  
            if(typeof dataName !=='undefined') {
                chartDataName = dataName
            }else {
                chartDataName = "compareCountyData"
            }
            this[chartDataName].mode = e
        },
        handleChangeYearMode(e,dataName) {
            var chartDataName  
            if(typeof dataName !=='undefined') {
                chartDataName = dataName
            }else {
                chartDataName = "timelineYearData"
            }
            this[chartDataName].mode = e
        },
        chartInit({
<<<<<<< HEAD
            themeName = this.$config.chartTheme,
=======
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
            chartObject = this.$echarts,
            chartName = [],
        }) {
            /**图表初始化 */
            var echartInstance = {};
<<<<<<< HEAD
            chartName.forEach(function (item, index) {
                echartInstance[item] = chartObject.init(
                    document.getElementById(`chart-${item}`),
                    themeName
=======
 
            // const echartThemName = this.$store.state.theme.echartTheme;
            // chartObject.registerTheme(echartThemName, echartTheme[echartThemName]);
            chartName.forEach(function (item, index) {
                echartInstance[item] = chartObject.init(
                    document.getElementById(`chart-${item}`),"macarons"
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
                );
            });

            this.echartInstance = echartInstance;
        },
    },
<<<<<<< HEAD
=======
    mounted () {

    },
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3

};

export default chartMixin
