import http from "../httpCommon";

export default {
    getPersonalScore(){
        return http.get('/personal-score');
    }
}
