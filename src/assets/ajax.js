import Axios from 'axios'
import Qs from 'qs'
// 配置默认请求域名头
Axios.defaults.baseURL = 'https://qiatia.cn/api/',

Axios.interceptors.request.use(config => {
  return config
}, err => {
  return Promise.reject(err)
})
Axios.interceptors.response.use(res => {
  return res
}, err => {
  console.log('Link Error, Please check your network!')
  return Promise.reject(err)
})
// 配置默认post请求头
Axios.defaults.headers['Content-Type'] = 'application/x-www-form-urlencoded'
// 重定义 Qs 处理
const axios = Axios.create({
  transformRequest: [function (data) {
    return Qs.stringify({
      ...data
    })
  }]
})

export default axios