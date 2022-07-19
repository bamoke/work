/*
 * @Author: Joy wang
 * @Date: 2021-05-17 05:49:04
 * @LastEditTime: 2021-06-02 05:08:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
const countyData = {
    default: {
        data: [
            ["高新区", 82.05, 9.9],
            ["斗门区", 95.34, 11.5],
            ["金湾区", 155.45, 18.8],
            ["香洲区", 369.64, 44.7],
            ["横琴新区", 123.99, 15.0],
        ]
    },
    financeincome: {
        data: [
            ["高新区", 8.83, 38.5],
            ["斗门区", 9.13, 11.5],
            ["金湾区", 11.48, 0.7],
            ["香洲区", 10.82, 14.9],
            ["横琴新区", 35.06, 52.3],
        ]
    },
    financeexpend: {
        data: [
            ["高新区", 9.18, 96.9],
            ["斗门区", 21.74, 9.0],
            ["金湾区", 26.96, 50],
            ["香洲区", 24.23, -9.5],
            ["横琴新区", 39.29, 128.0],
        ]
    }
}

export const get_town = ({ params = {} } = {}) => {

    var data
    if (params.cate == '固定投资') {
        data = {
            data: [
                ["product", "全社会固定投资", "工业投资", "技改投资", "装备制造业投资", "房地产开发投资"]
                ["三灶镇", 67.75, 15.0],
                ["红旗镇", 369.64, 44.7],
                ["南水镇", 155.45, 18.8],
                ["平沙镇", 95.34, 11.5],
            ]
        }
    } else {

        data = {
            data: [
                ["三灶镇", 123.99, 15.0],
                ["红旗镇", 369.64, 44.7],
                ["南水镇", 155.45, 18.8],
                ["平沙镇", 95.34, 11.5],
            ]
        }
    }
    return Promise.resolve(data)
}

export const get_county = ({ params = { cate: "default" } } = {}) => {

    return Promise.resolve(countyData[params.cate])
}

export const get_city = () => {
    var data = {
        data: [
        ]
    }
    return Promise.resolve(data)
}

/**国内其他区域比较 */
export const get_domestic = () => {
    var data = {
        tips: "",
        data: [
            ["product","总值","增长率"],
            ["金湾区", 65.32, 51.1],
            ["苏州工业园", 52.8, 45],
            ["深圳龙岗区", 76, 95.5],
        ]
    }
    return Promise.resolve(data)
}