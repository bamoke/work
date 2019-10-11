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
    path: webBaseUrl + 'login',
    name: 'login',
    meta: {
      title: 'Login - 登录',
      hideInMenu: true
    },
    component: () => import('@/view/login/login.vue')
  },
  {
    path: webBaseUrl,
    name: '_home',
    redirect: webBaseUrl + '/home',
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
        component: () => import('@/view/single-page/home')
      }
    ]
  },
  {
    path: webBaseUrl + 'auth',
    name: 'auth_manage',
    component: Main,
    meta: {
      title: '权限管理',
      icon: 'android-unlock'
    },
    children: [
      {
        path: 'user',
        name: 'auth_user',
        meta: {
          title: '用户管理'
        },
        component: () => import('@/view/auth/user')
      },
      {
        path: 'groups',
        name: 'auth_group',
        meta: {
          title: '群组管理'
        },
        component: () => import('@/view/auth/groups')
      },
      {
        path: 'rules',
        name: 'auth_rules',
        meta: {
          title: '权限规则',
          hideInMenu: true
        },
        component: () => import('@/view/auth/rules')
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
        path: 'profile',
        name: 'account_profile',
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
    path: webBaseUrl + 'finance',
    name: 'finance_manage',
    component: Main,
    meta: {
      title: '资金管理',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'index',
        name: 'finance_index',
        meta: {
          hideInBread: true,
          title: '资金管理',
          icon: 'android-menu'
        },
        component: () => import('@/view/finance/index')
      },
      {
        path: 'list',
        name: 'finance_list',
        meta: {
          hideInMenu: true,
          title: '收支记录',
          icon: 'android-menu'
        },
        component: () => import('@/view/finance/list')
      },
      {
        path: 'detail/:id',
        name: 'finance_detail',
        meta: {
          title: '收支详情',
          hideInMenu: true
        },
        component: () => import('@/view/finance/detail')
      }

    ]
  },
  {
    path: webBaseUrl + 'customer',
    name: 'customer_manage',
    component: Main,
    meta: {
      title: '客户管理',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'customer_list',
        meta: {
          hideInBread: true,
          title: '客户管理',
          // hideInMenu: true,
          icon: 'android-menu'
        },
        component: () => import('@/view/customer/list')
      },
      {
        path: 'add',
        name: 'customer_add',
        meta: {
          hideInMenu: true,
          // hideInBread: false,
          title: '添加客户'
        },
        component: () => import('@/view/customer/add')
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'customer_edit',
        meta: {
          title: '编辑客户',
          hideInMenu: true
        },
        component: () => import('@/view/customer/edit')
      },
      {
        path: 'account/:comid',
        notCache: true,
        name: 'customer_account',
        meta: {
          title: '账号管理',
          hideInMenu: true
        },
        component: () => import('@/view/customer/account')
      },
      {
        path: 'config/:comid',
        notCache: true,
        name: 'customer_config',
        meta: {
          title: '配置信息',
          hideInMenu: true
        },
        component: () => import('@/view/customer/config')
      }

    ]
  },
  {
    path: '/error_logger',
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
    path: '/401',
    name: 'error_401',
    meta: {
      hideInMenu: true
    },
    component: () => import('@/view/error-page/401.vue')
  },
  {
    path: '/500',
    name: 'error_500',
    meta: {
      hideInMenu: true
    },
    component: () => import('@/view/error-page/500.vue')
  },
  {
    path: '*',
    name: 'error_404',
    meta: {
      hideInMenu: true
    },
    component: () => import('@/view/error-page/404.vue')
  }
]
