/*
 * @Author: Joy wang
 * @Date: 2021-02-15 07:24:48
 * @LastEditTime: 2021-02-20 00:40:39
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import HttpRequest from '@/libs/axios'
import config from '@/config'
const apiBaseUrl = config.apiBaseUrl

const axios = new HttpRequest(apiBaseUrl)
export default axios
