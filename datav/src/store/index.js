import Vue from 'vue'
import Vuex from 'vuex'
import Cookies from 'js-cookie'

Vue.use(Vuex)

const themeList = {
  "theme-default":{
    name: "theme-default",
    showBgVideo: true,
    echartTheme: "macarons",
    mainBackground:""
  },
  'theme-flat-light':{
    name:"theme-flat-light",
    showBgVideo: false,
    mainBackground:"",
    echartTheme: "macarons"
  },
  'theme-flat-dark':{
    name:"theme-flat-dark",
    showBgVideo: false,
    mainBackground:"",
    echartTheme: "macarons"
  }
}

const getTheme = () => {

  const themeName = Cookies.get("theme") || "theme-default"
  return themeList[themeName]
}

const store = new Vuex.Store({
  state: {
    theme: getTheme()
  },
  mutations: {
    setTheme(state, themeName) {
      state.theme = themeList[themeName]
      Cookies.set("theme", themeName)
    }
  }
})
export default store