import http from "../httpCommon";

export default {
    getClassList(className = ''){
        return http.get('/classes',className);
    },
}
