import Vue from 'vue'
import App from '@/App.vue'
import router from '@/router'
import 'element-ui/lib/theme-chalk/index.css';
import '@/assets/style.less';
import ElementUI from 'element-ui'
import axios from '@/assets/ajax'
import store from '@/store'

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

Vue.use(ElementUI)
Vue.prototype.$ajax = axios
Vue.config.productionTip = false