import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

//module
import auth from "./modules/auth";
import alert from "./modules/alert";
import classes from "./modules/classes";
import activity from "./modules/activity";
import userModule from './modules/userModule';
import khoaDaoTao from './modules/khoaDaoTao';

Vue.use(Vuex)

const store = new Vuex.Store({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        alert,
        classes,
        activity,
        userModule,
        khoaDaoTao
    }
});

Vue.prototype.$store = store;

export default store;
