import HttpRequest from '@/libs/axios'
import config from '@/config'
const apiBaseUrl = process.env.NODE_ENV === 'development' ? config.apiBaseUrl.dev : config.apiBaseUrl.pro

const axios = new HttpRequest(apiBaseUrl)
export default axios
