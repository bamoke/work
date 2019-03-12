
import env from '../../config/env'
import Main from '@/view/main'
import parentView from '@/components/parent-view'
const baseUrl = env==='development' ? '/' : '/zhuyingtai/'

/**
 * iview-admin中meta除了原生参数外可配置的参数:
 * meta: {
 *  hideInMenu: (false) 设为true后在左侧菜单不会显示该页面选项
 *  notCache: (false) 设为true后页面不会缓存
 *  access: (null) 可访问该页面的权限数组，当前路由设置的权限会影响子路由
 *  icon: (-) 该页面在左侧菜单、面包屑和标签导航处显示的图标，如果是自定义图标，需要在图标名称前加下划线'_'
 * }
 */

export default [
  {
    path: baseUrl + 'login',
    name: 'login',
    component: () => import('@/view/login/login.vue')
  },
  {
    path: baseUrl,
    name: 'home',
    redirect: baseUrl + 'home',
    component: Main,
    meta: {
      hideInMenu: true,
      notCache: true
    },
    children: [
      {
        path: 'home',
        name: 'home',
        meta: {
          hideInMenu: true,
          notCache: true
        },
        component: () => import('@/view/single-page/home')
      }
    ]
  },
  /***onehre */
  {
    path: baseUrl + 'auth',
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
          hideInMenu: true,
        },
        component: () => import('@/view/auth/rules')
      }
    ]
  },



  {
    path: baseUrl + 'tests',
    name: 'tests',
    component: Main,
    meta: {
      title: '评测项目'
    },
    children: [
      {
        path: 'list',
        name: 'test_list',
        meta: {
          title: '评测项目',
          icon: 'android-contacts',
        },
        component: () => import('@/view/tests/index')
      },
      {
        path: 'add',
        name: 'test_add',
        meta: {
          title: '添加项目',
          hideInMenu: true
        },
        component: () => import('@/view/tests/add')
      },
      {
        path: 'edit/:testid',
        name: 'test_edit',
        meta: {
          title: '修改项目',
          hideInMenu: true
        },
        component: () => import('@/view/tests/edit')
      },
      {
        path: 'detail/:testid',
        name: 'test_detail',
        meta: {
          title: '项目详情',
          hideInMenu: true
        },
        component: () => import('@/view/tests/detail'),
        children: [
          {
            path: 'question',
            name: 'test_question_home',
            meta: {
              title: '评测问题管理',
              hideInMenu: true
            },
            component: () => import('@/view/tests/question_home'),
            children: [
              {
                path: 'add',
                name: 'test_question_add',
                meta: {
                  title: '添加问题',
                  hideInMenu: true
                },
                component: () => import('@/view/tests/question_add')
              },
              {
                path: 'edit/:questionid',
                name: 'test_question_edit',
                meta: {
                  title: '修改问题',
                  hideInMenu: true
                },
                component: () => import('@/view/tests/question_edit')
              }
            ]
          },
          {
            path: 'list',
            name: 'test_question_list',
            meta: {
              title: '问题列表',
              hideInMenu: true
            },
            component: () => import('@/view/tests/question_list')
          },

          {
            path: 'logs',
            name: 'test_logs',
            meta: {
              title: '评测记录',
              hideInMenu: true
            },
            component: () => import('@/view/tests/logs')
          }
        ]
      },

    ]
  },

  {
    path: baseUrl + 'article',
    name: 'article_manage',
    component: Main,
    meta: {
      title: '文章资讯',
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
          title: '新建内容',
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
    path: baseUrl + 'resume',
    name: 'resume',
    component: Main,
    meta: {
      title: '简历',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'resume_list',
        meta: {
          title: '简历列表',
          notCache: true,
          icon: 'ios-copy'
        },
        component: () => import('@/view/resume/list')
      }
    ]
  },
  {
    path: baseUrl + 'ticket',
    name: 'ticket',
    component: Main,
    meta: {
      title: '入场券',
      icon: 'android-menu'
    },
    children: [
      {
        path: 'list',
        name: 'ticket_list',
        meta: {
          title: '入场券',
          icon: 'android-menu',
          notCache: true
        },
        component: () => import('@/view/ticket/list')
      }
    ]
  },








  {
    path: baseUrl + '401',
    name: 'error_401',
    component: () => import('@/view/error-page/401.vue')
  },
  {
    path: baseUrl + '500',
    name: 'error_500',
    component: () => import('@/view/error-page/500.vue')
  },
  {
    path: baseUrl + '*',
    name: 'error_404',
    component: () => import('@/view/error-page/404.vue')
  }
]
