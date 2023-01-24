import http from "../httpCommon";

export default {
    getStudentByClass(class_id){
        return http.get(`/students/class/${class_id}`);
    },

    createStudent(data){
        return http.post('/student', data);
    }
}
