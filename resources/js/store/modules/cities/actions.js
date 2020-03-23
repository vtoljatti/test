const getAllCities = ({ commit }) => {
    axios.get('/api/cities/')
        .then(res => commit('CITIES', res.data.cities))
        .catch(err => console.error(err))
};

const getOneCityById = ({}, cityId) => {
    return new Promise((resolve, reject) => {
        axios.get(`/api/cities/${cityId}`)
            .then(res => resolve(res.data.city))
            .catch(err => reject(new Error('Can`t get data')))
    })
}

const addNewCity = ({ dispatch }, city) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/cities/store', city)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllCities')
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

const updateCity = ({ dispatch }, city) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/cities/update', city)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllCities')
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

const getAllStreets = ({ commit }) => {
    axios.get('/api/cities/1/streets')
        .then(res => commit('SET_ALL_STREETS', res.data.streets))
        .catch(err => console.error(err))
};

const getAllVillages = ({ commit }) => {
    axios.get('/api/villages')
        .then(res => commit('SET_ALL_VILLAGES', res.data.villages))
        .catch(err => console.error(err))
};

export {
    getAllCities,
    getOneCityById,
    addNewCity,
    updateCity,

    getAllStreets,
    getAllVillages
}
