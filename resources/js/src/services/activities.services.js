import http from "../httpCommon";

export default {
    getActivities(){
        return http.get('/activities');
    }
}
