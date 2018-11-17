import Main from '@/view/main'
import parentView from '@/components/parent-view'

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
    path: '/login',
    name: 'login',
    component: () => import('@/view/login/login.vue')
  },
  {
    path: '/',
    name: 'home',
    redirect: '/home',
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
    path: '/auth',
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
          title: '权限规则'
        },
        component: () => import('@/view/auth/rules')
      }
    ]
  },
  {
    path: '/teacher',
    name: 'teacher_manage',
    component: Main,
    meta: {
      title: '讲师管理',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'teacher_list',
        meta: {
          title: '讲师列表'
        },
        component: () => import('@/view/teacher/list')
      },
      {
        path: 'add',
        name: 'teacher_add',
        meta: {
          hideInMenu: true,
          title: '添加讲师',
        },
        component: () => import('@/view/teacher/add')
      },
      {
        path: 'edit/:id',
        name: 'teacher_edit',
        meta: {
          title: '编辑讲师',
          hideInMenu: true
        },
        component: () => import('@/view/teacher/edit')
      }
    ]
  },
  {
    path: '/course',
    name: 'course_manage',
    component: Main,
    meta: {
      title: '课程管理',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'course_list',
        meta: {
          title: '课程列表'
        },
        component: () => import('@/view/course/list')
      },
      {
        path: 'add',
        name: 'course_add',
        meta: {
          hideInMenu: true,
          title: '添加课程',
        },
        component: () => import('@/view/course/add')
      },
      {
        path: 'edit/:id',
        name: 'course_edit',
        meta: {
          title: '编辑课程',
          hideInMenu: true
        },
        component: () => import('@/view/course/edit')
      }
    ]
  },
  {
    path: '/article',
    name: 'article_manage',
    component: Main,
    meta: {
      title: '职涯管理',
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
          title: '添加文章',
        },
        component: () => import('@/view/article/add')
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'article_edit',
        meta: {
          title: '编辑文章',
          hideInMenu: true
        },
        component: () => import('@/view/article/edit')
      },
      {
        path: 'cate',
        name: 'article_cate',
        meta: {
          title: '文章类别',
          icon: 'grid'
        },
        component: () => import('@/view/article/cate')
      },
      {
        path: 'comment',
        name: 'article_comment',
        meta: {
          title: '文章评论',
          icon:'android-textsms'
        },
        component: () => import('@/view/article/comment')
      }
    ]
  },
  {
    path: '/parttime',
    name: 'parttime_manage',
    meta: {
      title: '兼职项目',
      icon: 'briefcase'
    },
    component: Main,
    children: [
      {
        path: 'list',
        name: 'parttime_list',
        meta: {
          title: '项目列表',
          icon: 'android-menu'
        },
        component: () => import('@/view/parttime/list'),       
      },
      {
        path: 'add',
        name: 'parttime_add',
        meta: {
          title: '添加项目',
          hideInMenu:true
        },
        component: () => import('@/view/parttime/add'),       
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'parttime_edit',
        meta: {
          title: '编辑项目',
          hideInMenu: true
        },
        component: () => import('@/view/parttime/edit')
      },
      {
        path: 'detail/:id',
        notCache: true,
        name: 'parttime_detail',
        meta: {
          title: '项目详情',
          hideInMenu: true
        },
        component: () => import('@/view/parttime/detail')
      },
      {
        path: 'resume',
        notCache: true,
        name: 'resume',
        meta: {
          title: '简历列表',
          icon: 'ios-copy'
        },
        component: () => import('@/view/resume/list')
      },
      {
        path: 'resume_detail/:id',
        notCache: true,
        name: 'resume_detail',
        meta: {
          title: '简历详情',
          hideInMenu:true
        },
        component: () => import('@/view/resume/detail')
      },
    ]
  },
  /**====== */
  {
    path: '/class',
    name: 'class_manage',
    meta: {
      title: '班级管理',
      icon: 'android-people'
    },
    component: Main
  },
  {
    path: '/survey',
    name: 'survey',
    meta: {
      title: '问卷管理',
      icon: 'android-document'
    },
    component: Main,
    children:[
      {
        path: 'list',
        name: 'survey_list',
        meta: {
          title: '问卷列表',
          icon: 'android-menu'
        },
        component: () => import('@/view/survey/list'),       
      },
      {
        path: 'add',
        name: 'survey_add',
        meta: {
          title: '添加问卷',
          hideInMenu:true
        },
        component: () => import('@/view/survey/add'),       
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'survey_edit',
        meta: {
          title: '编辑问卷',
          hideInMenu: true
        },
        component: () => import('@/view/survey/edit')
      },
      {
        path: 'detail/:id',
        notCache: true,
        name: 'survey_detail',
        meta: {
          title: '问卷详情',
          hideInMenu: true
        },
        component: () => import('@/view/survey/detail')
      }      
    ]
  },

  {
    path: '/components',
    name: 'components',
    meta: {
      icon: 'social-buffer',
      title: '组件'
    },
    component: Main,
    children: [
      {
        path: 'count_to_page',
        name: 'count_to_page',
        meta: {
          icon: 'arrow-graph-up-right',
          title: '数字渐变'
        },
        component: () => import('@/view/components/count-to/count-to.vue')
      },
      {
        path: 'tables_page',
        name: 'tables_page',
        meta: {
          icon: 'ios-grid-view',
          title: '多功能表格'
        },
        component: () => import('@/view/components/tables/tables.vue')
      },
      {
        path: 'split_pane_page',
        name: 'split_pane_page',
        meta: {
          icon: 'pause',
          title: '分割窗口'
        },
        component: () => import('@/view/components/split-pane/split-pane.vue')
      },
      {
        path: 'markdown_page',
        name: 'markdown_page',
        meta: {
          icon: 'social-markdown',
          title: 'Markdown编辑器'
        },
        component: () => import('@/view/components/markdown/markdown.vue')
      },
      {
        path: 'editor_page',
        name: 'editor_page',
        meta: {
          icon: 'compose',
          title: '富文本编辑器'
        },
        component: () => import('@/view/components/editor/editor.vue')
      },
      {
        path: 'icons_page',
        name: 'icons_page',
        meta: {
          icon: '_bear',
          title: '自定义图标'
        },
        component: () => import('@/view/components/icons/icons.vue')
      }
    ]
  },
  {
    path: '/update',
    name: 'update',
    meta: {
      icon: 'upload',
      title: '数据上传'
    },
    component: Main,
    children: [
      {
        path: 'update_table_page',
        name: 'update_table_page',
        meta: {
          icon: 'document-text',
          title: '上传Csv'
        },
        component: () => import('@/view/update/update-table.vue')
      },
      {
        path: 'update_paste_page',
        name: 'update_paste_page',
        meta: {
          icon: 'clipboard',
          title: '粘贴表格数据'
        },
        component: () => import('@/view/update/update-paste.vue')
      }
    ]
  },
  {
    path: '/directive',
    name: 'directive',
    meta: {
      hide: true
    },
    component: Main,
    children: [
      {
        path: '/directive_page',
        name: 'directive_page',
        meta: {
          icon: 'ios-navigate',
          title: '指令'
        },
        component: () => import('@/view/directive/directive.vue')
      }
    ]
  },
  {
    path: '/multilevel',
    name: 'multilevel',
    meta: {
      icon: 'arrow-graph-up-right',
      title: '多级菜单'
    },
    component: Main,
    children: [
      {
        path: 'level_2_1',
        name: 'level_2_1',
        meta: {
          icon: 'arrow-graph-up-right',
          title: '二级-1'
        },
        component: () => import('@/view/multilevel/level-1.vue')
      },
      {
        path: 'level_2_2',
        name: 'level_2_2',
        meta: {
          access: ['super_admin'],
          icon: 'arrow-graph-up-right',
          title: '二级-2'
        },
        component: parentView,
        children: [
          {
            path: 'level_2_2_1',
            name: 'level_2_2_1',
            meta: {
              icon: 'arrow-graph-up-right',
              title: '三级'
            },
            component: () => import('@/view/multilevel/level-2/level-2-1.vue')
          }
        ]
      },
      {
        path: 'level_2_3',
        name: 'level_2_3',
        meta: {
          icon: 'arrow-graph-up-right',
          title: '二级-3'
        },
        component: parentView,
        children: [
          {
            path: 'level_2_3_1',
            name: 'level_2_3_1',
            meta: {
              access: ['super_admin'],
              icon: 'arrow-graph-up-right',
              title: '三级-1'
            },
            component: () => import('@/view/multilevel/level-2/level-2-1.vue')
          },
          {
            path: 'level_2_3_2',
            name: 'level_2_3_2',
            meta: {
              access: ['super_admin', 'admin'],
              icon: 'arrow-graph-up-right',
              title: '三级-2'
            },
            component: () => import('@/view/multilevel/level-2/level-2-1.vue')
          }
        ]
      }
    ]
  },
  {
    path: '/401',
    name: 'error_401',
    component: () => import('@/view/error-page/401.vue')
  },
  {
    path: '/500',
    name: 'error_500',
    component: () => import('@/view/error-page/500.vue')
  },
  {
    path: '*',
    name: 'error_404',
    component: () => import('@/view/error-page/404.vue')
  }
]
