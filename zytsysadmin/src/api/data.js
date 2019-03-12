import axios from '@/libs/api.request'

const getUserData = () => {
  return axios.request({
    url: 'get_user_data',
    method: 'get'
  })
}
const getUserGroups = () => {
  return axios.request({
    url: 'get_user_groups',
    method: 'get'
  })
}

const getTableList = (apiUrl, data) => {
  return axios.request({
    url: apiUrl,
    params: data,
    method: 'get'
  })
}
const getDataOne = (apiUrl, data) => {
  return axios.request({
    url: apiUrl,
    params: data,
    method: 'get'
  })
}
const saveData = (apiUrl, data) => {
  return axios.request({
    url: apiUrl,
    data,
    method: 'post'
  })
}
/** delete one data  */
const deleteDataOne = (apiUrl, id) => {
  return axios.request({
    url: apiUrl,
    params: { id },
    method: 'get'
  })
}
export { getUserData, getUserGroups, getTableList, saveData, deleteDataOne, getDataOne }
