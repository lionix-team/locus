import {mutations} from './mutations'
import * as getters from './getters'
import * as actions from './actions'

export default {
    state: {
        street: {},
        place: {},
        places: {},
        page: 1,
        keyword: '',
    },
    mutations: mutations,
    getters: getters,
    actions: actions
};
