import termServices from "../../../services/term.services";

export default {
    getFacultyList({commit, dispatch}, params){
        return termServices.getTermList(params)
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (error.errors && Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    createFaculty({commit, dispatch}, data){
        return termServices.createTerm(data)
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
