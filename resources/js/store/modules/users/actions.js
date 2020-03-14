const getAllUsers = ({ commit }) => {
    axios.get('/api/users/')
        .then(res => commit('SET_ALL_USERS', res.data.users))
        .catch(err => console.error(err))
};

const addNewUser = ({ dispatch }, user) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/users/store', user)
            .then(res => {
                dispatch('getAllUsers')
                resolve()
            })
            .catch(err => reject(new Error('Can`t save user')))
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
    getAllUsers,
    addNewUser,
    getOneUserById,
    updateUser
}
