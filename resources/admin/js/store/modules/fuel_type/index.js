import {mutations} from './mutations'
import * as getters from './getters'
import * as actions from './actions'

export default {
    state: {
        fuel_types: {},
    },
    mutations: mutations,
    getters: getters,
    actions: actions
};
