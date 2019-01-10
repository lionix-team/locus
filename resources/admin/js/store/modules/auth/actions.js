import api from '../../../services/api';
import {SET_USER} from "./constants";

export const login = (context, {form}) => {
    return new Promise((resolve, reject) => {
        api().post('auth/login', form).then((response) => {
            context.commit(SET_USER, response.data.data.user);
            resolve(response.data.data.token_info);
        }).catch((error) => {
            reject(error.response.data.errors['message']);
        });
    });
};
