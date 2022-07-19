/*
 * @Author: Joy wang
 * @Date: 2021-05-17 05:49:04
 * @LastEditTime: 2021-06-02 05:08:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Axios from './request'

/**
 * 用电量
 * @param {*} param0 
 * @returns 
 */
export const get_electric_use = ({ params } = {}) => {
    let url = "Nenghao/get_electric"
    if(params.cate && params.cate=='all') {
        url = 'Nenghao/get_electric_all'
    }
    return Axios.request({
        url,
        method: 'get',
        params
    })
}

/**
 * GDP能耗及规上工业能源消费情况
 * @param {*} param0 
 * @returns 
 */
export const get_nenghao = ({ params } = {}) => {
    return Axios.request({
        url: 'Nenghao/get_gdp_nenghao',
        method: 'get',
        params
    })
}

/**
 * GDP能耗及规上工业能源消费情况
 * @param {*} param0 
 * @returns 
 */
 export const get_nengyuan_use = () => {
    return Axios.request({
        url: 'Nenghao/get_nengyuan_use',
        method: 'get'
    })
}

/**
 * 
 */
export const get_rise_compare = ()=>{
    return Axios.request({
        url: 'Nenghao/get_rise_compare',
        method: 'get'
    })
}


