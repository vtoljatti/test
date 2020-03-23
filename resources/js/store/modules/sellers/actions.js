const getAllSellers = ({ commit }) => {
    axios.get('/api/sellers/')
        .then(res => commit('SET_ALL_SELLERS', res.data.sellers))
        .catch(err => console.error(err))
};

const getAllSellersCity = ({ commit }, cityId) => {
    axios.get(`/api/cities/${cityId}/sellers`)
        .then(res => commit('SET_ALL_SELLERS_CITY', res.data.sellers))
        .catch(err => console.error(err))
}

const getOneSellerById = ({}, sellerId) => {
    return new Promise((resolve, reject) => {
        axios.get(`/api/sellers/${sellerId}`)
            .then(res => resolve(res.data.seller))
            .catch(err => reject(new Error('Can`t get data')))
    })
}

const addNewSeller = ({ dispatch }, seller) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/sellers/store', seller)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllSellers')
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

const updateSeller = ({ dispatch }, seller) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/sellers/update', seller)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllSellers')
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
    getAllSellers,
    getOneSellerById,
    addNewSeller,
    updateSeller,
    getAllSellersCity
}
