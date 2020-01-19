import Main from '@/components/main'
import parentView from '@/components/parent-view'
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
    path: webBaseUrl + '/login',
    name: 'login',
    meta: {
      title: 'Login - 登录',
      hideInMenu: true
    },
    component: () => import('@/view/login/login.vue')
  },
  {
    path: webBaseUrl + '/',
    name: '_home',
    redirect: '/home',
    component: Main,
    meta: {
      hideInMenu: true,
      notCache: true
    },
    children: [
      {
        path: webBaseUrl + 'home',
        name: 'home',
        meta: {
          hideInMenu: true,
          title: '首页',
          notCache: true,
          icon: 'md-home'
        },
        component: () => import('@/view/home/index')
      }
    ]
  },
  {
    path: webBaseUrl + 'account',
    name: 'account_manage',
    component: Main,
    meta: {
      title: '账号信息',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'home',
        name: 'account_home',
        meta: {
          title: '账号信息',
          icon: 'android-menu',
          hideInBread: true
        },
        component: () => import('@/view/account/index')
      },

      {
        path: 'reset',
        name: 'account_reset',
        meta: {
          hideInMenu: true,
          hideTagNav: true,
          title: '修改密码'
        },
        component: () => import('@/view/account/reset')
      }
    ]
  },
  {
    path: webBaseUrl + 'about',
    name: 'about',
    component: Main,
    meta: {
      title: '公司介绍',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'company',
        name: 'about_company',
        meta: {
          title: '公司介绍',
          icon: 'android-menu'
        },
        component: () => import('@/view/about/company')
      },
      {
        path: 'team',
        name: 'about_team',
        meta: {
          title: '团队介绍',
          icon: 'android-menu'
        },
        component: () => import('@/view/about/team')
      }

    ]
  },
  {
    path: webBaseUrl + 'service',
    name: 'service',
    component: Main,
    meta: {
      title: '服务项目',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'service_list',
        meta: {
          title: '项目列表',
          icon: 'android-menu'
        },
        component: () => import('@/view/service/list')
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'service_edit',
        meta: {
          title: '编辑项目',
          hideInMenu: true
        },
        component: () => import('@/view/service/edit')
      },
      {
        path: 'add',
        notCache: true,
        name: 'service_add',
        meta: {
          title: '添加项目',
          hideInMenu: true
        },
        component: () => import('@/view/service/add')
      }
    ]
  },
  {
    path: webBaseUrl + 'contact',
    name: 'contact',
    component: Main,
    meta: {
      title: '联系方式',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'lists',
        name: 'contact_lists',
        meta: {
          // hideInMenu: true,
          // hideInBread: false,
          title: '联系人'
        },
        component: () => import('@/view/contact/list')
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'contact_edit',
        meta: {
          title: '编辑联系人',
          hideInMenu: true
        },
        component: () => import('@/view/contact/edit')
      },
      {
        path: 'add',
        notCache: true,
        name: 'contact_add',
        meta: {
          title: '添加联系人',
          hideInMenu: true
        },
        component: () => import('@/view/contact/add')
      }
    ]
  },
  {
    path: webBaseUrl + '/error_logger',
    name: 'error_logger',
    meta: {
      hideInBread: true,
      hideInMenu: true
    },
    component: Main,
    children: [
      {
        path: 'error_logger_page',
        name: 'error_logger_page',
        meta: {
          icon: 'ios-bug',
          title: '错误收集'
        },
        component: () => import('@/view/single-page/error-logger.vue')
      }
    ]
  },
  {
    path: webBaseUrl + '/401',
    name: 'error_401',
    meta: {
      hideInMenu: true
    },
    component: () => import('@/view/error-page/401.vue')
  },
  {
    path: webBaseUrl + '/500',
    name: 'error_500',
    meta: {
      hideInMenu: true
    },
    component: () => import('@/view/error-page/500.vue')
  },
  {
    path: webBaseUrl + '*',
    name: 'error_404',
    meta: {
      hideInMenu: true
    },
    component: () => import('@/view/error-page/404.vue')
  }
]
