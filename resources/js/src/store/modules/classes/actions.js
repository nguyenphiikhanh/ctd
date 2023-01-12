import classesServices from "../../../services/classes.services";

export default {
    getClassList({commit, dispatch}, params){
        return classesServices.getClassList(params)
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
