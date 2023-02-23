import http from "../httpCommon";

export default {
    nvspCreatePoint(){
        return http.post('/points/nvsp');
    },
}
