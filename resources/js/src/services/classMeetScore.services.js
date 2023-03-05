import http from "../httpCommon";

export default {
    getClassMeetScore(id_study_time){
        return http.get(`/class-meet-score/${id_study_time}`);
    }
}
