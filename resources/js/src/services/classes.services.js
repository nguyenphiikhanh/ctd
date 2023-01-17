import http from "../httpCommon";

export default {
    getClassList(params = null){
        return http.get('/class-list',{params: params});
    },

    getClasses(params = null){
        return http.get('/classes',{params: params});
    },
    getClassTypes(){
        return http.get('/class-types');
    },
    createClass(data){
        return http.post('/classes', data);
    }

}
