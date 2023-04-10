import http from "../httpCommon";

export default {
    getStudentByClass(class_id){
        return http.get(`/students/class/${class_id}`);
    },

    createStudent(data){
        return http.post('/student', data);
    },

    updateStudent(id, data){
        return http.put(`/student/${id}`, data);
    },

    changeCbSetting(data){
        return http.put('/student/cbSetting', data);
    },

    getStudentByFaculty(id_faculty, params = null){
        return http.get(`/student/faculty/${id_faculty}`, {params: params});
    },

    getStudentInfo(id){
        return http.get(`/student/${id}`);
    }
}
