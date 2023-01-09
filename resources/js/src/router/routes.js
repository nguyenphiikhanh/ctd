
import NhiemVu from "../components/NhiemVu/NhiemVu";
import GiaoNhiemVu from "../components/NhiemVu/GiaoNhiemVu";
import AdminDashBoard from "../components/dashboards/AdminDashBoard";

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
        component: NhiemVu,
        meta:{
            title: 'Nhiệm vụ'
        }
    },
    {
        name:"NhiemVu_Create",
        path:"/nhiem-vu/create",
        component: GiaoNhiemVu,
        meta:{
            title: 'Tạo nhiệm vụ'
        }
    },
];

export default routes;
