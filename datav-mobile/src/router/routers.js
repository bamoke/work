/*
 * @Author: Joy wang
 * @Date: 2021-05-06 10:40:06
 * @LastEditTime: 2021-06-02 07:15:04
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Main from '@/components/main/main'

import config from '@/config'
const webBaseUrl = config.webBaseUrl

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
    name: 'index',
    redirect:  webBaseUrl + '/home',
    component: Main,
    children: [

      {
        path: webBaseUrl + '/gdp',
        name: 'gdp',
        meta: {
          title: '地区生产总值'
        },
        component: () => import('@/view/zongzhi/gdp'),
        children: [
          {
            path: webBaseUrl + '/gdp_gross',
            name: 'gdp_gross',
            meta: {
              title: '总值及增长率'
            },
            component: () => import('@/view/zongzhi/components/gross')
          },
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
            path: webBaseUrl + '/gdp_hangye_child',
            name: 'gdp_hangye_child',
            meta: {
              title: '地区生产总值按行业详情'
            },
            component: () => import('@/view/zongzhi/components/hangye-child')
          },
          {
            path: webBaseUrl + '/gdp_hangye_child_multiple',
            name: 'gdp_hangye_child_multiple',
            meta: {
              title: '地区生产总值按行业详情多个'
            },
            component: () => import('@/view/zongzhi/components/hangye-child-multiple')
          },
          {
            path: webBaseUrl + '/gdp_sishang',
            name: 'gdp_sishang',
            meta: {
              title: '四上企业'
            },
            component: () => import('@/view/zongzhi/components/sishang')
          },
          {
            path: webBaseUrl + '/gdp_monitor',
            name: 'gdp_monitor',
            meta: {
              title: '四上企业监测数据报表'
            },
            component: () => import('@/view/zongzhi/components/monitor')
          },
          {
            path: webBaseUrl + '/gdp_company',
            name: 'gdp_company',
            meta: {
              title: '重点企业经营情况'
            },
            component: () => import('@/view/zongzhi/components/enterprises')
          },
          {
            path: webBaseUrl + '/gdp_nongye',
            name: 'gdp_nongye',
            meta: {
              title: '农业'
            },
            component: () => import('@/view/zongzhi/components/nongye')
          },
          {
            path: webBaseUrl + '/gdp_company_map',
            name: 'gdp_company_map',
            meta: {
              title: '重点企业经营情况-地图'
            },
            component: () => import('@/view/zongzhi/components/enterprises-map')
          },
        ]
      },
      {
        path: webBaseUrl + '/gongye',
        name: 'gongye',
        meta: {
          title: '工业指标'
        },
        component: () => import('@/view/gongye/index'),
        children: [
          {
            path: webBaseUrl + '/gongye_zjz',
            name: 'gongye_zjz',
            meta: {
              title: '增加值'
            },
            component: () => import('@/view/gongye/components/zjz')
          },
          {
            path: webBaseUrl + '/gongye_zcz',
            name: 'gongye_zcz',
            meta: {
              title: '总产值'
            },
            component: () => import('@/view/gongye/components/zcz')
          },
          {
            path: webBaseUrl + '/gongye_nenghao',
            name: 'gongye_nenghao',
            meta: {
              title: '能耗'
            },
            component: () => import('@/view/gongye/components/nengyuan')
          },

          {
            path: webBaseUrl + '/gongye_zdzzcy',
            name: 'gongye_zdzzcy',
            meta: {
              title: '重点支柱产业企业情况'
            },
            component: () => import('@/view/gongye/components/zhizhuchanyecom')
          },


        ]
      },
      {
        path: webBaseUrl + '/investment',
        name: 'investment_fixed',
        meta: {
          title: '固定资产投资'
        },
        component: () => import('@/view/investment/index'),
        children: [
          {
            path: webBaseUrl + '/investment_fixed_gross',
            name: 'investment_fixed_gross',
            meta: {
              title: '固定资产投资'
            },
            component: () => import('@/view/investment/components/gross'),
          },
          {
            path: webBaseUrl + '/investment_fixed_com',
            name: 'investment_fixed_com',
            meta: {
              title: '项目投资情况'
            },
            component: () => import('@/view/investment/components/project'),
          }
        ]
      },
      {
        path: webBaseUrl + '/business',
        name: 'business',
        meta: {
          title: '商务指标'
        },
        component: () => import('@/view/business/index'),
        children: [
          {
            path: webBaseUrl + '/business_waimao',
            name: 'business_waimao',
            meta: {
              title: '外贸进出口'
            },
            component: () => import('@/view/business/components/waimao'),
          },
          {
            path: webBaseUrl + '/business_waishang',
            name: 'business_waishang',
            meta: {
              title: '实际吸收外商投资'
            },
            component: () => import('@/view/business/components/waishang'),
          },
          {
            path: webBaseUrl + '/business_xiaofei',
            name: 'business_xiaofei',
            meta: {
              title: '社会消费品零售总额'
            },
            component: () => import('@/view/business/components/xiaofei'),
          }
        ]
      },
      {
        path: webBaseUrl + '/finance',
        name: 'finance',
        meta: {
          title: '财政指标'
        },
        component: () => import('@/view/finance/finance'),
        children: [
          {
            path: webBaseUrl + '/finance_imcome',
            name: 'finance_imcome',
            meta: {
              title: '一般公共预算收入'
            },
            component: () => import('@/view/finance/components/income'),
          },
          {
            path: webBaseUrl + '/finance_expend',
            name: 'finance_expend',
            meta: {
              title: '一般公共预算支出'
            },
            component: () => import('@/view/finance/components/expend'),
          }

        ]
      },
      {
        path: webBaseUrl + '/transport',
        name: 'transport',
        meta: {
          title: '机场港口'
        },
        component: () => import('@/view/transport/transport'),
        children: [
          {
            path: webBaseUrl + '/transport_airport',
            name: 'transport_airport',
            meta: {
              title: '珠海机场'
            },
            component: () => import('@/view/transport/components/airport'),
          },
          {
            path: webBaseUrl + '/transport_harbor',
            name: 'transport_harbor',
            meta: {
              title: '高栏港'
            },
            component: () => import('@/view/transport/components/harbor'),
          }

        ]
      },
      {
        path: webBaseUrl + '/nenghao',
        name: 'nenghao',
        meta: {
          title: '能耗'
        },
        component: () => import('@/view/nenghao/nenghao'),
        children: [
          {
            path: webBaseUrl + '/nenghao_all',
            name: 'nenghao_all',
            meta: {
              title: '全社会用电量'
            },
            component: () => import('@/view/nenghao/components/electric'),
          },
          {
            path: webBaseUrl + '/nenghao_use',
            name: 'nenghao_use',
            meta: {
              title: '能源消费情况'
            },
            component: () => import('@/view/nenghao/components/nengyuan')
          }

        ]
      }
    ]
  },
  {
    path: webBaseUrl + '/overview',
    name: 'overview',
    meta: {
      title: '经济总览'
    },
    component: () => import('@/view/overview/index')
    // component: () => import('@/view/index/index-3d-light')
  },
  {
    path: webBaseUrl + '/login',
    name: 'login',
    meta: {
      title: '登录'
    },
    component: () => import('@/view/main/login')
    // component: () => import('@/view/index/index-3d-light')
  },
  {
    path: webBaseUrl + '/home',
    name: 'home',
    meta: {
      title: '首页'
    },
    component: () => import('@/view/main/index')
    // component: () => import('@/view/index/index-3d-light')
  },
  {
    path: webBaseUrl + '/gdp_company_map',
    name: 'gdp_company_map',
    meta: {
      title: '重点企业经营情况地图'
    },
    component: () => import('@/view/zongzhi/components/enterprises-map')
  },




]
