const setPickedDay = ({ commit }, date) => {
    commit('SET_PICKED_DAY', date)
}

const setFormAct = ({ commit }, act) => {
    commit('SET_FORM_ACT', act)
}

const setListActs = ({ commit }, acts) => {
    commit('SET_LIST_ACTS', acts)
}

const setFilterActs = ({ commit }, filters) => {
    commit('SET_FILTER_ACTS', filters)
}

const getActs = ({}, date) => {
    return new Promise((resolve, reject) => {
        axios.get(`/api/acts/${date}`)
            .then(res => {
                resolve(res.data)
            })
            .catch(err => {
                console.error(err)
                window.location.reload()
            })
    })
}

const getOneActById = ({}, id) => {
    return new Promise((resolve, reject) => {
        axios.get(`/api/acts/edit/${id}`)
            .then(res => {
                resolve(res.data.act)
            })
            .catch(err => {
                console.error(err)
                window.location.reload()
            })
    })
}

const addNewAct = ({ dispatch }, act) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/acts/store', act)
            .then(res => {
                if (res.data.success) {
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

const updateAct = ({ dispatch }, act) => {
    return new Promise((resolve, reject) => {
        axios.post('/api/acts/update', act)
            .then(res => {
                if (res.data.success) {
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
    addNewAct,
    updateAct,
    getActs,
    getOneActById,
    setPickedDay,
    setFormAct,
    setListActs,
    setFilterActs
}
