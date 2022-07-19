/*
 * @Author: Joy wang
 * @Date: 2021-05-17 05:49:04
 * @LastEditTime: 2021-06-02 01:29:27
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */

//重点企业经营情况数据

import Axios from './request'

//重点企业列表
export const get_list = ({ params} = {}) => {

    return Axios.request({
        url: 'KeyEnterprises/get_list',
        method: 'get',
        params
      })
}

/**
 * 重点企业地图数据
 * @returns 
 */
export const get_list_by_map = ()=>{
  return Axios.request({
    url: 'KeyEnterprises/get_list_by_map',
    method: 'get',
  })
}

export const get_cate = () => {
    return Axios.request({
        url: 'KeyEnterprises/get_cate',
        method: 'get'
      })
}

export const get_detail = (id) => {
    return Axios.request({
        url: 'KeyEnterprises/get_detail',
        method: 'get',
        params:{id}
      })
}





