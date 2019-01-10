import {SET_FUEL_TYPES} from "./constants";

export const mutations = {
    [SET_FUEL_TYPES](state, payload) {
        state.fuel_types = payload;
    }
};
