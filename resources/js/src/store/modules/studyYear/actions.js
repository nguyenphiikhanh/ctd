import studyYearServices from "../../../services/studyYear.services";

export default {
    getStudyYear({commit, dispatch}){
        return studyYearServices.getStudyYear()
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (error.errors && Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    createStudyYear({commit, dispatch}, data){
        return studyYearServices.createStudyYear(data)
            .then(response => {
                dispatch('alert/alertSuccess',response.data.message, { root: true })
            })
            .catch((error) => {
                if (error.errors && Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },

    updateStudyYear({commit, dispatch}, data){
        return studyYearServices.updateStudyYear(data.id, data)
            .then(response => {
                dispatch('alert/alertSuccess',response.data.message, { root: true })
            })
            .catch((error) => {
                if (error.errors && Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
}
