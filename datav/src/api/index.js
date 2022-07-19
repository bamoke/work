/*
 * @Author: Joy wang
 * @Date: 2021-05-14 15:39:00
 * @LastEditTime: 2021-05-31 10:40:04
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
const nameRule = {
    sczz: "生产总值",
    gyzjz: "工业增加值",
    gyzcz: "工业总产值",
    gdzctz: "固定资产投资",
    wstz: "实际吸收外商投资",
    wmjck: "外贸进出口",
    xfpls: "社会消费品零售",
    ggys: "一般公共预算",
    jcgk: "机场港口",

}
// base 主要内容再P3-P28
const table_base = {
    base_sczz: ["金湾区地区生产总值分行业情况", "金湾直属地区生产总值分行业情况", "开发区生产总值分行业情况"],

    base_gyzjz: "规模以上工业增加值",
    base_gyzjz_hy: "规模以上工业分行业工业增加值",
    base_gyzjz_zdzz: "重点支柱产业工业增加值",
    base_gyzjz_xdmq: "现代产业和规上民营企业增加值",

    base_gyzcz: "规模以上工业总产值及销售产值",
    base_gyzcz_hy: "规模以上工业分行业工业总产值",
    base_gyzcz_zdzz: "重点支柱产业工业总产值",
    base_gyzcz_xdmq: "现代产业和规上民营企业总产值",

    base_gsgyjjxy: "规模以上工业经济效益",
    base_gdpnh: "GDP能耗及规上工业能源消费情况",
    base_shydl: "全社会用电量",
    base_pflszscy: "限额以上批发零售业、住宿餐饮业",
    base_nyxf_sw: "能源品种实物量消费情况",
    base_nyxf_bzl: "能源品种标准量消费情况",

    base_gdzctz: "固定资产投资完成情况",
    base_fdc_kfjy: "房地产开发与经营",

    base_gsfwy: "规模以上服务业分行业营业收入",
    base_ggys: "一般公共预算收入和支出情况）",
    base_gk_glg: "高栏港港口吞吐量分类统计情况",
    base_gk_all: "全市分港区吞吐量统计情况"

}

// 主要经济指标
const table_jjzb = {
    jjzb_town: "各镇主要经济指标",
    jjzb_county: "各区主要经济指标",
    jjzb_city: "珠海市主要经济指标",
    jjzb_domestic: "国内其他区域主要经济指标",
}

// 主要经济指标时间系列，按月(P37-P48)
const table_timeline_month = {
    sjzb_sczz: "地区生产总值",
    sjzb_gyzjz: "规模以上工业增加值",
    sjzb_gyzcz: "规模以上工业总产值",
    sjzb_gdzctz: "固定资产投资",
    sjzb_wmjck: "外贸进出口",
    sjzb_wmjck_ck: "外贸出口",
    sjzb_wstz: "实际利用外商直接投资",
    sjzb_shxfpls: "社会消费品零售总额",
    sjzb_ggys_sr: "一般公共预算收入",
    sjzb_ggys_zc: "一般公共预算支出",
    sjzb_jcgk_jc: "珠海机场吞吐量",
    sjzb_jcgk_gk: "高栏港港口吞吐量",
}

// 主要经济指标时间系列，单表，key为参数，按年（P49-P50=20年区主要经济指标）
const table_timeline_year = {
    sczz: "地区生产总值",
    gyzjz: "规模以上工业增加值",
    gyzcz: "规模以上工业总产值",
    gdzctz: "固定资产投资",
    wmjck: "外贸进出口",
    wmjck_ck: "外贸出口",
    wstz: "实际利用外商直接投资",
    shxfpls: "社会消费品零售总额",
    ggys_sr: "一般公共预算收入",
    ggys_zc: "一般公共预算支出",
    jcgk_jc: "珠海机场吞吐量",
    jcgk_gk: "高栏港港口吞吐量",
}

// 指标对比
const table_zbdb = "金湾区与国内部分区域主要指标对比表"

//检测表
const table_jc ="10个检测表"

// 重点企业
const table_zdqy = "金湾区(珠海经济开发区)2021年1-3月重点企业经营情况"


/*** */
import *  as jjzb from './jjzb'
import *  as base from './base'
import *  as timeline from './timeline'

export {jjzb,base,timeline}