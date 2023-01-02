import http from "../httpCommon";

export default {
    getActivityList(){
        return http.get('/activities');
    },
    createChildActivity(data){
        return http.post('/activities',data);
    }
}
