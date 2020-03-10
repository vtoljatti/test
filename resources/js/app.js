require('./bootstrap');

import Vue from 'vue';
import App from './App.vue';
import router from './router';

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

const app = new Vue({
    el: '#app',
    router,
    render: h =>h(App)
});
