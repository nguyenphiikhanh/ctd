

import NhiemVu from "../components/NhiemVu/NhiemVu";
import GiaoNhiemVu from "../components/NhiemVu/GiaoNhiemVu";
import AdminDashBoard from "../components/dashboards/AdminDashBoard";
import Notifications from "../components/NhiemVu/ThongBao/Notifications";
import CheckList from "../components/diemDanh/CheckList";
import KhoaDaoTao from "../components/quanLy/KhoaDaoTao/KhoaDaoTao";
import Khoa from "../components/quanLy/khoa/Khoa";
import Classes from "../components/quanLy/lop/Classes";
import Students from "../components/quanLy/sinhvien/Students"

const routes = [
    // dashboard
    {
        name:"Home",
        path:"/",
        component: AdminDashBoard,
        meta:{
            title: 'Nhiệm vụ',
            requiresAuth: true,
            adminAccess: true,
        }
    },

    //khóa đào tạo
    {
        name:"KhoaDaoTao",
        path:"/quan-ly/khoa-dao-tao",
        component: KhoaDaoTao,
        meta:{
            title: 'Quản lý khóa đào tạo',
            requiresAuth: true,
            adminAccess: true,
        }
    },
    //liên chi Đoàn
    {
        name:"Khoa",
        path:"//quan-ly/khoa",
        component: Khoa,
        meta:{
            title: 'Quản lý khoa',
            requiresAuth: true,
            adminAccess: true,
        }
    },
    // chi Đoàn
    {
        name:"Lop",
        path:"/quan-ly/lop",
        component: Classes,
        meta:{
            title: 'Quản lý lớp',
            requiresAuth: true,
            adminAccess: true,
        }
    },
    // Đoàn viên
    {
        name:"SinhVien",
        path:"/quan-ly/lop-:id/danh-sach-sinh-vien",
        component: Students,
        meta:{
            title: 'Quản lý Sinh viên',
            requiresAuth: true,
            adminAccess: true,
        }
    },
    // nhiệm vụ
    {
        name:"NhiemVu_List",
        path:"/nhiem-vu",
        component: NhiemVu,
        meta:{
            title: 'Nhiệm vụ',
            requiresAuth: true,
            adminAccess: false,
        }
    },
    {
        name:"NhiemVu_Create",
        path:"/nhiem-vu/create",
        component: GiaoNhiemVu,
        meta:{
            title: 'Tạo nhiệm vụ',
            requiresAuth: true,
            adminAccess: false,
        }
    },
    {
        name:"Notifications",
        path:"/thong-bao-nhiem-vu",
        component: Notifications,
        meta:{
            title: 'Thông báo nhiệm vụ',
            requiresAuth: true,
            adminAccess: false,
        }
    },

    // điểm danh hoạt động
    {
        name:"CheckList",
        path:"/diem-danh",
        component: CheckList,
        meta:{
            title: 'Điểm danh hoạt động',
            requiresAuth: true,
            adminAccess: false,
        }
    },
];

export default routes;
