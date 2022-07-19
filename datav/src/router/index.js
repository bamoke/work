/*
 * @Author: Joy wang
 * @Date: 2021-05-06 10:40:06
 * @LastEditTime: 2021-05-06 12:37:38
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Vue from 'vue'
import Router from 'vue-router'
<<<<<<< HEAD
import routes from './routers'
=======
<<<<<<< HEAD
import routes from './routers'
=======
import routes from './routers-mobile'
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
>>>>>>> 23d6d38042cc57823cacef462cf8fdc01e79e502
// import store from '@/store'
// import iView from 'iview'
// import { setToken, getToken, canTurnTo, setTitle } from '@/libs/util'
// import config from '@/config'

Vue.use(Router)
const router = new Router({
  routes,
  mode: 'history'
})
const LOGIN_PAGE_NAME = 'login'


router.beforeEach((to, from, next) => {
  next()
})

router.afterEach(to => {
  window.scrollTo(0, 0)
})

export default router
