import axios from 'axios'

let data = {
    baseURL: 'http://places.loc/admin/',
};
if (localStorage.getItem('locus_token')) {
    data.headers={};
    data.headers['Authorization'] = 'Bearer ' + localStorage.getItem('locus_token');
}
export default () => {
    return axios.create(data)
}
