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
    path: webBaseUrl + 'article',
    name: 'article_manage',
    component: Main,
    meta: {
      title: '金英播报',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'article_list',
        meta: {
          title: '文章列表',
          icon: 'android-menu'
        },
        component: () => import('@/view/article/list')
      },
      {
        path: 'add',
        name: 'article_add',
        meta: {
          hideInMenu: true,
          title: '新建内容'
        },
        component: () => import('@/view/article/add')
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'article_edit',
        meta: {
          title: '编辑内容',
          hideInMenu: true
        },
        component: () => import('@/view/article/edit')
      },
      {
        path: 'cate',
        name: 'article_cate',
        meta: {
          title: '内容类别',
          icon: 'grid'
        },
        component: () => import('@/view/article/cate')
      }

    ]
  },
  {
    path: webBaseUrl + 'event',
    name: 'event_manage',
    component: Main,
    meta: {
      title: '活动管理',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'event_list',
        meta: {
          title: '活动列表',
          icon: 'android-menu'
        },
        component: () => import('@/view/event/list')
      },
      {
        path: 'add',
        name: 'event_add',
        meta: {
          hideInMenu: true,
          title: '新建活动'
        },
        component: () => import('@/view/event/add')
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'event_edit',
        meta: {
          title: '编辑活动',
          hideInMenu: true
        },
        component: () => import('@/view/event/edit')
      },
      {
        path: 'enroll/:eventid',
        name: 'event_enroll',
        meta: {
          hideInMenu: true,
          title: '活动报名'
        },
        component: () => import('@/view/event/enroll')
      }

    ]
  },
  {
    path: webBaseUrl + 'card',
    name: 'card_manage',
    component: Main,
    meta: {
      title: '名片管理',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'card_list',
        meta: {
          title: '名片列表',
          icon: 'android-menu'
        },
        component: () => import('@/view/card/list')
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'card_edit',
        meta: {
          title: '编辑名片',
          hideInMenu: true
        },
        component: () => import('@/view/card/edit')
      },
      {
        path: 'import',
        name: 'card_import',
        meta: {
          hideInMenu: true,
          title: '导入名片'
        },
        component: () => import('@/view/card/import')
      }

    ]
  },
  {
    path: webBaseUrl + 'policy',
    name: 'policy_manage',
    component: Main,
    meta: {
      title: '人才政策',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'policy_list',
        meta: {
          title: '人才政策',
          icon: 'android-menu'
        },
        component: () => import('@/view/policy/list')
      },
      {
        path: 'add',
        name: 'policy_add',
        meta: {
          hideInMenu: true,
          title: '添加人才政策'
        },
        component: () => import('@/view/policy/add')
      },
      {
        path: 'edit/:id',
        name: 'policy_edit',
        meta: {
          hideInMenu: true,
          title: '修改人才政策'
        },
        component: () => import('@/view/policy/edit')
      }
    ]
  },
  {
    path: webBaseUrl + 'welfare',
    name: 'welfare_manage',
    component: Main,
    meta: {
      title: '周边福利',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'welfare_list',
        meta: {
          title: '周边福利',
          icon: 'android-menu'
        },
        component: () => import('@/view/welfare/list')
      },
      {
        path: 'add',
        name: 'welfare_add',
        meta: {
          hideInMenu: true,
          title: '添加商家'
        },
        component: () => import('@/view/welfare/add')
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'welfare_edit',
        meta: {
          title: '编辑商家',
          hideInMenu: true
        },
        component: () => import('@/view/welfare/edit')
      }
    ]
  },
  {
    path: webBaseUrl + 'talent',
    name: 'talent_manage',
    component: Main,
    meta: {
      title: '人才卡',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'talent_list',
        meta: {
          title: '人才卡',
          icon: 'android-menu'
        },
        component: () => import('@/view/talent/list')
      },
      {
        path: 'detail/:id',
        name: 'talent_detail',
        meta: {
          hideInMenu: true,
          title: '人才卡详情'
        },
        component: () => import('@/view/talent/detail')
      }
    ]
  },
  {
    path: webBaseUrl + 'banner',
    name: 'banner_manage',
    component: Main,
    meta: {
      title: 'Banner',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'banner_list',
        meta: {
          title: 'Banner管理',
          icon: 'android-menu'
        },
        component: () => import('@/view/banner/list')
      },
      {
        path: 'add',
        name: 'banner_add',
        meta: {
          hideInMenu: true,
          title: 'Banner添加'
        },
        component: () => import('@/view/banner/add')
      },
      {
        path: 'edit/:id',
        name: 'banner_edit',
        meta: {
          hideInMenu: true,
          title: 'Banner编辑'
        },
        component: () => import('@/view/banner/edit')
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
