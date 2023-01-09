import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import routes from "./routes";

let router = new VueRouter({
   base: process.env.MIX_BASE_URL,
   mode: 'history',
   routes,
});

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`

    next();
})

export default router;
