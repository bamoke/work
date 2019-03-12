import axios from '@/libs/api.request'
/** 获取用户组 */
export const getUserGroups = () => {
  return axios.request({
    url: 'User/groups',
    method: 'get'
  })
}

export const getUserlist = ({ p, k = '', w = '' }) => {
  const data = {p, k, w}
  return axios.request({
    url: 'User/ulist',
    params: {
      ...data
    },
    method: 'get'
  })
}

export const saveUser = (data) => {
  return axios.request({
    url: 'User/save',
    data,
    method: 'post'
  })
}

export const deleteUser = (id) => {
  return axios.request({
    url: 'User/deleteone',
    params: {id},
    method: 'get'
  })
}
