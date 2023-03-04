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
import khoa from './modules/khoa';
import student from './modules/students';
import studyYear from './modules/studyYear';
import studyTime from './modules/studyTime';
import points from './modules/points';
import tieuChi from './modules/tieuChi';

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
        khoaDaoTao,
        khoa,
        student,
        studyYear,
        studyTime,
        points,
        tieuChi
    }
});

Vue.prototype.$store = store;

export default store;
