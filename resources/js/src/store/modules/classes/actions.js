import classesServices from "../../../services/classes.services";

export default {
    async getClassList({commit, dispatch}, filterName){
        return classesServices.getClassList(filterName)
            .then(response => {
                return Promise.resolve(response.data);
            })
            .catch((error) => {
                console.log(error);
            })
    }
}
