import {CHANGE_STATUS, SET_REVIEWS} from "./constants";

export const mutations = {
    [SET_REVIEWS](state, payload) {
        state.reviews = payload;
    },
    [CHANGE_STATUS](state, payload) {
        state.reviews.data.splice(state.reviews.data.findIndex(element => element.id === payload.id), 1, payload);
    },
};
