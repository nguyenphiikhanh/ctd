import http from "../httpCommon";

export default {
    getListTcSelf(){
        return http.get('/tieu-chi/self');;
    },
}
