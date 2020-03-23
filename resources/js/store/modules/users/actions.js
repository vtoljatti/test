const getAuthUser = ({ commit }) => {
    axios.get('/api/users/auth')
        .then(res => commit('SET_AUTH_USER', res.data.user))
        .catch(err => {
            console.error(err)
            window.location.reload()
            commit('SET_AUTH_USER', [])
        })
};

const logout = () => {
    axios.post('/logout')
        .then(res => {
            window.location.reload()
        })
        .catch(err => console.log(err))
};

const getAllUsers = ({ commit }) => {
    axios.get('/api/users/')
        .then(res => commit('SET_ALL_USERS', res.data.users))
        .catch(err => console.error(err))
};

const addNewUser = ({ dispatch }, user) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/users/store', user)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllUsers')
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

const getOneUserById = ({}, userId) => {
    return new Promise((resolve, reject) => {
        axios.get(`/api/users/${userId}`)
            .then(res => resolve(res.data.user))
            .catch(err => reject(new Error('Can`t get data')))
    })
}

const updateUser = ({ dispatch }, user) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/users/update', user)
            .then(res => {
                if (res.data.success) {
                    dispatch('getAllUsers')
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
    getAuthUser,
    logout,
    getAllUsers,
    addNewUser,
    getOneUserById,
    updateUser
}
