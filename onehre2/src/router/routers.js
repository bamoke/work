import Main from '@/view/main'
import {baseUrl} from '_conf/base'

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
    path: baseUrl+'login',
    name: 'login',
    component: () => import('@/view/login/login.vue')
  },
  {
    path: baseUrl,
    name: 'home',
    redirect: baseUrl+'home',
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
    path: baseUrl+'auth',
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
    path: baseUrl+'teacher',
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
        path: 'course/:teacherid',
        name: 'teacher_course',
        meta: {
          hideInMenu: true,
          title: '讲师课程',
        },
        component: () => import('@/view/teacher/course')
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
    path: baseUrl+'course',
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
      },
      {
        path: '/class/:courseid',
        name: 'class_manager',
        meta: {
          title: '班级管理',
          hideInMenu: true
        },
        component: () => import('@/view/class/templete'),
        children: [
          {
            path: 'home',
            name: 'class_home',
            meta: {
              title: '班级管理',
              hideInMenu: false
            },
            component: () => import('@/view/class/index'),
          },
          {
            path: 'member',
            name: 'class_member',
            meta: {
              title: '班级成员',
              hideInMenu: false
            },
            component: () => import('@/view/class/member')
          },
          {
            path: 'notes',
            name: 'class_notes',
            meta: {
              title: '课程笔记',
              hideInMenu: false
            },
            component: () => import('@/view/class/notes')
          },
          {
            path: 'remark',
            name: 'class_remark',
            meta: {
              title: '课程点评',
              hideInMenu: false
            },
            component: () => import('@/view/class/remark')
          },
          {
            path: 'dynamic',
            name: 'class_dynamic',
            meta: {
              title: '班级动态',
              hideInMenu: true
            },
            component: () => import('@/view/class/dynamic')
          },
          {
            path: 'tests_list',
            name: 'class_tests_list',
            meta: {
              title: '作业考试',
              hideInMenu: true
            },
            component: () => import('@/view/tests/index')
          },
          {
            path: 'tests_add',
            name: 'class_tests_add',
            meta: {
              title: '添加试题',
              hideInMenu: true
            },
            component: () => import('@/view/tests/add')
          },
          {
            path: 'discuss',
            name: 'class_discuss',
            meta: {
              title: '班级讨论组',
              hideInMenu: false
            },
            component: () => import('@/view/class/discuss')
          },
          {
            path: 'survey',
            name: 'class_survey',
            meta: {
              title: '调查问卷',
              hideInMenu: true
            },
            component: () => import('@/view/survey/list')
          }
        ]
      },

    ]
  },
  {
    path: baseUrl+'discuss/:disid',
    name: 'discuss',
    meta: {
      title: '讨论组详情',
      hideInMenu: true
    },
    component: Main,
    children: [{
      path: 'home',
      name: 'discuss_home',
      meta: {
        title: '讨论组详情',
        hideInMenu: false
      },
      component: () => import('@/view/discuss/home'),
      children: [
        {
          path: 'member',
          name: 'discuss_member',
          meta: {
            title: '讨论组成员',
            hideInMenu: false
          },
          component: () => import('@/view/discuss/member'),
        },
        {
          path: 'content',
          name: 'discuss_content',
          meta: {
            title: '讨论内容',
            hideInMenu: true
          },
          component: () => import('@/view/discuss/node')
        }

      ]
    }
    ]

  },
  {
    path: baseUrl+'tests/:testid',
    name: 'tests',
    component: Main,
    meta: {
      title: '作业考试',
      icon: 'android-contacts',
      hideInMenu: true
    },
    children: [
      {
        path: 'edit',
        name: 'test_edit',
        meta: {
          title: '编辑试题',
          hideInMenu: true
        },
        component: () => import('@/view/tests/edit')
      },
      {
        path: 'question',
        name: 'test_question',
        meta: {
          title: '题目管理',
          hideInMenu: true
        },
        component: () => import('@/view/tests/question_home'),
        children: [
          {
            path: 'list',
            name: 'test_question_list',
            meta: {
              title: '题目列表',
              hideInMenu: true
            },
            component: () => import('@/view/tests/question_list')
          },
          {
            path: 'add',
            name: 'test_question_add',
            meta: {
              title: '添加题目',
              hideInMenu: true
            },
            component: () => import('@/view/tests/question_add')
          },
          {
            path: 'edit/:questionid',
            name: 'test_question_edit',
            meta: {
              title: '修改题目',
              hideInMenu: true
            },
            component: () => import('@/view/tests/question_edit')
          }
        ]
      },
      {
        path: 'logs',
        name: 'test_logs',
        meta: {
          title: '测试记录',
          hideInMenu: true
        },
        component: () => import('@/view/tests/logs')
      },
    ]
  },

  {
    path: baseUrl+'article',
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
          icon: 'android-textsms'
        },
        component: () => import('@/view/article/comment')
      }
    ]
  },
  {
    path: baseUrl+'outsource',
    name: 'outsource_manage',
    component: Main,
    meta: {
      title: '外包',
      icon: 'android-contacts'
    },
    children: [
      {
        path: 'list',
        name: 'outsource_list',
        meta: {
          title: '外包栏目',
          icon: 'android-menu'
        },
        component: () => import('@/view/outsource/list')
      },
      {
        path: 'add',
        name: 'outsource_add',
        meta: {
          hideInMenu: true,
          title: '添加文章',
        },
        component: () => import('@/view/outsource/add')
      },
      {
        path: 'edit/:id',
        notCache: true,
        name: 'outsource_edit',
        meta: {
          title: '编辑文章',
          hideInMenu: true
        },
        component: () => import('@/view/outsource/edit')
      }
    ]
  },
  {
    path: baseUrl+'parttime',
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
          hideInMenu: true
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
        component: () => import('@/view/parttime/detail'),
        children: [
          {
            path: 'introduce',
            notCache: true,
            name: 'parttime_introduce',
            meta: {
              title: '项目介绍',
              hideInMenu: true
            },
            component: () => import('@/view/parttime/introduce')
          },
          {
            path: 'member',
            notCache: true,
            name: 'parttime_member',
            meta: {
              title: '项目成员',
              hideInMenu: true
            },
            component: () => import('@/view/parttime/member')
          },
          {
            path: 'progress',
            notCache: true,
            name: 'parttime_progress',
            meta: {
              title: '项目进度',
              hideInMenu: true
            },
            component: () => import('@/view/parttime/progress')
          },
          {
            path: 'discuss',
            notCache: true,
            name: 'parttime_discuss',
            meta: {
              title: '项目讨论',
              hideInMenu: true
            },
            component: () => import('@/view/parttime/discuss')
          },
          {
            path: 'apply',
            notCache: true,
            name: 'parttime_apply',
            meta: {
              title: '投递记录',
              hideInMenu: true
            },
            component: () => import('@/view/parttime/apply')
          }
        ]
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
          hideInMenu: true
        },
        component: () => import('@/view/resume/detail')
      },
    ]
  },
  /**====== */

  {
    path: baseUrl+'survey',
    name: 'survey',
    meta: {
      title: '问卷管理',
      icon: 'android-document'
    },
    component: Main,
    children: [
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
          hideInMenu: true
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
      },
      {
        path: 'logdetail/:id',
        notCache: true,
        name: 'survey_log_detail',
        meta: {
          title: '问卷记录详情',
          hideInMenu: true
        },
        component: () => import('@/view/survey/logdetail')
      }
    ]
  },


  {
    path: baseUrl+'update',
    name: 'update',
    meta: {
      icon: 'upload',
      title: '数据上传',
      hideInMenu: true
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
    path: baseUrl+'401',
    name: 'error_401',
    component: () => import('@/view/error-page/401.vue')
  },
  {
    path: baseUrl+'500',
    name: 'error_500',
    component: () => import('@/view/error-page/500.vue')
  },
  {
    path: baseUrl+'*',
    name: 'error_404',
    component: () => import('@/view/error-page/404.vue')
  }
]
