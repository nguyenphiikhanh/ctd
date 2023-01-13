import http from "../httpCommon";

export default {
    getActivities(){
        return http.get('/activities');
    },
    storeChildActivity(data){
        return http.post('/child-activities',data);
    },
    getActivitiesReceive(){
        return http.get('/receive-activities');
    },
    forwardActivities(id){
        return http.get(`/child-activity-forward/${id}`)
    },
    getActivityResponsiable(data){
        return http.get('/child-activity-responsiable',{params: data});
    }
}
