import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from "../components/Login.vue";
import Main from "../components/Main.vue";
import GiaoNhiemVu from "../components/parts/GiaoNhiemVu.vue";

Vue.use(VueRouter);

const Routers = [
    {
        name:"login",
        path:"/login",
        component: Login,
        meta:{
            middleware:"guest",
            title:`Đăng nhập`
        }
    },
    {
        path:"/",
        component: Main,
        meta:{
            middleware:"auth"
        },
        children: [
            {
                name:"giaoNhiemVu",
                path:"/giao-nhiem-vu",
                component: GiaoNhiemVu,
                meta:{
                    title:`Giao nhiệm vụ`
                }
            }
        ]
    }
];

const router = new VueRouter({
   mode: 'history',
   routes: Routers,
});

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`
    if(to.meta.middleware=="guest"){
        if(store.state.auth.authenticated){
            next({name:"dashboard"})
        }
        next()
    }else{
        if(store.state.auth.authenticated){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router;
