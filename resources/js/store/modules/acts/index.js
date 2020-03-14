import * as actions from './actions'
import * as mutations from './mutations'
import * as getters from './getters'

const state = {
    streets: [],
    districts: [],
    villages: [],
    act: [{'qwe': 2}]
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
