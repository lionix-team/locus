import admin from '../../../services/admin';
import {CHANGE_STATUS, SET_REVIEWS} from "./constants";

export const getReviews = ({commit}, {page, keyword, status}) => {
    return new Promise((resolve) => {
        admin().get('reviews?page=' + page + '&keyword=' + keyword + '&status=' + status).then((res) => {
            commit(SET_REVIEWS, res.data.data.reviews);
            resolve();
        });
    });
};

export const changeReviewStatus = ({commit}, {status, review}) => {
    return new Promise((resolve) => {
        admin().put('reviews/' + status + '/' + review).then((res) => {
            // console.log(res.data.data.review);
            commit(CHANGE_STATUS, res.data.data.review);
            resolve();
        });
    });
};
