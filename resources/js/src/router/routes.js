import NhiemVu from "../components/NhiemVu/NhiemVu";
import GiaoNhiemVu from "../components/NhiemVu/GiaoNhiemVu";
import AdminDashBoard from "../components/dashboards/AdminDashBoard";
import Notifications from "../components/NhiemVu/ThongBao/Notifications";
import CheckList from "../components/diemDanh/CheckList";
import KhoaDaoTao from "../components/quanLy/KhoaDaoTao/KhoaDaoTao";
import Khoa from "../components/quanLy/khoa/Khoa";
import Classes from "../components/quanLy/lop/Classes";
import Students from "../components/quanLy/sinhvien/Students";
import Year from '../components/quanLy/namHoc/Year';
import StudyTime from '../components/quanLy/hocKy/StudyTime';
import Assignee from '../components/quanLy/phuTrachNVSP/Assignee';
import ClassList from "../components/quanLy/diemNVSP/ClassList";
import ClassMeetScore from '../components/quanLy/diemTuDanhGia/ClassMeetScore';
import SelfCheckPoint from "../components/DanhGia/SelfCheckPoint";

const routes = [
    // dashboard
    {
        name:"Home",
        path:"/",
        component: AdminDashBoard,
        meta:{
            title: 'Trang chủ',
            requiresAuth: true,
            adminAccess: true,
            cblAccess: true,
            btdAccess: true,
            ptAccess: true,
            studentAccess: true,
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
            cblAccess: false,
            btdAccess: false,
            ptAccess: false,
            studentAccess: false,
        }
    },
    //khoa
    {
        name:"Khoa",
        path:"/quan-ly/khoa",
        component: Khoa,
        meta:{
            title: 'Quản lý khoa',
            requiresAuth: true,
            adminAccess: true,
            cblAccess: false,
            btdAccess: false,
            ptAccess: false,
            studentAccess: false,
        }
    },
    // Năm học
    {
        name:"Year",
        path:"/quan-ly/nam-hoc",
        component: Year,
        meta:{
            title: 'Quản lý Năm học',
            requiresAuth: true,
            adminAccess: true,
            cblAccess: false,
            btdAccess: false,
            ptAccess: false,
            studentAccess: false,
        }
    },
    // kì học
    {
        name:"StudyTime",
        path:"/quan-ly/ki-hoc",
        component: StudyTime,
        meta:{
            title: 'Quản lý kì học',
            requiresAuth: true,
            adminAccess: true,
            cblAccess: false,
            btdAccess: false,
            ptAccess: false,
            studentAccess: false,
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
            cblAccess: false,
            btdAccess: true,
            ptAccess: true,
            studentAccess: false,
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
            cblAccess: false,
            btdAccess: true,
            ptAccess: true,
            studentAccess: false,
        }
    },
    //quản lý người phụ trách
    {
        name:"Assignee",
        path:"/quan-ly/phu-trach-vien",
        component: Assignee,
        meta:{
            title: 'Quản lý phụ trách viên',
            requiresAuth: true,
            adminAccess: false,
            cblAccess: false,
            btdAccess: true,
            studentAccess: false,
        }
    },
       // lớp
       {
        name:"Lop",
        path:"/quan-ly/lop",
        component: Classes,
        meta:{
            title: 'Quản lý lớp',
            requiresAuth: true,
            adminAccess: false,
            cblAccess: false,
            btdAccess: true,
            ptAccess: false,
            studentAccess: false,
        }
    },
    // sinh viên
    {
        name:"SinhVien",
        path:"/quan-ly/lop-:id/danh-sach-sinh-vien",
        component: Students,
        meta:{
            title: 'Quản lý Sinh viên',
            requiresAuth: true,
            adminAccess: false,
            cblAccess: false,
            btdAccess: true,
            ptAccess: false,
            studentAccess: false,
        }
    },
    // Điểm rèn luyện tuần NVSP
    {
        name:"NvspPoint",
        path:"/quan-ly/diem-nvsp",
        component: ClassList,
        meta:{
            title: 'Quản lý Điểm NVSP',
            requiresAuth: true,
            adminAccess: true,
            cblAccess: false,
            btdAccess: true,
            ptAccess: false,
            studentAccess: false,
        }
    },
    // Điểm họp xét lớp
    {
        name:"ClassMeetScore",
        path:"/quan-ly/diem-hop-xet-lop",
        component: ClassMeetScore,
        meta:{
            title: 'Quản lý Điểm họp đánh giá lớp',
            requiresAuth: true,
            adminAccess: true,
            cblAccess: false,
            btdAccess: true,
            ptAccess: false,
            studentAccess: false,
        }
    },

    // ds nhiệm vụ và thông báo
    {
        name:"Notifications",
        path:"/thong-bao-nhiem-vu",
        component: Notifications,
        meta:{
            title: 'Thông báo nhiệm vụ',
            requiresAuth: true,
            adminAccess: false,
            cblAccess: true,
            btdAccess: false,
            ptAccess: false,
            studentAccess: true,
        }
    },
    // Đánh giá cá nhân
    {
        name:"PersonalCheckpoint",
        path:"/danh-gia/ca-nhan",
        component: SelfCheckPoint,
        meta:{
            title: 'Thông báo nhiệm vụ',
            requiresAuth: true,
            adminAccess: false,
            cblAccess: true,
            btdAccess: false,
            ptAccess: false,
            studentAccess: true,
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
            cblAccess: true,
            btdAccess: false,
            ptAccess: false,
            studentAccess: false,
        }
    },
];

export default routes;
