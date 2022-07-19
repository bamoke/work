import axios from '@/libs/api.request'

export const getUserList = ({ p, k = '', w = '' }) => {
  const data = { p, k, w }
  return axios.request({
    url: '/Users/getlist',
    params: {
      ...data
    },
    method: 'get'
  })
}

export const getDetail = (id) => {
  return axios.request({
    url: '/Users/get_detail',
    params:{id},
    method: 'get'
  })
}


export const saveUser = (data) => {
  return axios.request({
    url: '/Users/save',
    data,
    method: 'post'
  })
}

export const deleteUser = (id) => {
  return axios.request({
    url: '/Users/deleteone',
    params: { id },
    method: 'get'
  })
}

export const getUserRoles = () => {
  return axios.request({
    url: '/Users/get_role_list',
    method: 'get'
  })
}
