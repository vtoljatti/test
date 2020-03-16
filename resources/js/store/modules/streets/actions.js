// Получаем все улицы
const getAllStreets = ({ commit }) => {
    console.log('getAllStreets')
    axios.get('/api/streets')
        .then(res => commit('SET_ALL_STREETS', res.data.streets))
        .catch(err => console.error(err))
};

// Получаем все улицы с конкретного города
const getAllStreetsCity = ({ commit }, cityId) => {
    axios.get(`/api/cities/${cityId}/streets`)
        .then(res => commit('SET_ALL_STREETS_CITY', res.data.streets))
        .catch(err => console.error(err))
}

// Получаем улицу по id
const getOneStreetById = ({}, streetId) => {
    return new Promise((resolve, reject) => {
        axios.get(`/api/streets/${streetId}`)
            .then(res => resolve(res.data.street))
            .catch(err => reject(new Error('Can`t get data')))
    })
}

// Добавляем улицу
const addNewStreet = ({ dispatch }, street) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/streets/store', street)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllStreets')
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

// Редактируем улицу
const updateStreet = ({ dispatch }, street) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/streets/update', street)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllStreets')
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
    getAllStreets,
    getOneStreetById,
    addNewStreet,
    updateStreet,
    getAllStreetsCity
}
