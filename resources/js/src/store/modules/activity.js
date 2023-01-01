import activitiyServices from "../../services/activitiy.services";

export default {
    namespaced: true,
    state,
    actions,
    mutations
}

const state = {

}

const actions = {
    async getActivityList({commit, dispatch}){
        return activitiyServices.getActivityList()
            .then(response => {
                return Promise.resolve(response);
            })
            .catch((error) => {
                console.log(error);
            })
    }
}

const mutations = {

}
