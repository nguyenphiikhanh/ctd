import http from "../httpCommon";

export default {
    getTermList(params = null){
        return http.get('/terms',{params: params});
    },
    createTerm(data){
        return http.post('/terms', data);
    }
}
