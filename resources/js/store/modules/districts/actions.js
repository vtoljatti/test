const getAllDistricts = ({ commit }) => {
    axios.get('/api/districts')
        .then(res => commit('SET_ALL_DISTRICTS', res.data.districts))
        .catch(err => console.error(err))
};

const getAllDistrictsCity = ({ commit }, cityId) => {
    axios.get(`/api/cities/${cityId}/districts`)
        .then(res => commit('SET_ALL_DISTRICTS_CITY', res.data.districts))
        .catch(err => console.error(err))
}

const getOneDistrictById = ({}, districtId) => {
    return new Promise((resolve, reject) => {
        axios.get(`/api/districts/${districtId}`)
            .then(res => resolve(res.data.district))
            .catch(err => reject(new Error('Can`t get data')))
    })
}

const addNewDistrict = ({ dispatch }, district) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/districts/store', district)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllDistricts')
                    resolve(res.data.message)
                } else {
                    const errorResponse = err.response.data.errors ?? false
                    let errors = []

                    for (const key in errorResponse) {
                        errorResponse[key].forEach(reason => errors.push(reason))
                    }

                    reject(errors)
                }
            })
            .catch(err => {
                let errors = []
                let message

                if (err.response.data.errors) {
                    const errorResponse = err.response.data.errors

                    for (const key in errorResponse) {
                        errorResponse[key].forEach(reason => errors.push(reason))
                    }
                    reject(errors)

                } else {
                    message = err.response.data.message ?? false
                    reject(message)
                }

            })
    })
}

const updateDistrict = ({ dispatch }, district) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/districts/update', district)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllDistricts')
                    resolve(res.data.message)
                } else {
                    const errorResponse = err.response.data.errors ?? false
                    let errors = []

                    for (const key in errorResponse) {
                        errorResponse[key].forEach(reason => errors.push(reason))
                    }

                    reject(errors)
                }
            })
            .catch(err => {
                let errors = []
                let message

                if (err.response.data.errors) {
                    const errorResponse = err.response.data.errors

                    for (const key in errorResponse) {
                        errorResponse[key].forEach(reason => errors.push(reason))
                    }
                    reject(errors)

                } else {
                    message = err.response.data.message ?? false
                    reject(message)
                }

            })
    })
}

export {
    getAllDistricts,
    getOneDistrictById,
    addNewDistrict,
    updateDistrict,
    getAllDistrictsCity
}
