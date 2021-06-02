/*
 * @Author: Joy wang
 * @Date: 2021-05-17 05:49:04
 * @LastEditTime: 2021-06-02 01:29:27
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */

//重点企业数据
const keyComList = {
    data: [
        {
            id: 1,
            title: "珠海粤裕丰钢铁有限公司",
            addr: "珠海市金湾区南水镇电厂南路9号"
        },
        {
            id: 2,
            title: "珠海碧辟化工有限公司",
            addr: "珠海市金湾区高栏港经济区碧阳路1号"
        },
        {
            id: 2,
            title: "珠海联邦制药股份有限公司",
            addr: "珠海市金湾区三灶镇安基路2428号"
        },
        {
            id: 1,
            title: "广东龙丰精密铜管有限公司",
            addr: "珠海市金湾区红旗镇珠海大道中龙丰精密铜管公司"
        },
        {
            id: 1,
            title: "丽珠集团丽珠制药厂",
            addr: "珠海市金湾区高栏港经济区联港工业区创业北路38号"
        },
        {
            id: 1,
            title: "三一海洋重工有限公司",
            addr: "珠海市高栏港经济区装备制造区三虎大道西侧"
        },
        {
            id: 1,
            id: 1,
            title: "汤臣倍健股份有限公司",
            addr: "珠海市金湾区三灶科技工业园星汉路19号"
        },
        {
            id: 1,
            title: "广东珠海金湾发电有限公司",
            addr: "珠海市金湾区联港工业区电厂北路38号"
        },
        {
            id: 1,
            title: "珠海华宇金属有限公司",
            addr: "珠海市金湾区机场西路693号"
        },
        {
            id: 1,
            title: "长兴材料工业（广东）有限公司",
            addr: "珠海市金湾区南水镇珠海大道9523号"
        },
        {
            id: 1,
            title: "珠海三润混凝土有限公司",
            addr: "珠海市金湾区红旗镇小林联合水闸旁"
        },
        {
            id: 1,
            title: "珠海港鑫和码头有限公司",
            addr: "珠海市金湾区电厂南路9号"
        },
        {
            id: 1,
            title: "珠海恒基达鑫国际化工仓储股份有限公司",
            addr: "珠海市金湾区高栏港经济区南迳湾"
        },
        {
            id: 1,
            title: "长兴材料工业（广东）有限公司",
            addr: "珠海市金湾区南水镇珠海大道9523号"
        },
        {
            id: 1,
            title: "长兴材料工业（广东）有限公司",
            addr: "珠海市金湾区南水镇珠海大道9523号"
        },

    ]
}

const keyComDetail = [
    {},
    {
        title: "广东珠海金湾发电有限公司",
        industry: "工业",
        gross: "262534.6",
        gross_1: "253261.9",
        gross_2: "407202.6",
        rise: "3.66",
        rise_2: "-35.52",
        zjzl: "10.41/29.73",
        electric_gross: "9093.74",
        electric_gross_1: "9150.76",
        electric_rise: "-0.62",
        description: "上年同期1、3月检修，今年3、4月检修，正常生产的月份月均产量20万吨，检修期间基本保持在15万吨/月。1-4月PTA产量70.2万吨，去年70.1万吨，基本持平，4月价格持续升高至4000左右，较上年同期高出1100元/吨，增幅高达38.3%，较上月高100元/吨。"
    },
    {
        title: "广东珠海金湾发电有限公司",
        industry: "工业",
        gross: "555362.3",
        gross_1: "352872",
        gross_2: "337763.2",
        rise_1: "57.38",
        rise_2: "64.42",
        zjzl: "17.21",
        electric_gross: "15672.64",
        electric_gross_1: "14433.66",
        electric_rise: "8.58",
        description: "政府加大基建投资，企业今年市场需求良好，生产订单增加，企业去年受疫情影响，有部分生产线因工人暂时未及时赶回，影响生产，今年正常生产，故本期波动较大"
    }
]

//重点企业
export const get_list = ({ params = { cate: "default" } } = {}) => {

    return Promise.resolve(keyComList)
}

export const get_detail = ({ params = { id: 1 } } = {}) => {
    return Promise.resolve(keyComDetail[params.id])
}

