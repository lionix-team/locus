import {SET_STREET,SET_PLACE,SET_PLACES} from "./constants";

export const mutations = {
    [SET_STREET](state, payload) {
        state.street = payload;
    },
    [SET_PLACE](state, payload) {
        state.place = payload;
    },
    [SET_PLACES](state, payload) {
        state.places = payload;
    }
};
