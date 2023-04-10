import authServices from "../../../services/auth.services";

export default {
    login({commit, dispatch}, data){
        const token = localStorage.getItem('token');
        if(token){
            location.href = '/trang-chu';
        }
        return authServices.login(data)
            .then(response => {
                const data = response.data.data;
                commit('SET_USER_AUTH',data.user);
                commit('SET_TOKEN',data.access_token);
                localStorage.setItem('token', data.access_token);
                location.href = '/trang-chu';
            })
            .catch((error) => {
                if (error.errors && Object.values(error.errors).length > 0) {
                    dispatch("alert/alertError", Object.values(error.errors)[0][0], { root: true });
                } else dispatch("alert/alertError", typeof error.message == 'object' ? error.message[0] : error.message, { root: true });
            })
    },
    logout({commit, dispatch}){
        commit('SET_TOKEN',null);
        commit('SET_USER_AUTH',null);
        localStorage.clear();
        location.href = '/dang-nhap';
    }
}
