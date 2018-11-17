import Mock from 'mockjs'
import { login, logout, getUserInfo } from './login'
import { getUserData, getUserGroups } from './data'

// 登录相关和获取用户信息
Mock.mock(/\/login/, login)
Mock.mock(/\/get_info/, getUserInfo)
Mock.mock(/\/logout/, logout)
Mock.mock(/\/get_user_data/, getUserData)
Mock.mock(/\/get_user_groups/, getUserGroups)

export default Mock
