/*
 * @Author: Joy wang
 * @Date: 2021-05-06 10:40:06
 * @LastEditTime: 2021-05-28 09:37:30
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Main from '@/components/common/main'
// import config from '@/config'
const webBaseUrl = ""

/**
 * iview-admin中meta除了原生参数外可配置的参数:
 * meta: {
 *  title: { String|Number|Function }
 *         显示在侧边栏、面包屑和标签栏的文字
 *         使用'{{ 多语言字段 }}'形式结合多语言使用，例子看多语言的路由配置;
 *         可以传入一个回调函数，参数是当前路由对象，例子看动态路由和带参路由
 *  hideInBread: (false) 设为true后此级路由将不会出现在面包屑中，示例看QQ群路由配置
 *  hideInMenu: (false) 设为true后在左侧菜单不会显示该页面选项
 *  notCache: (false) 设为true后页面在切换标签后不会缓存，如果需要缓存，无需设置这个字段，而且需要设置页面组件name属性和路由配置的name一致
 *  access: (null) 可访问该页面的权限数组，当前路由设置的权限会影响子路由
 *  icon: (-) 该页面在左侧菜单、面包屑和标签导航处显示的图标，如果是自定义图标，需要在图标名称前加下划线'_'
 *  beforeCloseName: (-) 设置该字段，则在关闭当前tab页时会去'@/router/before-close.js'里寻找该字段名对应的方法，作为关闭前的钩子函数
 *  hideTagNav : (false) 设为true，则不会加入到路由列表与Tag导航中//by wangyi 20190903
 * }
 */

export default [
  {
    path: webBaseUrl + '/',
    name: 'home',
    redirect: '/home',
    component: Main,
    meta: {
      hideInMenu: true,
      notCache: true
    },
    children: [
      {
        path: webBaseUrl + '/home',
        name: 'home',
        meta: {
          title: '总览'
        },
        component: () => import('@/view/index/index-3d-light')
      },
      {
        path: webBaseUrl + '/gdp',
        name: 'gdp',
        meta: {
          title: '全区生产总值'
        },
        component: () => import('@/view/index/index-3d-light')
        // component: () => import('@/view/zongzhi/gdp')
      },
      {
        path: webBaseUrl + '/gongye',
        name: 'gongye',
        meta: {
          title: '工业经济'
        },
        component: () => import('@/view/index/index-3d-dark')
        // component: () => import('@/view/gongye/index')
      },
      {
        path: webBaseUrl + '/investment',
        name: 'touzi',
        meta: {
          title: '固定资产投资'
        },
        component: () => import('@/view/index/index-flat-dark')
        // component: () => import('@/view/investment/index')
      },
      {
        path: webBaseUrl + '/trade',
        name: 'trade',
        meta: {
          title: '外贸进出口'
        },
        component: () => import('@/view/trade/trade')
      },
      {
        path: webBaseUrl + '/waishangtouzi',
        name: 'waishangtouzi',
        meta: {
          title: '外商投资'
        },
        component: () => import('@/view/waishangtouzi/index')
      },
      {
        path: webBaseUrl + '/retail',
        name: 'retail',
        meta: {
          title: '消费品零售'
        },
        component: () => import('@/view/retail/retail')
      },
      {
        path: webBaseUrl + '/finance',
        name: 'finance',
        meta: {
          title: '一般公共预算'
        },
        component: () => import('@/view/finance/finance')
      },
      {
        path: webBaseUrl + '/transport',
        name: 'transport',
        meta: {
          title: '机场港口'
        },
        component: () => import('@/view/transport/transport')
      }
    ]
  },


]
