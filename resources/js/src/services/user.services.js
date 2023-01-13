import http from "../httpCommon";

export default {
    getUserByCanBoLop(readonly = null){
        return http.get(`/get-user-classes-by-cbl`,{params: {readonly: readonly}});
    },
}
