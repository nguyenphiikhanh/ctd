import userServices from "../../../services/user.services";

export default {
    getStudentByCanBoLop({commit, dispatch}, data){
        return userServices.getStudentByCanBoLop(data)
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },

    getAssignees({commit, dispatch}){
        return userServices.getAssignees()
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },

    createAssignee({commit, dispatch}, data){
        return userServices.createAssignee(data)
            .then(response => {
                dispatch('alert/alertSuccess',response.data.message, { root: true })
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },

    updateAssignee({commit, dispatch}, data){
        return userServices.updateAssignee(data.id, data)
            .then(response => {
                dispatch('alert/alertSuccess',response.data.message, { root: true })
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },

    getCvhts({commit, dispatch}){
        return userServices.getCvhts()
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },

    createCvht({commit, dispatch}, data){
        return userServices.createCvht(data)
            .then(response => {
                dispatch('alert/alertSuccess',response.data.message, { root: true })
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },

    updateCvht({commit, dispatch}, data){
        return userServices.updateCvht(data.id, data)
            .then(response => {
                dispatch('alert/alertSuccess',response.data.message, { root: true })
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
}
