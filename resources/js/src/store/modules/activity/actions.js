import activitiesServices from "../../../services/activities.services";

export default {
    getActivities({commit, dispatch}){
        return activitiesServices.getActivities()
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                console.log(error);
            })
    },
    storeChildActivity({commit, dispatch}, data){
        return activitiesServices.storeChildActivity(data)
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                console.log(error);
            })
    },
    getActivitiesReceive({commit, dispatch}){
        return activitiesServices.getActivitiesReceive()
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                console.log(error);
            })
    },
    forwardActivities({commit, dispatch}, id){
        return activitiesServices.forwardActivities(id)
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                console.log(error);
            })
    }
}
