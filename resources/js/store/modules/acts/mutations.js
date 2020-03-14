const SET_ALL_STREETS = (state, streets) => {
    state.streets = streets
};

const SET_ALL_DISTRICTS = (state, districts) => {
    state.districts = districts
};

const SET_ALL_VILLAGES = (state, villages) => {
    state.villages = villages
};

const SET_ACT = (state, act) => {
    state.act = act
};

export {
    SET_ALL_STREETS,
    SET_ALL_DISTRICTS,
    SET_ALL_VILLAGES
}
