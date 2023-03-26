import http from "../httpCommon";

export default {
    getPersonalScore(){
        return http.get('/personal-score');
    },

    sendProof(data){
        return http.post('/personal-score/proof', data,{
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        });
    }
}
