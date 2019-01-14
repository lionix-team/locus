import LoginComponent from "./components/auth/LoginComponent";
import CreateComponent from "./components/gas_station/CreateComponent";
import EditComponent from "./components/gas_station/EditComponent";
import ListComponent from "./components/gas_station/ListComponent";
import VueRouter from 'vue-router'

export const routes = [
    {
        path: '/', component: LoginComponent
    },
    {
        path: '/gas-stations', component: ListComponent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/gas-station/create', component: CreateComponent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/gas-station/edit/:id', component: EditComponent,
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
