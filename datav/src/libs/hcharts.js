/*
 * @Author: Joy wang
 * @Date: 2021-05-15 19:31:30
 * @LastEditTime: 2021-05-15 19:57:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Highcharts from 'highcharts/highstock';
import HighchartsMore from 'highcharts/highcharts-more';
import HighchartsDrilldown from 'highcharts/modules/drilldown';
import Highcharts3D from 'highcharts/highcharts-3d';
HighchartsMore(Highcharts)
HighchartsDrilldown(Highcharts);
Highcharts3D(Highcharts);

Highcharts.setOptions({})

export default Highcharts
