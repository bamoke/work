/*
 * @Author: Joy wang
 * @Date: 2021-05-17 05:49:04
 * @LastEditTime: 2021-05-31 11:04:06
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */


/**监测表数据 */
export const get_data = () => {
    var data = {
        title: "工业企业产值监测表",
        tips: "产值排名前60的工业企业",
        column: {
            title: "企业名称",
            zjzl: "增加值率(%)",
            town: "所属街镇",
            gross: "工业总产值",
            rise: "同比增长",
        },
        data: [
            {
                title: "珠海粤裕丰钢铁有限公司",
                zjzl: "17.21/6.07",
                town: "南水",
                gross: "55.53",
                rise: "57.38",
            },
            {
                title: "中海石油深海开发有限公司",
                zjzl: "17.21/6.07",
                town: "南水",
                gross: "47.39",
                rise: "2.82",
            },
            {
                title: "珠海碧辟化工有限公司",
                zjzl: "10.41/29.73",
                town: "南水",
                gross: "26.25",
                rise: "3.66",
            },
            {
                title: "广东龙丰精密铜管有限公司",
                zjzl: "21.22",
                town: "南水",
                gross: "13.48",
                rise: "59.37",
            },
            {
                title: "珠海联邦制药股份有限公司",
                zjzl: "38.07/31.82",
                town: "三灶",
                gross: "21.18",
                rise: "9.69",
            },
            {
                title: "丽珠集团丽珠制药厂",
                zjzl: "21.22",
                town: "红旗",
                gross: "13.12",
                rise: "37.99",
            },
            {
                title: "三一海洋重工有限公司",
                zjzl: "21.22",
                town: "南水",
                gross: "13.48",
                rise: "59.37",
            },
            {
                title: "广东龙丰精密铜管有限公司",
                zjzl: "21.22",
                town: "平沙",
                gross: "13.01",
                rise: "10.33",
            },
            {
                title: "汤臣倍健股份有限公司",
                zjzl: "10.41",
                town: "南水",
                gross: "11.26129",
                rise: "-1.93",
            },
            {
                title: "珠海市金品创业共享平台科技有限公司",
                zjzl: "36.82/13.82",
                town: "红旗",
                gross: "10.18",
                rise: "-4.22",
            },
        ]
    }
    return Promise.resolve(data)
}