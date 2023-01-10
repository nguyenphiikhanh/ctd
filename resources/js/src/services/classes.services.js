import http from "../httpCommon";

export default {
    getClassList(params = null){
        return http.get('/classes',{params: params});
    },
}
