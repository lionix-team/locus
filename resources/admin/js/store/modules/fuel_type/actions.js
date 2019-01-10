import api from '../../../services/api';
import {SET_FUEL_TYPES} from "./constants";

export const getFuelTypes = (context, payload) => {
    return new Promise((resolve, reject) => {
        api().get('fuel-types').then((res) => {
            context.commit(SET_FUEL_TYPES, res.data.data.fuel_types);
            resolve();
        }).catch(() => {
            reject();
        });
    });
};
