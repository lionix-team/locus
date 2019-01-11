import AdminComponent from './components/AdminComponent'
import {router} from './routes'
import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store/store'
import {GOOGLE_MAP_KEY} from "./services/map";
import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueRouter);
Vue.use(VueGoogleMaps, {
    load: {
        key: GOOGLE_MAP_KEY,
        libraries: 'places'
    }
});

new Vue({
    el: '#admin',
    router,
    store,
    render: h => h(AdminComponent)
});
