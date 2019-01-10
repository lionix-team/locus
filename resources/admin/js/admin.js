import AdminComponent from './components/AdminComponent'
import {routes} from './routes'
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
const router = new VueRouter({
    routes
});
new Vue({
    el: '#admin',
    router,
    store,
    render: h => h(AdminComponent)
});
