/*
 * @Author: Joy wang
 * @Date: 2021-05-17 06:18:18
 * @LastEditTime: 2021-05-31 03:32:23
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Axios from './request'


/***
 * 年度表,只有两个区域，相比月度表，没有【金湾区】
 * @params type String 指标名称(type='工业增加值')
 * @s 开始年份
 * @e 截止年份
 */
export const get_yeardata = ({ params } = {}) => {

    return Axios.request({
        url: 'Timeline/get_yeardata',
        method: 'get',
        params
    })
}

/**
 * 机场港口年度数据
 * @param {*} param0 
 * @returns 
 */
export const get_yeardata_transport = ({ params } = {}) => {

    return Axios.request({
        url: 'Timeline/get_transport_by_year',
        method: 'get',
        params
    })
}


/***
 * 月度表,指输出增长率
 * @params type String 指标名称(cate='工业增加值')
 * @params area string  区域标识 (area=金湾区|金湾直属|开发区，默认area=金湾区)
 * @s 开始年月
 * @e 截止年月
 */
export const get_monthdata = ({ params } = {}) => {
    return Axios.request({
        url: 'Timeline/get_monthdata',
        method: 'get',
        params
    })
}
