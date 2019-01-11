import axios from 'axios';
import admin from '../../../services/admin';
import api from '../../../services/api';
import {SET_STREET, SET_PLACE,SET_PLACES} from "./constants";
import {GOOGLE_API_BASE_URL, GOOGLE_MAP_KEY} from "../../../services/map";

export const getStreet = (context, {lat, lng}) => {
    return new Promise(() => {
        axios.post(GOOGLE_API_BASE_URL + 'maps/api/geocode/json?latlng=' + lat + ',' + lng + '&sensor=true&key=' + GOOGLE_MAP_KEY).then((res) => {
            let address = "";
            if (res.data.results[0]) {
                address = res.data.results[0].formatted_address;
            }
            context.commit(SET_STREET, address);
        });
    });
};

export const createPlace = (context, {form}) => {
    return new Promise((resolve, reject) => {
        admin().post('places/', form).then((res) => {
            resolve();
        }).catch((errors) => {
            reject(errors.response.data.errors);
        });
    });
};

export const getPlaces = (context, page) => {
    return new Promise((resolve) => {
        api().get('places?page='+page).then((res) => {
            context.commit(SET_PLACES, res.data.data.places);
            resolve();
        });
    });
};

export const getPlace = (context, {id}) => {
    return new Promise((resolve) => {
        api().get('places/' + id).then((res) => {
            context.commit(SET_PLACE, res.data.data.place);
            resolve();
        });
    });
};

export const editPlace = (context, {form, id}) => {
    return new Promise((resolve, reject) => {
        admin().put('places/' + id, form).then((res) => {
            context.commit(SET_PLACE, res.data.data.place);
            resolve();
        }).catch((errors) => {
            reject(errors.response.data.errors);
        });
    });
};
