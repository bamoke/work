import Main from '@/components/main'
// import parentView from '@/components/parent-view'
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
    path: webBaseUrl,
    name: '_home',
    redirect: webBaseUrl + '/home',
    component: Main,
    meta: {
      title:"首页",
      // hideInMenu: true,
      notCache: true
    },
    children: [
      {
        path: webBaseUrl + 'home',
        name: 'home',
        meta: {
          // hideInMenu: true,
          title: '首页',
          notCache: true,
          icon: 'md-home'
        },
        component: () => import('@/view/single-page/home')
      }
    ]
  },
  {
    path: webBaseUrl + '/auth',
    name: 'auth_manage',
    component: Main,
    meta: {
      title: '权限管理',
      icon: 'md-options'
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
        path: 'role',
        name: 'auth_role',
        meta: {
          title: '角色管理'
        },
        component: () => import('@/view/auth/role')
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
    path: webBaseUrl + '/company',
    name: 'company_manage',
    component: Main,
    meta: {
      title: '企业管理',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'company_list',
        meta: {
          title: '企业列表',
          icon: 'md-menu'
        },
        component: () => import('@/view/company/list')
      }
    ]
  },
  {
    path: webBaseUrl + '/job',
    name: 'job_manage',
    component: Main,
    meta: {
      title: '职位管理',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'job_list',
        meta: {
          title: '职位列表',
          icon: 'md-menu'
        },
        component: () => import('@/view/job/list')
      }
    ]
  },
  {
    path: webBaseUrl + '/dispatch',
    name: 'dispatch_manage',
    component: Main,
    meta: {
      title: '派遣管理',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'dispatch_list',
        meta: {
          title: '派遣记录',
          icon: 'md-menu'
        },
        component: () => import('@/view/dispatch/list')
      }
    ]
  },
  {
    path: webBaseUrl + '/worker',
    name: 'worker_manage',
    component: Main,
    meta: {
      title: '劳工管理',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'worker_list',
        meta: {
          title: '劳工管理',
          icon: 'md-contacts'
        },
        component: () => import('@/view/workers/list')
      },
      {
        path: 'add',
        name: 'worker_add',
        meta: {
          hideInMenu: true,
          title: '添加劳工'
        },
        component: () => import('@/view/workers/add')
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'worker_edit',
        meta: {
          title: '修改劳工',
          hideInMenu: true
        },
        component: () => import('@/view/workers/edit')
      }

    ]
  },

  {
    path: webBaseUrl + '/stationer',
    name: 'stationer_manage',
    component: Main,
    meta: {
      title: '驻厂员工',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'stationer_list',
        meta: {
          title: '驻厂员工',
          icon: 'md-happy'
        },
        component: () => import('@/view/stationer/list')
      }

    ]
  },
  {
    path: webBaseUrl + '/introducer',
    name: 'introducer_manage',
    component: Main,
    meta: {
      title: '中间人',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'introducer_list',
        meta: {
          title: '中间人管理',
          icon: 'md-person'
        },
        component: () => import('@/view/introducer/list')
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
