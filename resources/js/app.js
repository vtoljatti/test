require('./bootstrap');

window.Vue = require('vue');

import App from './components/app'

const app = new Vue(App).$mount('#app');

