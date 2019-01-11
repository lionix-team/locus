import axios from 'axios';
import admin from '../../../services/admin';
import api from '../../../services/api';
import {SET_STREET, SET_PLACE, SET_PLACES, DELETE_PLACE, SET_PAGE,SET_KEYWORD} from "./constants";
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

export const getPlaces = ({commit,state,dispatch}, page) => {
    return new Promise((resolve) => {
        api().get('places?page=' + page + '&keyword=' + state.keyword).then((res) => {
            dispatch('changePage',page);
            commit(SET_PLACES, res.data.data.places);
            resolve();
        });
    });
};

export const changePage = (context, page) => {
    return new Promise((resolve) => {
        context.commit(SET_PAGE, page);
        resolve();
    });
};

export const setKeyword = (context, {keyword}) => {
    return new Promise((resolve) => {
        context.commit(SET_KEYWORD, keyword);
        resolve();
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

export const deletePlace = (context, {id}) => {
    return new Promise((resolve, reject) => {
        admin().delete('places/' + id).then(() => {
            context.commit(DELETE_PLACE, {id: id});
            resolve();
        }).catch(() => {
            reject();
        });
    });
};
