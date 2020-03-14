import Vue from 'vue'
import Vuex from 'vuex'
import users from './modules/users'
import cities from './modules/cities'
import acts from './modules/acts'
import others from './modules/others'
import sellers from './modules/sellers'
import notifications from './modules/notifications'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        users,
        cities,
        acts,
        others,
        sellers,
        notifications
    },
    strict: debug
})