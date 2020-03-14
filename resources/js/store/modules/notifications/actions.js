const showNotify = ({ commit }, { message, variant }) => {
    const notificationId = Date.now()
    const notification = { id: notificationId, message, variant, isVisible: true }

    commit('APPEND_NOTIFICATION', notification)
    setTimeout(() => commit('HIDE_NOTIFICATION', notificationId), 4000)
    setTimeout(() => commit('REMOVE_NOTIFICATION', notificationId), 5000)
}

export {
    showNotify
}
