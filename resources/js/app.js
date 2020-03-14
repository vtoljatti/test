require('./bootstrap');

import Vue from 'vue';
import App from './components/App.vue';
import router from './router';
import store from './store/index'

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h =>h(App)
});

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
