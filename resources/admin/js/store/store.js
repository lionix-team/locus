import Vue from 'vue';
import Vuex from 'vuex';
import authModule from './modules/auth/index'
import placeModule from './modules/gas_station/index'
import fuelTypeModule from './modules/fuel_type/index'
import reviewsModule from './modules/review/index'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth: authModule,
        place: placeModule,
        fuelTypes: fuelTypeModule,
        reviews: reviewsModule,
    }
});
