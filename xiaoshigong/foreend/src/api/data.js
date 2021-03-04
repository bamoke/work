/*
 * @Author: Joy wang
 * @Date: 2021-02-15 07:24:47
 * @LastEditTime: 2021-03-03 06:57:02
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import axios from '@/libs/api.request'

export const getTableData = () => {
  return axios.request({
    url: 'get_table_data',
    method: 'get'
  })
}

export const getDragList = () => {
  return axios.request({
    url: 'get_drag_list',
    method: 'get'
  })
}

export const errorReq = () => {
  return axios.request({
    url: 'error_url',
    method: 'post'
  })
}

export const saveErrorLogger = info => {
  return axios.request({
    url: 'save_error_logger',
    data: info,
    method: 'post'
  })
}

export const uploadImg = formData => {
  return axios.request({
    url: 'image/upload',
    data: formData
  })
}

export const getOrgData = () => {
  return axios.request({
    url: 'get_org_data',
    method: 'get'
  })
}

export const getTreeSelectData = () => {
  return axios.request({
    url: 'get_tree_select_data',
    method: 'get'
  })
}
export const getTableList = (apiUrl, data) => {
  return axios.request({
    url: apiUrl,
    params: data,
    method: 'get'
  })
}
export const getDataOne = (apiUrl, data) => {
  return axios.request({
    url: apiUrl,
    params: data,
    method: 'get'
  })
}
export const saveData = (apiUrl, data) => {
  return axios.request({
    url: apiUrl,
    data,
    method: 'post'
  })
}
/** delete by id  */
export const deleteDataOne = (apiUrl, id) => {
  return axios.request({
    url: apiUrl,
    params: { id },
    method: 'get'
  })
}

/** delete data  */
export const deleteData = (apiUrl, data) => {
  return axios.request({
    url: apiUrl,
    params: { ...data },
    method: 'get'
  })
}
