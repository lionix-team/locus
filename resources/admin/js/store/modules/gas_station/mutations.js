import {SET_STREET, SET_PLACE, SET_PLACES, DELETE_PLACE, SET_PAGE} from "./constants";

export const mutations = {
    [SET_STREET](state, payload) {
        state.street = payload;
    },
    [SET_PLACE](state, payload) {
        state.place = payload;
    },
    [SET_PLACES](state, payload) {
        state.places = payload;
    },
    [SET_PAGE](state, payload) {
        state.page = payload;
    },
    [DELETE_PLACE](state, payload) {
        state.places.data.splice(state.places.data.findIndex(element => element.id === payload.id), 1);
    }
};
