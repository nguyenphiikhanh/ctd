import activitiesServices from "../../../services/activities.services";

export default {
    getActivities({commit, dispatch}){
        return activitiesServices.getActivities()
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (error.errors && Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    storeChildActivity({commit, dispatch}, data){
        return activitiesServices.storeChildActivity(data)
            .then(response => {
                dispatch('alert/alertSuccess',response.data.message, { root: true })
            })
            .catch((error) => {
                if (error.errors && Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    getActivitiesReceive({commit, dispatch}){
        return activitiesServices.getActivitiesReceive()
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (error.errors && Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    forwardActivities({commit, dispatch}, id){
        return activitiesServices.forwardActivities(id)
            .then(response => {
                dispatch('alert/alertSuccess',response.data.message, { root: true })
            })
            .catch((error) => {
                if (error.errors && Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    getActivityResponsiable({commit, dispatch},data){
        return activitiesServices.getActivityResponsiable(data)
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (error.errors && Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    }
}
