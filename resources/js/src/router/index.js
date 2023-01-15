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

    if (to.matched.some(record => !record.meta.adminAccess) && store.getters['auth/user'].role == roles.ADMIN) { // block admin middleware
        router.push({name: "Home"});
    }

    next();
})

export default router;
