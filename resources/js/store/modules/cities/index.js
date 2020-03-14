import * as actions from './actions'
import * as mutations from './mutations'
import * as getters from './getters'

const state = {
    cities: [],
    streets: [],
    districts: [],
    villages: []
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
