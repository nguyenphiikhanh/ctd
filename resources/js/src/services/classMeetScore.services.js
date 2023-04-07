import http from "../httpCommon";

export default {
    getClassMeetScore(id_study_time){
        return http.get(`/class-meet-score/${id_study_time}`);
    },

    updatePersonClassMeetScore(id_study_time, id_tieu_chi, data){
        return http.put(`/class-meet-score/${id_study_time}/student-person-tc/${id_tieu_chi}`, data)
    },

    getMeetScoreByClass(id_class, data){
        return http.get(`/class-meet-score/class/${id_class}`, {params: data});
    },
    getMeetScoreStudentCheckList(id_class){
        return http.get(`/class-meet-score/check-list/${id_class}`);
    }
}
