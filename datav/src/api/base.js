/*
 * @Author: Joy wang
 * @Date: 2021-05-11 12:18:30
 * @LastEditTime: 2021-06-01 06:08:06
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
export const get_sczz = () => {
    var data = {
        total: {
            num: 1554497,
            measure: "万元",
            rise: 20.1
        },
        data: {
            cy: {
                title: "",
                data: [
                    ["product","总量","同比增长","比重","GDP贡献","拉动GDP增长点"],
                    ["第一产业", 29825, -0.9, 1.9, -0.1, 0],
                    ["第二产业", 1101380, 24.4, 70.9, 74.6, 15.0],
                    ["第三产业", 423293, 18.3, 27.2, 25.5, 5.1],
                ]
            },
            hy: {
                title: "",
                data: [
                    ["农林牧渔业", 30662, -0.9, 1.9, -0.1, 0],
                    ["工业", 1042415, 22.3, 70.9, 73.6, 14.7],
                    ["建筑业", 59025, 18.3, 27.2, 1.5, 0.3],
                    ["批发和零售业", 75196, 18.3, 27.2, 6.9, 1.4],
                    ["交通运输、仓储和邮政业", 30592, 18.3, 27.2, 2.9, 0.6],
                    ["住宿和餐饮业", 6873, 12.3, 27.2, 0.8, 0.2],
                    ["金融业", 46263, 3.3, 27.2, 1.5, 0.3],
                    ["房地产业", 97389, 2.3, 27.2, 8.8, 1.8],
                    ["营利性服务业", 66039, 18.3, 27.2, 2.6, 0.5],
                    ["非营利性服务业", 101044, 15.3, 27.2, 1.9, 0.4],
                ]
            }
        }
    }
    return Promise.resolve(data)
}

export const get_gdzctz = () => {
    var data = {
        total: {
            num: 131.41,
            measure: "亿元",
            rise: 41.6
        },
        data: {
            gross: [
                ["product", "金湾区", "金湾直属", "开发区"],
                ["工业投资", 35.15, 17.88, 17.27],
                ["技术改造投资", 4.75, 2.30, 2.45],
                ["装备制造业投资", 9.43, 2.59, 6.83],
                ["基础设施投资", 25.50, 21.09, 4.41],
                ["房地产开发投资", 79.11, 66.72, 12.39],
            ],
            rise: [
                ["product", "金湾区", "金湾直属", "开发区"],
                ["工业投资", 37.9, 149.3, -5.8],
                ["技术改造投资", -38.6, 37.5, -59.5],
                ["装备制造业投资", -13.43, -20.1, -106],
                ["基础设施投资", 9.1, 58.3, -56.2],
                ["房地产开发投资", 94.7, 96.7, 84.4],
            ]
        }
    }
    return Promise.resolve(data)
}

export const get_gyzjz = () => {
    var data = {
        total: {
            num: 1144935,
            measure: "万元",
            rise: 27.8
        },
        data: [
            ["金湾区", 1144935, 27.8],
            ["金湾直属", 464093, 28.6],
            ["开发区", 680842, 27.1],
        ]
    }
    return Promise.resolve(data)
}

export const get_gyzcz = () => {
    var data = {
        total: {
            num: 4848292,
            measure: "万元",
            rise: 29.6
        },
        data: [
            ["金湾区", 4848292, 29.6],
            ["金湾直属", 1817446, 31.5],
            ["开发区", 3030846, 28.5],
        ]
    }
    return Promise.resolve(data)
}

/**重点支柱产业工业增加值 */
export const get_gyzjz_zdzz = () => {
    var data = {
        total: {},
        data: [
            ["生物医药", 167370, 18.7],
            ["高端打印设备", 22691, 36.9],
            ["高端精细化工", 154617, 19.0],
            ["新能源", 25864, 57.7],
            ["清洁能源", 248184, 23.9],
            ["智能家电", 87608, 40.6],
            ["船舶与海洋装备制造", 43542, 45.1],

            ["钢铁制造", 70111, 42.3],
            ["电力生产", 29889, 34.4],
            ["传统优势", 308754, 31.9],
        ]
    }
    return Promise.resolve(data)
}

/**重点支柱产业工业总产值 */
export const get_gyzcz_zdzz = () => {
    var data = {
        total: {},
        data: [
            ["生物医药", 167370, 18.7],
            ["高端打印设备", 22691, 36.9],
            ["高端精细化工", 154617, 19.0],
            ["新能源", 25864, 57.7],
            ["清洁能源", 248184, 23.9],
            ["智能家电", 87608, 40.6],
            ["船舶与海洋装备制造", 43542, 45.1],

            ["钢铁制造", 70111, 42.3],
            ["电力生产", 29889, 34.4],
            ["传统优势", 308754, 31.9],
        ]
    }
    return Promise.resolve(data)
}

