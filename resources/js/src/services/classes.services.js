import http from "../httpCommon";

export default {
    getClassList(params = null){
        console.log('khanh log',params);
        return http.get('/classes',{params: params});
    },
}
