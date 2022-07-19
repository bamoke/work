/*
 * @Author: Joy wang
 * @Date: 2021-05-17 05:49:04
 * @LastEditTime: 2021-06-02 05:08:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Axios from './request'


export const get_town = ({ params } = {}) => {

    return Axios.request({
        url: 'Economy/get_town',
        method: 'get',
        params
    })
}

/**
 * 各区比较
 * @param {*} param0 
 * @returns 
 */
export const get_county = ({ params } = {}) => {
    return Axios.request({
        url: 'Economy/get_county',
        method: 'get',
        params
    })
}


/**国内其他区域比较 */
export const get_domestic = ({params} = {}) => {
    return Axios.request({
        url: 'Economy/get_domestic',
        method: 'get',
        params
    })
}