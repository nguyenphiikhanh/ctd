import axios from 'axios'

const instance = axios.create({
    baseURL: process.env.API_BASE_URL,
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
            (error.response.status === 401 || error.response.status === 419) &&
            !originalRequest._retry
        ) {
            originalRequest._retry = true;
            if (error.config.url != '/logout'){
                await store.dispatch('auth/logout');
                return router.push({name: 'Login'});
            }
        }
        return Promise.reject(error);
    }
});


export default instance;
