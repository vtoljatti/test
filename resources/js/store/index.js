import Vue from 'vue'
import Vuex from 'vuex'
import acts from './modules/acts'
import users from './modules/users'
import cities from './modules/cities'
import districts from './modules/districts'
import streets from './modules/streets'
import villages from './modules/villages'
import others from './modules/others'
import sellers from './modules/sellers'
import notifications from './modules/notifications'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        acts,
        users,
        cities,
        districts,
        streets,
        villages,
        others,
        sellers,
        notifications
    },
    strict: debug
})
