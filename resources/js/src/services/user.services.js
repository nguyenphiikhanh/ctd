import http from "../httpCommon";

export default {
    getStudentByCanBoLop(params){
        return http.get(`/student/class`,{params: params});
    },

    getAssignees(){
        return http.get('user/assign-act');
    },
    createAssignee(data){
        return http.post('user/assign-act', data);
    },
    updateAssignee(id, data){
        return http.put(`/user/assign-act/${id}`, data);
    },

    getCvhts(){
        return http.get('user/cvht');
    },
    createCvht(data){
        return http.post('user/cvht', data);
    },
    updateCvht(id, data){
        return http.put(`/user/cvht/${id}`, data);
    },
}
