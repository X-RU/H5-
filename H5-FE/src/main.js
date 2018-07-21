// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import router from './router'

import axios from 'axios'
import VueAxios from 'vue-axios'

import App from './App'
import Header from './Header'
import Footer from './Footer'

import defines from './config'

Vue.use(VueAxios, axios)

Vue.config.productionTip = false

Vue.prototype.defines = defines
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})


new Vue({
  el: '#header',
  router,
  components: { Header },
  template: '<Header/>'
})

new Vue({
  el: '#footer',
  router,
  components: { Footer },
  template: '<Footer/>'
})
