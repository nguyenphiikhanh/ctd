import http from "../httpCommon";

export default {
    getActivities(){
        return http.get('/activities');
    },
    storeChildActivity(data){
        return http.post('/child-activities',data);
    }
}
