import Mock from 'mockjs'
import { doCustomTimes } from '@/libs/util'

const getUserData = req => {
  let tableData = []
  doCustomTimes(10, () => {
    tableData.push(Mock.mock({
      id: '@integer(1, 100)',
      username: '@word(5,10)',
      realname: '@cname',
      email: '@email',
      createTime: '@date'
    }))
  })
  return {
    code: 200,
    data: tableData,
    msg: ''
  }
}
const getUserGroups = req => {
  let groups = [
    {
      id: 1,
      name: '超级管理员'
    },
    {
      id: 2,
      name: '管理员'
    },
    {
      id: 3,
      name: '普通用户'
    }
  ]
  return {
    code: 200,
    data: groups,
    msg: ''
  }
}
export { getUserData, getUserGroups }
