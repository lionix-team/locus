import LoginComponent from "./components/auth/LoginComponent";
import CreateComponent from "./components/place/CreateComponent";
import EditComponent from "./components/place/EditComponent";
import ListComponent from "./components/place/ListComponent";

export const routes = [
    {
        path: '/', component: LoginComponent
    },
    {
        path: '/places', component: ListComponent
    },
    {
        path: '/place/create', component: CreateComponent
    },
    {
        path: '/place/edit/:id', component: EditComponent
    },
];
