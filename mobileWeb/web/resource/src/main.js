// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

// import 'element-ui/lib/theme-default/index.css'

// 使用v-tap插件
import VueTap from 'v-tap'
Vue.use(VueTap)

// 引入获取cookie的工具方法
import {getCookie} from './util/cookie.js'
// 获取token
const token = getCookie('auth')

require('es6-promise').polyfill()
import Axios from 'axios'

// 设置超时时间和请求头
let _axios = Axios.create({
  timeout: 10000,
  headers: {'Authorization': token ? 'Bearer ' + token : ''}
})

// 引入mint-ui的loading
// import { Indicator } from 'mint-ui'
import MintUi from 'mint-ui'
Vue.use(MintUi)

// 全局请求拦截器，开启loading效果
_axios.interceptors.request.use(function (config) {
  MintUi.Indicator.open()
  return config
}, function (error) {
  return Promise.reject(error)
})
// 全局响应拦截器，关闭loading效果
_axios.interceptors.response.use(function (response) {
  MintUi.Indicator.close()
  return response
}, function (error) {
  if (error.response.status === 401) {
    // MintUi.Toast({
    //   message: '你的账号已在其他地方登录，请重新登录',
    //   position: 'middle',
    //   duration: 2000
    // })
    // 调登录方法
    BHWEB.action('toLogin', '')
  }
  MintUi.Indicator.close()
  return Promise.reject(error)
})
Vue.prototype.$axios = _axios

import HttpConfig from './service/getData.js'
Vue.prototype.$httpConfig = HttpConfig

// 设置fastClick
import FastClick from 'fastclick'
FastClick.attach(document.body)

// 设置时间过滤器
Vue.filter('converTime', function (time) {
  let d = new Date(time)
  let year = d.getFullYear()
  let month = d.getMonth() + 1 < 10 ? '0' + (d.getMonth() + 1) : d.getMonth() + 1
  let day = d.getDate() < 10 ? '0' + d.getDate() : '' + d.getDate()
  return year + '-' + month + '-' + day + ' '
})
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
