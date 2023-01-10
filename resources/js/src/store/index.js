import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

//module
import classes from "./modules/classes";
import activity from "./modules/activity";

Vue.use(Vuex)

const store = new Vuex.Store({
    plugins:[
        createPersistedState()
    ],
    modules:{
        classes,
        activity
    }
});

Vue.prototype.$store = store;

export default store;
