import axios from 'axios';
import admin from '../../../services/admin';
import {SET_STREET} from "./constants";
import {GOOGLE_API_BASE_URL, GOOGLE_MAP_KEY} from "../../../services/map";

export const getStreet = (context, {lat, lng}) => {
    return new Promise(() => {
        axios.post(GOOGLE_API_BASE_URL + 'maps/api/geocode/json?latlng=' + lat + ',' + lng + '&sensor=true&key=' + GOOGLE_MAP_KEY).then((res) => {
            let address="";
            if(res.data.results[0]) {
                address=res.data.results[0].formatted_address;
            }
            context.commit(SET_STREET, address);
        });
    });
};

export const createPlace = (context, {form}) => {
    return new Promise((resolve, reject) => {
        admin().post('places/', form).then((res) => {
            // context.commit(SET_STREET, res.data.results[0].formatted_address);
            console.log(res);
            resolve();
        }).catch((errors) => {
            reject(errors.response.data.errors);
        });
    });
};
