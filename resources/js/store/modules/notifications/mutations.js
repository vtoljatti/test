const APPEND_NOTIFICATION = (state, notification) => {
    state.notifications = [
        notification,
        ...state.notifications
    ]
}

const HIDE_NOTIFICATION = (state, id) => {
    const itemIdx = state.notifications.findIndex(n => n.id === id)
    const item = state.notifications[itemIdx]

    state.notifications = [
        ...state.notifications.slice(0, itemIdx),
        { ...item, isVisible: false },
        ...state.notifications.slice(itemIdx + 1)
    ]
}

const REMOVE_NOTIFICATION = (state, id) => {
    state.notifications = state.notifications.filter(n => n.id !== id)
}

export {
    APPEND_NOTIFICATION,
    HIDE_NOTIFICATION,
    REMOVE_NOTIFICATION
}
