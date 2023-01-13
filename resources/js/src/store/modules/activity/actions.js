import activitiesServices from "../../../services/activities.services";

export default {
    getActivities({commit, dispatch}){
        return activitiesServices.getActivities()
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    storeChildActivity({commit, dispatch}, data){
        return activitiesServices.storeChildActivity(data)
            .then(response => {
                dispatch('alertSuccess', typeof response.message == 'object' ? response.message[0] : response.message, { root: true })
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    getActivitiesReceive({commit, dispatch}){
        return activitiesServices.getActivitiesReceive()
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    forwardActivities({commit, dispatch}, id){
        return activitiesServices.forwardActivities(id)
            .then(response => {
                dispatch('alertSuccess', typeof response.message == 'object' ? response.message[0] : response.message, { root: true })
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    getActivityResponsiable({commit, dispatch},data){
        return activitiesServices.getActivityResponsiable(data)
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    }
}
