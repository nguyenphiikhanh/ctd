import Vue from "vue";
import VueRouter from "vue-router";


import nhiemVu from "../components/NhiemVu";
import giaoNhiemVu from "../components/GiaoNhiemVu";

import AdminDashBoard from "../components/dashboards/AdminDashBoard";

Vue.use(VueRouter);

// import { routes } from "./routes";
const routes = [
    // dashboard
    {
        name:"Home",
        path:"/",
        component: AdminDashBoard,
        meta:{
            title: 'Nhiệm vụ'
        }
    },
    // nhiệm vụ
    {
        name:"NhiemVu_List",
        path:"/nhiem-vu",
        component: nhiemVu,
        meta:{
            title: 'Nhiệm vụ'
        }
    },
    {
        name:"NhiemVu_Create",
        path:"/nhiem-vu/create",
        component: giaoNhiemVu,
        meta:{
            title: 'Tạo nhiệm vụ'
        }
    },
];

let router = new VueRouter({
   base: process.env.MIX_BASE_URL,
   mode: 'history',
   routes,
});

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`
})

export default router;
