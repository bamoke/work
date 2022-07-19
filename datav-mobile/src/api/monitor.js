/*
 * @Author: Joy wang
 * @Date: 2021-05-17 05:49:04
 * @LastEditTime: 2021-05-31 11:04:06
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */

import Axios from './request'

/**
 * 重点支柱产业企业类别
 * @param {cate} param0 
 * @returns 
 */
 export const get_pillar_cate = ({params}) => {
    return Axios.request({
        url: 'IndustryPillar/get_cate',
        method: 'get',
        params
    })
}

/**监测表数据 */
/**
 * 重点支柱产业企业
 * @param {cate} param0 
 * @returns 
 */
export const get_pillar_com = ({params}) => {
    return Axios.request({
        url: 'IndustryPillar/get_comlist',
        method: 'get',
        params
    })
}

/**
 * 固定资产投资项目情况
 * @param {cate} param0 
 * @returns 
 */
 export const get_investment_com = ({params}) => {
    return Axios.request({
        url: 'InvestmentFixed/get_com_list',
        method: 'get',
        params
    })
}

/**
 * 固定资产投资项目情况
 * @param {cate} param0 
 * @returns 
 */
 export const get_investment_cate = ({params}) => {
    return Axios.request({
        url: 'InvestmentFixed/get_cate',
        method: 'get',
        params
    })
}