import http from "../httpCommon";

export default {
    async login(data){
        await http.get('/sanctum/csrf-cookie');
        await http.post('/login',data);
        return this.getInfo();
    },

    async getInfo(){
        return http.get('/api/my-info');
    }
}
