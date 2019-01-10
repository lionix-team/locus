import {SET_USER, UNSET_USER} from "./constants";

export const mutations = {
    [SET_USER](state, payload) {
        state.user = payload;
    },
    [UNSET_USER](state) {
        state.user = null;
    }
};
