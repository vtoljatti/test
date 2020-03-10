import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        apiUrl: 'http://localhost:8000/api',
        serverPatch: 'http://localhost:8000',
    },
    mutations: {},
    actions: {}
})
