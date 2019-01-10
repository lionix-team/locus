import {SET_STREET} from "./constants";

export const mutations = {
    [SET_STREET](state, payload) {
        state.street = payload;
    }
};
