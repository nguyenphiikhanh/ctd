import http from "../httpCommon";

export default {
    getFacultyList(params = null){
        return http.get('/faculties',{params: params});
    },
    createFaculty(data){
        return http.post('/faculties', data);
    }
}
