import http from "../httpCommon";

export default {
    getActivityList(){
        return http.get('/activities');
    },
    createChildActivity(data){
        return http.post('/child-activities',data);
    },
    getClassByUser_CbKhoa(){
        return http.get('/get-class-cb-khoa');
    }
}
