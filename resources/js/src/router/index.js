import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

//components
import dashBoard from '../components/dashboards/DashBoard.vue'
import nhiemVu from "../components/NhiemVu.vue";
import giaoNhiemVu from "../components/GiaoNhiemVu.vue";


const router_list = [
    // dashboard
    {
        name:"home",
        path:"/",
        component: dashBoard,
        meta:{
            title: 'Trang chủ'
        }
    },
    // nhiệm vụ
    {
        name:"nhiemVu_List",
        path:"/nhiem-vu",
        component: nhiemVu,
        meta:{
            title: 'Nhiệm vụ'
        }
    },
    {
        name:"nhiemVu_Create",
        path:"/nhiem-vu/create",
        component: giaoNhiemVu,
        meta:{
            title: 'Tạo nhiệm vụ'
        }
    },
];

const router = new VueRouter({
   mode: 'history',
    routes: router_list
});

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`
})

export default router;
