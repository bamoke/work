const btns = {
  delete: (h, params, vm) => {
    return h(
      'Poptip',
      {
        props: {
          confirm: true,
          title: '你确定要删除吗?'
        },
        style: {
          marginRight: '10px'
        },
        on: {
          'on-ok': () => {
            vm.handleDelete(params)
          }
        }
      },
      [h('Button', {}, '删除')]
    )
  },
  // view detail
  view: (h, params, vm) => {
    return h('Button', {
      props: {
        type: 'default'
      },
      on: {
        'click': () => {
          // vm.$emit('to-page', params.row.id)
          vm.handleView(params)
        }
      }
    }, '查看')
  },
  // edit
  edit: (h, params, vm) => {
    return h(
      'Button',
      {
        props: {
          type: 'default'
        },
        style: {
          marginRight: '10px'
        },
        on: {
          click: () => {
            vm.handleEdit(params)
          }
        }
      },
      '编辑'
    )
  }
}

export default btns
