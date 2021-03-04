/*
 * @Author: Joy wang
 * @Date: 2021-02-15 07:24:48
 * @LastEditTime: 2021-03-04 13:56:43
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
export default {
  /**
   * @description 配置显示在浏览器标签的title
   */
  title: '小时工派遣管理系统V1.0.1',
  /**
   * @description token在Cookie中存储的天数，默认1天
   */
  cookieExpires: 1,
  /**
   * @description 是否使用国际化，默认为false
   *              如果不使用，则需要在路由中给需要在菜单中展示的路由设置meta: {title: 'xxx'}
   *              用来在菜单中显示文字
   */
  useI18n: false,
  /**
   * @description api请求基础路径
   */
  apiBaseUrl: process.env.NODE_ENV === 'development' ? '/xiaoshigong/backend/index.php/' : 'http://xsg.bamoke.com/backend/index.php',
  webBaseUrl: process.env.NODE_ENV === 'development' ? '/' : '/',

  /**
   * @description 默认打开的首页的路由name值，默认为home
   */
  homeName: 'home',
  /**
   * @description 需要加载的插件
   */
  plugin: {
    'error-store': {
      showInHeader: true, // 设为false后不会在顶部显示错误日志徽标
      developmentOff: true // 设为true后在开发环境不会收集错误信息，方便开发中排查错误
    }
  }
}
