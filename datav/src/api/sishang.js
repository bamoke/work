/*
 * @Author: Joy wang
 * @Date: 2021-05-17 05:49:04
 * @LastEditTime: 2021-06-02 05:08:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Axios from './request'


export const get_total = ({ params } = {}) => {

    return Axios.request({
        url: 'Sishang/get_total',
        method: 'get',
        params
    })
}

export const get_list = ({ params } = {}) => {

    return Axios.request({
        url: 'Sishang/get_list',
        method: 'get',
        params
    })
}

export const get_cate = () => {

    return Axios.request({
        url: 'Sishang/get_cate',
        method: 'get',
    })
}

