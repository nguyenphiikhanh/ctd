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
    forwardActivities(data){
        console.log(data);
        return http.post(`/child-activity-forward/${data.id}`, data)
    },
    getActivityResponsiable(data){
        return http.get('/child-activity-responsiable',{params: data});
    }
}
