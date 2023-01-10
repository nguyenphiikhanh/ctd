import activitiesServices from "../../../services/activities.services";

export default {
    async getActivities({commit, dispatch}){
        return activitiesServices.getActivities()
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                console.log(error);
            })
    }
}
