/*
 * @Author: Joy wang
 * @Date: 2021-02-20 00:22:56
 * @LastEditTime: 2021-02-26 17:44:20
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import axios from '@/libs/api.request'
/** 获取用户组 */
export const getUserInfo = (uid) => {
  return axios.request({
    url: '/User/info',
    params:{id:uid},
    method: 'get'
  })
}

export const getUserlist = ({ p, k = '', w = '' }) => {
  const data = { p, k, w }
  return axios.request({
    url: '/User/ulist',
    params: {
      ...data
    },
    method: 'get'
  })
}

export const saveUser = (data) => {
  return axios.request({
    url: '/User/save',
    data,
    method: 'post'
  })
}

export const deleteUser = (id) => {
  return axios.request({
    url: '/User/deleteone',
    params: { id },
    method: 'get'
  })
}
