import http from "../httpCommon";


export default {
    getStudyYear(){
        return http.get('/years');
    },

    createStudyYear(data){
        return http.post('/years', data);
    },

    updateStudyYear(id, data){
        return http.put(`years/${id}`, data);
    }
}
