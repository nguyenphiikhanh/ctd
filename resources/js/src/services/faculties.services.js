import http from "../httpCommon";

export default {
    getFacultyList(params = null){
        return http.get('/terms',{params: params});
    },
    createFaculty(data){
        return http.post('/terms', data);
    }
}
