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
    }
}
