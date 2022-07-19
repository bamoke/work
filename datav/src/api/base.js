/*
 * @Author: Joy wang
 * @Date: 2021-05-11 12:18:30
 * @LastEditTime: 2021-06-01 06:08:06
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */

import Axios from './request'
/**经济运行简况 */
export const get_economy_introduce = () => {
    return Axios.request({
        url: 'EconomyIntroduce/get_data',
        method: 'get',
    })
}
/**
 * 所有指标的基本统计数
 * @param {*} param0 
 * @returns 
 */
export const get_total = ({ cate = '' } = {}) => {
    return Axios.request({
        url: 'Total/get_data',
        method: 'get',
        params: { cate }
    })
}
/**
 * 各镇所有指标的基本统计数
 * @returns 
 */
export const get_all_by_town = () => {
    return Axios.request({
        url: 'Total/get_all_by_town',
        method: 'get',
    })
}
/**
 * 各区所有指标的基本统计数
 * @returns 
 */
export const get_all_by_county = () => {
    return Axios.request({
        url: 'Total/get_all_by_county',
        method: 'get',
    })
}

/**
 * 全国、广东省、珠海市所有指标的基本统计数
 * @returns 
 */
export const get_all_by_country = () => {
    return Axios.request({
        url: 'Total/get_all_by_country',
        method: 'get',
    })
}
/**
 * 
 * @returns GDP 行业数据
 */
export const get_gdp_hangye = ({ cate }) => {
    return Axios.request({
        url: 'GdpHangye/get_data',
        method: 'get',
        params: { cate }
    })
}

/**
 * 
 * @param {*} param0 
 * @returns 
 */
export const get_gdp_chanye_history = () => {
    return Axios.request({
        url: 'GdpChanyeHistory/get_data',
        method: 'get',
    })
}

/**
 * 
 * @returns GDP 行业子类数据
 */
export const get_gdp_hangye_child = ({ cate }) => {
    return Axios.request({
        url: 'GdpHangye/get_child',
        method: 'get',
        params: { cate }
    })
}



// 固定资产投资
export const get_investment = ({ params } = {}) => {
    return Axios.request({
        url: 'InvestmentFixed/get_cate_total',
        method: 'get',
        params
    })
}



// 工业增加值总产值分行业
export const get_industry_hy = ({ params } = {}) => {
    return Axios.request({
        url: 'IndustryHangye/get_data',
        method: 'get',
        params
    })
}

// 工业增加值总产值-现代产业和规上民营企业
export const get_industry_xdmy = ({ params } = {}) => {
    return Axios.request({
        url: 'IndustryXdmy/get_data',
        method: 'get',
        params
    })
}


/**
 * 重点支柱产业工业增加值&总产值
 * cate string ['zjz','zcz']
 *  */
export const get_pillar = ({ params } = {}) => {
    return Axios.request({
        url: 'IndustryPillar/get_data',
        method: 'get',
        params
    })
}

/**一般公共预算,参照P27，输出两个数据模块 */
export const get_finance = ({ params }) => {
    return Axios.request({
        url: 'Finance/get_data',
        method: 'get',
        params
    })
}


// 机场港口
export const get_data_for_transport = ({ params } = {}) => {
    return Axios.request({
        url: 'Total/get_data_for_transport',
        method: 'get',
        params
    })
}

/**高栏港港口吞吐量分类统计情况 */
export const get_gk_goods = () => {
    return Axios.request({
        url: 'HarbourGoods/get_data',
        method: 'get'
    })
    var data = {
        total: {},
        data: [
            ["product", "总量", "增长率"],
            ["煤及制品", 1049, 26.2],
            ["成品油", 253, 22.9],
            ["液化石油气", 125, 58.7],
            ["化工原料及制品", 124, 48.9],
            ["矿石", 325, -16.3],
            ["矿物性建筑材料", 160, -13.2],
            ["其他货物", 787, 7.5],
        ]
    }
    return Promise.resolve(data)
}












