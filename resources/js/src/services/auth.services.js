import http from "../httpCommon";

export default {
    login(data){
       return http.post('/login',data);
    },
}

