import axios from 'axios'
import store from '@/store'
import { Message } from 'iview'
import Cookies from 'js-cookie'
import { TOKEN_KEY } from '@/libs/util'
// import { Spin } from 'iview'

class HttpRequest {
  constructor (baseUrl = baseURL) {
    this.baseUrl = baseUrl
    this.queue = {}
  }
  getInsideConfig () {
    const config = {
      baseURL: this.baseUrl,
      headers: {
        //
      }
    }
    return config
  }
  destroy (url) {
    delete this.queue[url]
    if (!Object.keys(this.queue).length) {
      // Spin.hide()
    }
  }
  interceptors (instance, url) {
    // 请求拦截
    instance.interceptors.request.use(config => {
      // 添加全局的loading...
      if (!Object.keys(this.queue).length) {
        // Spin.show() // 不建议开启，因为界面不友好
      }
      this.queue[url] = true
      config.headers['x-access-token'] = Cookies.get(TOKEN_KEY)
      return config
    }, error => {
      return Promise.reject(error)
    })
    // 响应拦截
    instance.interceptors.response.use(res => {
      this.destroy(url)
      const { data } = res
      if (data.code !== 200) {
        // 登录状态判断
        if (data.code === 11001 || data.code === 11002) {
          Cookies.remove(TOKEN_KEY)
          Message.error(data.msg)
          window.location.href = '/login'
        } else {
          if (data.msg) Message.error(data.msg)
        }
        return false
      }
      return data
    }, error => {
      this.destroy(url)
      Message.error('服务内部错误')
      // 对响应错误做点什么
      return Promise.reject(error)
    })
  }
  request (options) {
    const instance = axios.create()
    options = Object.assign(this.getInsideConfig(), options)
    this.interceptors(instance, options.url)
    return instance(options)
  }
}
export default HttpRequest
