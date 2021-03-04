/*
 * @Author: Joy wang
 * @Date: 2021-02-25 08:33:24
 * @LastEditTime: 2021-03-04 13:54:13
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import axios from '@/libs/api.request'
/** 获取角色组 */


export const getRoleList = ({ keyword='' } = {}) => {
  // console.log(keyword)
  return axios.request({
    url: '/Role/vlist',
    params: {
      keyword
    },
    method: 'get'
  })
}

export const saveRole = (data) => {
  return axios.request({
    url: '/Role/save',
    data,
    method: 'post'
  })
}

export const deleteRole = (id) => {
  return axios.request({
    url: '/Role/deleteone',
    params: { id },
    method: 'get'
  })
}
