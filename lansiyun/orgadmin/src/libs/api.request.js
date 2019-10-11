import HttpRequest from '@/libs/axios'
import config from '@/config'
const apiBaseUrl = config.apiBaseUrl

const axios = new HttpRequest(apiBaseUrl)
export default axios
