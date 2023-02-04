import http from "../httpCommon";

export default {
    getActivities(){
        return http.get('/activities');
    },
    storeChildActivity(data){
        return http.post('/child-activities',data,{
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        });
    },
    getChildActivities(){
        return http.get('/child-activities');
    },
    getActivitiesReceive(){
        return http.get('/receive-activities');
    },
    forwardActivities(data){
        return http.post(`/child-activity-forward/${data.id}`, data)
    },
    getActivityResponsiable(data){
        return http.get('/child-activity-responsiable',{params: data});
    },
    getActivitiesForCheckList(){
        return http.get('/checkList-activities');
    },
    getUserForCheckList(activity_details_id, child_activity_type){
        let data = {
            child_activity_type: child_activity_type,
        }
        return http.get(`/checkList-activities-users/${activity_details_id}`,{params: data});
    },
    updateUserCheckListStatus(data){
        return http.put(`/checkList-for-user/${data.user_id}/${data.activity_details_id}`, data);
    },

    uploadProof(data){
        return http.post('/proof/store',data,{
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        });
    },

    getProoves(data){
        return http.get('/prooves',{params: data});
    },

    getUserActivities(id){
        return http.get(`/child-activity/${id}/users`);
    },

    updateUserActivityAward(id, data){
        return http.put(`/user-activity/${id}/update`, data);
    }
}
