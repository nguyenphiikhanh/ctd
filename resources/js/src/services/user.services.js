import http from "../httpCommon";

export default {
    getStudentByCanBoLop(params){
        return http.get(`/student/class`,{params: params});
    },
}
