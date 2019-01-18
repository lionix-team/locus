import LoginComponent from "./components/auth/LoginComponent";
import CreateGasStationComponent from "./components/gas_station/CreateComponent";
import EditGasStationComponent from "./components/gas_station/EditComponent";
import GasStationsListComponent from "./components/gas_station/ListComponent";
import ReviewsListComponent from "./components/review/ListComponent";
import VueRouter from 'vue-router'

export const routes = [
    {
        path: '/', component: LoginComponent
    },
    {
        path: '/gas-stations', component: GasStationsListComponent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/gas-station/create', component: CreateGasStationComponent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/gas-station/edit/:id', component: EditGasStationComponent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/reviews', component: ReviewsListComponent,
        meta: {
            requiresAuth: true
        }
    },
];
export const router = new VueRouter({
    routes
});
router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    if (!localStorage.getItem('locus_token') && requiresAuth) next('/');
    else next();
});
