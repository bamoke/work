/*
 * @Author: Joy wang
 * @Date: 2021-05-18 05:03:57
 * @LastEditTime: 2021-05-18 05:11:52
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
/**
 * 文字换行
 * @param {*} value 
 * @param {*} max 
 * @returns 
 */
export const formatStringWrap = (value,maxLength=3) => {
    var ret = "";
    var rowNum = Math.ceil(value.length / maxLength);
    if (rowNum > 1) {
        for (var i = 0; i < rowNum; i++) {
            var temp = "";
            var start = i * maxLength;
            var end = start + maxLength;
            temp = value.substring(start, end) + "\n";
            ret += temp;
        }
        return ret;
    } else {
        return value;
    }
}