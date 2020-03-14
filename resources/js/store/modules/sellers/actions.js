const getAllSellers = ({ commit }) => {
    axios.get('/api/sellers/')
        .then(res => commit('SET_ALL_SELLERS', res.data.sellers))
        .catch(err => console.error(err))
};

export {
    getAllSellers
}
