import http from "../httpCommon";

export default {
    async login(data){
        await http.get('/sanctum/csrf-cookie');
        await http.post('/login',data).then((response => {
            return this.getInfo();
        }))
    },

    async getInfo(){
        return http.get('/user');
    }
}
