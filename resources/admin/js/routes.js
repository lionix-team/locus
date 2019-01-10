import LoginComponent from "./components/auth/LoginComponent";
import CreateComponent from "./components/place/CreateComponent";

export const routes = [
    {
        path: '/', component: LoginComponent
    },
    {
        path: '/place/create', component: CreateComponent
    },
];
