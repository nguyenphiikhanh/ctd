import axios from 'axios';

const instance = axios.create({
    baseURL: process.env.MIX_BASE_URL_API,
    withCredentials: true,
});

instance.interceptors.response.use(
    (response)=>{
    return response;
},
    async (error) => {
    if (error) {
        const originalRequest = error.config;
        if (
            (error.response.status === 401 || error.response.status === 419)
        ) {
            location.href = '/logout';
        }
        return Promise.reject(error);
    }
});


export default instance;
