import axios from 'axios';
import store from "./store";

let authToken = localStorage.getItem('token');
axios.defaults.headers.common['Authorization'] = 'Bearer ' + authToken;

const instance = axios.create({
    baseURL: process.env.MIX_BASE_URL_API,
    withCredentials: true,
});

instance.interceptors.response.use(
    (response)=>{
    return Promise.resolve(response);
},
    async (error) => {
    if (error) {
        const originalRequest = error.config;
        if (
            (error.response.status === 401 || error.response.status === 419)
        ) {
            store.dispatch('auth/logout');
        }
        return Promise.reject(error.response.data);
    }
});


export default instance;
