import classesServices from "../../../services/classes.services";

export default {
    async getClassList({commit, dispatch}, params){
        return classesServices.getClassList(params)
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                console.log(error);
            })
    }
}
