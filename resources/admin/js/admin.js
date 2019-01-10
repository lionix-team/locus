import AdminComponent from './components/AdminComponent'
import {routes} from './routes'
import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store/store'

Vue.use(VueRouter);
const router = new VueRouter({
    routes
});
new Vue({
    el: '#admin',
    router,
    store,
    render: h => h(AdminComponent)
});
