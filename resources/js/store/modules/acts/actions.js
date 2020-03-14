const getAllStreets = ({ commit }) => {
    axios.get('/api/cities/1/streets')
        .then(res => commit('SET_ALL_STREETS', res.data.streets))
        .catch(err => console.error(err))
};

const getAllDistricts = ({ commit }) => {
    axios.get('/api/cities/1/districts')
        .then(res => commit('SET_ALL_DISTRICTS', res.data.districts))
        .catch(err => console.error(err))
};

const getAllVillages = ({ commit }) => {
    axios.get('/api/villages')
        .then(res => commit('SET_ALL_VILLAGES', res.data.villages))
        .catch(err => console.error(err))
};

export {
    getAllStreets,
    getAllDistricts,
    getAllVillages,
}
