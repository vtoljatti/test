const getAllVillages = ({ commit }) => {
    axios.get('/api/villages')
        .then(res => commit('SET_ALL_VILLAGES', res.data.villages))
        .catch(err => console.error(err))
};

const getAllVillagesCity = ({ commit }, cityId) => {
    axios.get(`/api/cities/${cityId}/villages`)
        .then(res => commit('SET_ALL_VILLAGES_CITY', res.data.villages))
        .catch(err => console.error(err))
}

const getOneVillageById = ({}, villageId) => {
    return new Promise((resolve, reject) => {
        axios.get(`/api/villages/${villageId}`)
            .then(res => resolve(res.data.village))
            .catch(err => console.error(err))
    })
}

const addNewVillage = ({ dispatch }, village) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/villages/store', village)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllVillages')
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

const updateVillage = ({ dispatch }, village) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/villages/update', village)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllVillages')
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
    getAllVillages,
    getOneVillageById,
    addNewVillage,
    updateVillage,
    getAllVillagesCity
}
