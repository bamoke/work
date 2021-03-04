/*
 * @Author: Joy wang
 * @Date: 2021-02-20 00:22:56
 * @LastEditTime: 2021-02-28 16:56:08
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import axios from '@/libs/api.request'
/** 获取用户组 */
export const getCompanyInfo = (id) => {
  return axios.request({
    url: '/Company/info',
    params:{id},
    method: 'get'
  })
}

export const getCompanyList = ({ page='', keyword='' }={}) => {
  const data = { }
  if(page) {
    data.page = page
  }
  if(keyword) {
    data.keyword = keyword
  }
  return axios.request({
    url: '/Company/vlist',
    params: {
      ...data
    },
    method: 'get'
  })
}

export const saveCompanyData = (data) => {
  return axios.request({
    url: '/Company/save',
    data,
    method: 'post'
  })
}

export const deleteCompanyOne = (id) => {
  return axios.request({
    url: '/Company/deleteone',
    params: { id },
    method: 'get'
  })
}
