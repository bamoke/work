/*
 * @Author: Joy wang
 * @Date: 2021-02-20 00:22:56
 * @LastEditTime: 2021-02-28 18:03:13
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import axios from '@/libs/api.request'
/** 获取用户组 */
export const getStationerInfo = (id) => {
  return axios.request({
    url: '/Stationer/info',
    params:{id},
    method: 'get'
  })
}

export const getStationerList = ({ page='', keyword='' }={}) => {
  const data = { }
  if(page) {
    data.page = page
  }
  if(keyword) {
    data.keyword = keyword
  }
  return axios.request({
    url: '/Stationer/vlist',
    params: {
      ...data
    },
    method: 'get'
  })
}

export const saveStationerData = (data) => {
  return axios.request({
    url: '/Stationer/save',
    data,
    method: 'post'
  })
}

export const deleteStationerOne = (id) => {
  return axios.request({
    url: '/Stationer/deleteone',
    params: { id },
    method: 'get'
  })
}
