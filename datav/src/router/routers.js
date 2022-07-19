/*
 * @Author: Joy wang
 * @Date: 2021-05-06 10:40:06
 * @LastEditTime: 2021-06-02 07:15:04
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Main from '@/components/main/main'
import Child from '@/components/main/child'
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
<<<<<<< HEAD
        component: () => import('@/view/index/index-3d-light')
=======
        component: () => import('@/view/overview/index-mobile')
        // component: () => import('@/view/index/index-3d-light')
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
      },
      {
        path: webBaseUrl + '/gdp',
        name: 'gdp',
        meta: {
          title: '地区生产总值'
        },
<<<<<<< HEAD
        component: () => import('@/view/zongzhi/gdp')
=======
        component: () => import('@/view/zongzhi/gdp-mobile')
        // component: () => import('@/view/zongzhi/gdp')
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
      },
      {
        path: webBaseUrl + '/gongye',
        name: 'gongye',
        meta: {
          title: '工业经济'
        },
<<<<<<< HEAD
        component: () => import('@/view/gongye/index')
=======
        component: () => import('@/view/gongye/index-mobile')
        // component: () => import('@/view/gongye/index')
>>>>>>> 4a8416d5a402a0593e6c550c40b432131615f3e3
      },
      {
        path: webBaseUrl + '/investment',
        name: 'touzi',
        meta: {
          title: '固定资产投资'
        },
        component: () => import('@/view/investment/index')
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
          title: '社消零'
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
  {
    path: webBaseUrl + '/',
    name: 'child',
    component: Child,
    children: [
      {
        path: webBaseUrl + '/gdp_chanye',
        name: 'gdp_chanye',
        meta: {
          title: '地区生产总值按产业情况'
        },
        component: () => import('@/view/zongzhi/components/chanye')
      },
      {
        path: webBaseUrl + '/gdp_hangye',
        name: 'gdp_hangye',
        meta: {
          title: '地区生产总值按行业情况'
        },
        component: () => import('@/view/zongzhi/components/hangye')
      },
      {
        path: webBaseUrl + '/gdp_monitor',
        name: 'gdp_monitor',
        meta: {
          title: '监测数据报表'
        },
        component: () => import('@/view/zongzhi/components/monitor')
      },
      {
        path: webBaseUrl + '/finace_income',
        name: 'finance_income',
        meta: {
          title: '一般公共预算收入情况'
        },
        component: () => import('@/view/finance/components/income')
      },
      {
        path: webBaseUrl + '/finace_expend',
        name: 'finance_expend',
        meta: {
          title: '一般公共预算支出情况'
        },
        component: () => import('@/view/finance/components/expend')
      },
      {
        path: webBaseUrl + '/gongye_zzcy',
        name: 'gongye_zzcy',
        meta: {
          title: '重点支柱产业工业增加值及工业总产值'
        },
        component: () => import('@/view/gongye/components/zhizhuchanye')
      },
      {
        path: webBaseUrl + '/gongye_myqy',
        name: 'gongye_myqy',
        meta: {
          title: '现代产业和规上民营企业工业增加值及工业总产值'
        },
        component: () => import('@/view/gongye/components/minyingqiye')
      },
      {
        path: webBaseUrl + '/gongye_hy',
        name: 'gongye_hy',
        meta: {
          title: '规模以上工业分行业工业增加值及工业总产值'
        },
        component: () => import('@/view/gongye/components/hangye')
      },
      {
        path: webBaseUrl + '/gongye_ny',
        name: 'gongye_ny',
        meta: {
          title: '规上工业能源消费及社会用电量情况'
        },
        component: () => import('@/view/gongye/components/nengyuan')
      },

    ]
  },
  {
    path: webBaseUrl + '/gdp_company',
    name: 'gdp_company',
    meta: {
      title: '重点企业经营情况'
    },
    component: () => import('@/view/zongzhi/components/enterprises')
  },


]
