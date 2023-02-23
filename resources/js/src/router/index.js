import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";
import constants from "../constants";

Vue.use(VueRouter);

import routes from "./routes";

let router = new VueRouter({
   base: process.env.MIX_BASE_URL,
   mode: 'history',
   routes,
});

const roles = constants.roles;

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`

    if (to.matched.some(record => record.meta.requiresAuth) && !store.getters["auth/isAuthenticated"] ) {  //auth
            location.href = '/dang-nhap';
    }

    if(to.matched.some(record => record.path != '/dang-nhap')){
        const role = store.getters['auth/user'].role;
        if (to.matched.some(record => !record.meta.adminAccess) && role == roles.ADMIN) { // block admin middleware
            router.push({name: "Home"});
        }

        if (to.matched.some(record => !record.meta.btdAccess) && role == roles.ROLE_BI_THU_DOAN) { // block btDoan middleware
            router.push({name: "Home"});
        }

        if (to.matched.some(record => !record.meta.cblAccess) && (role == roles.ROLE_LOP_TRUONG || role == roles.ROLE_CBL)) { // block cbl middleware
            router.push({name: "Home"});
        }

        if (to.matched.some(record => !record.meta.ptAccess) && role == roles.ROLE_PHU_TRACH_NVSP) { // block pt middleware
            router.push({name: "Home"});
        }
    }

    next();
})

export default router;
