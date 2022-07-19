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
import TownMap from "@/components/common/town-map.vue"
import echartTheme from "@/config/echarts-theme.js"

const chartMixin = {
    components: {
        ChartMonth, ChartYear, ChartCompareCounty, ChartCompareDomestic,EffectCircleCount3D,TownMap
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
                        text: "",
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
            chartObject = this.$echarts,
            chartName = [],
        }) {
            /**图表初始化 */
            var echartInstance = {};
 
            const appTheme = this.$store.state.theme
            chartName.forEach(function (item, index) {
                echartInstance[item] = chartObject.init(
                    document.getElementById(`chart-${item}`), appTheme.echartTheme
                );
            });

            this.echartInstance = echartInstance;
        },
    },
    mounted () {

    },

};

export default chartMixin
