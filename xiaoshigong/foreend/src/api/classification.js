/*
 * @Author: Joy wang
 * @Date: 2021-02-20 00:22:56
 * @LastEditTime: 2021-02-28 17:07:59
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import axios from '@/libs/api.request'
/** 获取城市区域组 */
export const getCity = ({id=""}={}) => {
  return axios.request({
    url: '/CityClass/vlist',
    params:{id},
    method: 'get'
  })
}


