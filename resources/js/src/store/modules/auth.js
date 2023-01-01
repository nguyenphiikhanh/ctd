import http from "../../httpCommon";
import router from '../../router';

export default {
    namespaced: true,
    state:{
        authenticated:false,
        user:{}
    },
    getters:{
        authenticated(state){
            return state.authenticated
        },
        user(state){
            return state.user
        }
    },
    mutations:{
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_USER (state, value) {
            state.user = value
        }
    },
    actions:{
        login({commit,dispatch}){
            return http.get('/api/my-info').then((data)=>{
                console.log('debug data');
                commit('SET_USER',data)
                commit('SET_AUTHENTICATED',true)
                router.push({name:'home'})
            }).catch(()=>{
                commit('SET_USER',{})
                commit('SET_AUTHENTICATED',false)
            })
        },
        logout({commit,dispatch}){
            commit('SET_USER',{})
            commit('SET_AUTHENTICATED',false)
        }
    }
}
