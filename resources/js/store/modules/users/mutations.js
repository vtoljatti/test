const SET_ALL_USERS = (state, users) => {
    state.users = users
};

const ADD_NEW_USER = (state, user) => {
    state.users.push(user)
}

export {
    SET_ALL_USERS,
    ADD_NEW_USER
}
