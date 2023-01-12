import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";

Vue.use(VueRouter);

import routes from "./routes";

let router = new VueRouter({
   base: process.env.MIX_BASE_URL,
   mode: 'history',
   routes,
});

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`
    if (to.matched.some(record => record.meta.requiresAuth) ) {
        if (!store.getters["auth/isAuthenticated"]) {
            location.href = '/dang-nhap';
        }
    }
    next();
})

export default router;
