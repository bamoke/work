/*
 * @Author: Joy wang
 * @Date: 2021-05-05 18:32:55
 * @LastEditTime: 2021-06-02 02:54:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Vue from 'vue'
<<<<<<< HEAD
import App from './App.vue'
import Config from "@/config"
// import dataV from '@jiaminghi/data-view'
import router from './router'
import ModuleCard from "@/components/main/module-card.vue"
=======
import App from './App-mobile.vue'
import Config from "@/config"
import router from '@/router'
import ModuleCard from "@/components/main/module-card-mobile.vue"
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
import Trend from "@/components/trend"
import SwitchBtn from "@/components/switchbtn"
import BcountUp from "@/components/count-up"

<<<<<<< HEAD
=======
import store from "@/store"

>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3


import { ButtonGroup, Button,Dropdown,DropdownMenu,DropdownItem, Table,Icon,Circle ,Row,Col,Carousel,CarouselItem,Spin} from 'view-design';
import 'view-design/dist/styles/iview.css';

import 'echarts-gl';
import echarts from '@/libs/echarts'
<<<<<<< HEAD
Vue.prototype.$echarts = echarts

=======
import echartTheme from "@/config/echarts-theme.js"

Vue.prototype.$echarts = echarts



>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
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
<<<<<<< HEAD
=======
  store,
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
  render: h => h(App),
}).$mount('#app')
