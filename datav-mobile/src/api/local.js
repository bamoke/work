/*
 * @Author: Joy wang
 * @Date: 2021-05-11 12:18:43
 * @LastEditTime: 2021-05-11 12:54:46
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import axios from 'axios'
export const getEchartTheme = theme =>{
    let url = '../assets/echarttheme/'+theme+'.project.json'
    console.log(url)
    return axios.get({
        url
    })
}
