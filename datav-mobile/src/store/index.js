import Vue from 'vue'
import Vuex from 'vuex'
import Cookies from 'js-cookie'

Vue.use(Vuex)

const themeList = {
  "theme-default": {
    name: "theme-default",
    showBgVideo: true,
    echartTheme: "macarons",
    mainBackground: ""
  },
  'theme-flat-light': {
    name: "theme-flat-light",
    showBgVideo: false,
    mainBackground: "",
    echartTheme: "macarons"
  },
  'theme-flat-dark': {
    name: "theme-flat-dark",
    showBgVideo: false,
    mainBackground: "",
    echartTheme: "macarons"
  }
}

const curDate = new Date();



const getTheme = () => {

  const themeName = Cookies.get("theme") || "theme-default"
  return themeList[themeName]
}

const store = new Vuex.Store({
  state: {
    theme: getTheme(),
    curDate: null,
    minDate:null,
    maxDate:null,
    curParentNav:""
  },
  mutations: {
    setTheme(state, themeName) {
      state.theme = themeList[themeName]
      Cookies.set("theme", themeName)
    },
    setCurDate(state,date) {
      state.curDate  = date
    },
    setMinDate(state,date) {
      state.minDate  = date
    },
    setMaxDate(state,date) {
      state.maxDate  = date
    },
    setCurParentNav(state,navName){
      state.curParentNav  = navName
    }
  }
})
export default store