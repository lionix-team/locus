import LoginComponent from "./components/auth/LoginComponent";
import CreateComponent from "./components/place/CreateComponent";
import EditComponent from "./components/place/EditComponent";
import ListComponent from "./components/place/ListComponent";
import VueRouter from 'vue-router'

export const routes = [
    {
        path: '/', component: LoginComponent
    },
    {
        path: '/places', component: ListComponent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/place/create', component: CreateComponent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/place/edit/:id', component: EditComponent,
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
