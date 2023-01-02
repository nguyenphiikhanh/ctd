import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

//components
import nhiemVu from "../components/NhiemVu";
import giaoNhiemVu from "../components/GiaoNhiemVu";


const Routes = [
    // nhiệm vụ
    {
        name:"nhiemVu_List",
        path:"/nhiem-vu",
        component:nhiemVu,
        meta:{
            title: 'Nhiệm vụ'
        }
    },
    {
        name:"nhiemVu_Create",
        path:"/nhiem-vu/create",
        component:giaoNhiemVu,
        meta:{
            title: 'Tạo nhiệm vụ'
        }
    },
];

const router = new VueRouter({
   mode: 'history',
   routes: Routes
});

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`
})

export default router;
