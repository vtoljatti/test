const getAllRoles = ({ commit }) => {
    axios.get('/api/roles/')
        .then(res => commit('SET_ALL_ROLES', res.data.roles))
        .catch(err => console.error(err))
};

export {
    getAllRoles
}
