import userServices from "../../../services/user.services";

export default {
    getStudentByCanBoLop({commit, dispatch}, data){
        return userServices.getStudentByCanBoLop(data)
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                if (Object.values(error.errors).length > 0) {
                    dispatch("alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
}
