import http from "../httpCommon";

export default {
    nvspCreatePoint(){
        return http.post('/points/nvsp');
    },

    getNvspPointByStudyYear(id_study_year = null, id_class){
        const data = {
            id_class: id_class,
            id_study_year: id_study_year
        }
        return http.get(`points/nvsp`, {params : data});
    },

    storeStudypoints(data){
        return http.post('/study-point', data,{
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        });
    },

    getStudyPoints(data){
        return http.get('/study-point', {params: data});
    },

    getScoreByClass(id_class, data){
        return http.get(`/last-score/${id_class}`, {params: data});
    },

    updateLastScore(data){
        return http.put('/last-score', data);
    },

    getStudentLastScore(id_student, id_study_time){
        return http.get(`/personal-score/student/${id_student}/time/${id_study_time}`);
    },

    getReportData(id_student, id_study_time){
        return http.get(`/last-score/report/${id_student}/time/${id_study_time}`);
    },
}
