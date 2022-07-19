/*
 * @Author: Joy wang
 * @Date: 2021-05-05 18:32:55
 * @LastEditTime: 2021-06-02 02:54:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Vue from 'vue'
import App from './App.vue'
import Config from "@/config"
import router from '@/router'


import store from "@/store"

import 'echarts-gl';
import echarts from '@/libs/echarts'
import echartTheme from "@/config/echarts-theme.js"

Vue.prototype.$echarts = echarts

/***
 * iview
 * 按需引入
 */
 import {Table,Scroll } from 'view-design';
 import 'view-design/dist/styles/iview.css';
 Vue.component('Table', Table);
 Vue.component('Scroll', Scroll);


// vant
import '@vant/touch-emulator';
import { Icon,DatetimePicker,Button,Popup,Row,Col,RadioGroup,Radio,Loading ,Search,Dialog,Grid, GridItem,Image as VanImage,Tab,Tabs,Form,Field } from 'vant';
import 'vant/lib/index.less';
Vue.use(Icon);
Vue.use(DatetimePicker);
Vue.use(Button);
Vue.use(Popup);
Vue.use(Row);
Vue.use(Col);
Vue.use(Radio);
Vue.use(RadioGroup);
Vue.use(Loading);
Vue.use(Search);
Vue.use(Grid);
Vue.use(GridItem);
Vue.use(VanImage);
Vue.use(Tab);
Vue.use(Tabs);
Vue.use(Form);
Vue.use(Field);



// 注入配置
Vue.prototype.$config = Config



// 自定义组件
import ModuleCard from "@/components/main/module-card.vue"
import Trend from "@/components/trend"
import SwitchBtn from "@/components/switchbtn"
import BcountUp from "@/components/count-up"
import BmkTable from "@/components/common/bmk-table.vue";
import BmkTitleTotal from "@/components/common/bmk-title-total.vue";
Vue.component('Trend', Trend);
Vue.component('BcountUp', BcountUp);
Vue.component('SwitchBtn', SwitchBtn);
Vue.component("ModuleCard",ModuleCard)
Vue.component("BmkTable",BmkTable)
Vue.component("BmkTitleTotal",BmkTitleTotal)

import tableDataToChart from "@/libs/tabletochart.js";
Vue.use(tableDataToChart)



//iview 组件
// Vue.component('ButtonGroup', ButtonGroup);
// Vue.component('Button', Button);
// Vue.component('Dropdown', Dropdown);
// Vue.component('DropdownMenu', DropdownMenu);
// Vue.component('DropdownItem', DropdownItem);
// Vue.component('Table', Table);
// Vue.component('Vcircle', Circle);
// Vue.component('Icon', Icon);
// Vue.component('Row', Row);
// Vue.component('Col', Col);
// Vue.component('Carousel', Carousel);
// Vue.component('CarouselItem', CarouselItem);
// Vue.component('Spin', Spin);

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')