/**一般公共预算,参照P27，输出两个数据模块 */
export const get_ggys = () => {
    var data = {
        income: {
            total: {
                num: 114753,
                measure: "万元",
                rise: 0.7
            },
            child:[
                ["税收收入",10.2,18.1],
                ["非税收入",1.27,-53.8],
            ],
            data: [
                ["增值税", 31449, -20.9],
                ["营业税", 22691, 36.9],
                ["企业所得税", 24153, 19.0],
                ["个人所得税", 3225, 57.7],
            ],

        },
        expend: {
            total: {
                num: 269647,
                measure: "万元",
                rise: 50.0
            },
            data: [
                ["一般公共服务", 36519, 89.2],
                ["公共安全", 6015, 41.9],
                ["教育", 45303, 17.9],
                ["科学技术", 10641, 387.0],
                ["社会保障和就业", 21864, 153.7],
                ["卫生健康", 27996, 12.7],
                ["节能环保", 77879, 31.7],
                ["城乡社区", 22221, 493.4],
            ]
        }
    }
    return Promise.resolve(data)
}


/**高栏港港口吞吐量分类统计情况 */
export const get_gk_glg = () => {
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

/**
 * 外商投资 输出近一年数据 
 * 没有对应的base数据页面，暂时输出近一年数据
*/
export const get_wstz = () => {
    var data = {
        total: {
            num: 2603,
            measure: "万美元",
            rise: 154.2
        },
        data: [
            ["2020年3月", -95.7, -91.5, -98.1],
            ["2020年4月", -95.9, -95.5, -96.1],
            ["2020年5月", -95.4, -95.5, -94.1],
            ["2020年6月", -83.7, -73.5, -93.1],
            ["2020年7月", -82.9, -73.5, -93.1],
            ["2020年8月", -82.9, -73.5, -93.1],
            ["2020年9月", -82.1, -73.5, -91.1],
            ["2020年10月", -81.7, -72.5, -90.1],
            ["2020年11月", -75.7, -61.5, -89.1],
            ["2020年12月", -73.7, -58.5, -89.1],
            ["2021年2月", 838.5, 0, 838.5],
            ["2021年3月", 154.2, -100.0, 846.5],
        ]
    }
    return Promise.resolve(data)
}

/**
 * 外贸进出口 基本数据中包含两类（进出口总额数据，出口数据）
 * 没有对应的base数据页面，模拟当期数据
 * 
 *  */
export const get_wmjck = () => {
    var data = {
        total: {
            num: 4848292,
            measure: "万元",
            rise: 29.6
        },
        data: {
            tradeall: [
                ["金湾区", 185.06, 42.5],
                ["金湾直属", 71.43, 45.5],
                ["开发区", 110.11, 40.5],
            ],
            tradeout: [
                ["金湾区", 91.43, 47.6],
                ["金湾直属", 51.73, 48.5],
                ["开发区", 39.70, 40.5],
            ]
        }
    }
    return Promise.resolve(data)
}

/**与其他区指标对比雷达图 */
export const get_zbdb = () => {
    var data = {
        data: [
            ["横琴新区", 123.99, 15.0],
            ["香洲区", 369.64, 44.7],
            ["金湾区", 155.45, 18.8],
            ["斗门区", 95.34, 11.5],
            ["高新区", 82.05, 9.9],
        ],
        data_bf: [
            ["product", "横琴新区", "香洲区", "金湾区", "斗门区", "高新区"]
            ["地区生产总值", 123.99, 369.64, 155.45, 95.34, 82.05],
            ["工业增加值", 14.25, 92.24, 114.49, 42.63, 25.16],
            ["固定资产投资额", 112.58, 103.84, 131.41, 66.35, 50.10],
            ["社会消费品零售总额", 6.30, 196.63, 12.19, 20.70, 18.11],
            ["外贸进出口", 118.53, 242.61, 185.54, 91.65, 150.44],
            ["外商投资", 99830, 7105, 2603, 6, 6757],
            ["一般公共预算收入", 35.06, 10.82, 11.48, 9.13, 8.83],
            ["一般公共预算支出", 39.29, 24.23, 26.96, 21.74, 9.18],
        ]
    }
    return Promise.resolve(data)
}

/**社会消费品零售总额
 * base 页面中没有,chart数据暂时从时间表中取
 */
export const get_xfpls = () => {
    var data = {
        total: {
            num: 12.19,
            measure: "亿元",
            rise: 25.4
        },
        data: [
            ["2020年3月", 15, -91.5, -98.1],
            ["2020年4月", 16, -95.5, -96.1],
            ["2020年5月", 14, -95.5, -94.1],
            ["2020年6月", 22, -73.5, -93.1],
            ["2020年7月", 31, -73.5, -93.1],
            ["2020年8月", 12, -73.5, -93.1],
            ["2020年9月", 2, -73.5, -91.1],
            ["2020年10月", -10, -72.5, -90.1],
            ["2020年11月", 5, -61.5, -89.1],
            ["2020年12月", 21, -58.5, -89.1],
            ["2021年2月", 42, 0, 838.5],
            ["2021年3月", 12, -100.0, 846.5],
        ]

    }
    return Promise.resolve(data)
}





