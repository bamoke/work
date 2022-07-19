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
// import dataV from '@jiaminghi/data-view'
import router from './router'
import ModuleCard from "@/components/main/module-card.vue"
import Trend from "@/components/trend"
import SwitchBtn from "@/components/switchbtn"
import BcountUp from "@/components/count-up"



import { ButtonGroup, Button,Dropdown,DropdownMenu,DropdownItem, Table,Icon,Circle ,Row,Col,Carousel,CarouselItem,Spin} from 'view-design';
import 'view-design/dist/styles/iview.css';

import 'echarts-gl';
import echarts from '@/libs/echarts'
Vue.prototype.$echarts = echarts

// 注入配置
Vue.prototype.$config = Config



// 自定义组件
Vue.component('Trend', Trend);
Vue.component('BcountUp', BcountUp);
Vue.component('SwitchBtn', SwitchBtn);
Vue.component("ModuleCard",ModuleCard)



//iview 组件
Vue.component('ButtonGroup', ButtonGroup);
Vue.component('Button', Button);
Vue.component('Dropdown', Dropdown);
Vue.component('DropdownMenu', DropdownMenu);
Vue.component('DropdownItem', DropdownItem);
Vue.component('Table', Table);
Vue.component('Vcircle', Circle);
Vue.component('Icon', Icon);
Vue.component('Row', Row);
Vue.component('Col', Col);
Vue.component('Carousel', Carousel);
Vue.component('CarouselItem', CarouselItem);
Vue.component('Spin', Spin);

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
