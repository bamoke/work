/*
 * @Author: Joy wang
 * @Date: 2021-05-17 05:49:04
 * @LastEditTime: 2021-06-02 05:08:00
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
import Axios from './request'

// 登录
export const do_login = (formData) => {
    return Axios.request({
        url: 'User/do_login',
        method: 'post',
        data:formData
      })
}

export const get_sys_date = ()=>{
    return Axios.request({
        url: 'SysSetting/get_sys_date',
        method: 'get',
      })
}


