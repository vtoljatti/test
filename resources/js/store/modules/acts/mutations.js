const SET_PICKED_DAY = (state, pickedDay) => {
    state.pickedDay = pickedDay
};

const SET_FORM_ACT = (state, formAct) => {
    state.formAct = formAct
};

const SET_LIST_ACTS = (state, listActs) => {
    state.listActs = listActs
};

const SET_FILTER_ACTS = (state, filterActs) => {
    state.filterActs = filterActs
};

export {
    SET_PICKED_DAY,
    SET_FORM_ACT,
    SET_LIST_ACTS,
    SET_FILTER_ACTS
}
