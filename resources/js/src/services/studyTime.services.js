import http from "../httpCommon";


export default {
    getStudyTime(){
        return http.get('/study-times');
    },

    getStudyTerm(){
        return http.get('/study-terms');
    },

    createStudyTime(data){
        return http.post('/study-times', data);
    },

    updateStudyTime(id, data){
        return http.put(`study-times/${id}`, data);
    }
}
