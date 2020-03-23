const getAllRoles = ({ commit }) => {
    axios.get('/api/roles/')
        .then(res => commit('SET_ALL_ROLES', res.data.roles))
        .catch(err => console.error(err))
};

const setDataModal = ({ commit }, data) => {
    commit('SET_DATA_MODAL', data)
}

export {
    getAllRoles,
    setDataModal
}
