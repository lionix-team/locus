import {mutations} from './mutations'
import * as getters from './getters'
import * as actions from './actions'

export default {
    state: {
        reviews: {}
    },
    mutations: mutations,
    getters: getters,
    actions: actions
};
