import http from "../httpCommon";

export default {
    getActivityList(){
        return http.get('/activities');
    }
}
