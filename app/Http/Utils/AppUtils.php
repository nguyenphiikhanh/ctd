<?php

namespace App\Http\Utils;

/**
 * Created by KhanhNp
 * 01-01-2023
 */

 class AppUtils{
    // Bản ghi phân trang
    const ITEM_PER_PAGE = 15;

   // Loại nhiệm vụ(activities)
   const HOAT_DONG_NCKH = 1;
   const HOAT_DONG_NVSP = 2;
   const HOAT_DONG_DOAN = 3;
   const HOAT_DONG_KHAC = 4;

    // Kiểu(child_activities)
    const THONG_BA0_KHONG_PHAN_HOI = 1;
    const THONG_BAO_CO_PHAN_HOI = 2;
    const THONG_BAO_C0_PHAN_HOI_THAM_DU = 3;
    const THONG_BAO_C0_PHAN_HOI_THAM_GIA = 4;
    const PHAN_THI_OR_TIEU_BAN = 5;
    const TB_GUI_DS_THAM_DU = 6;
    const TB_GUI_DS_THAM_GIA = 7;

    // level hđ
    const LEVEL_KHOA = 1;
    const LEVEL_TRUONG = 2;
    const LEVEL_TOA_DAM = 3;

    // trạng thái nhiệm vụ(status)
    const STATUS_CHUA_HOAN_THANH = 0;
    const STATUS_HOAN_THANH = 1;
    const STATUS_VANG_MAT = 6;
    const STATUS_TU_CHOI = 7;
    const STATUS_DUYET = 8;
    const STATUS_CHO_DUYET = 9;

    // cờ boolean
    const VALID_VALUE = 1;
    const INVALID_VALUE = 0;

    // hình thức dự thi
    const THI_NHOM = 0;
    const THI_CA_NHAN = 1;

    const GIAI_NHAT = 1;
    const GIAI_NHI = 2;
    const GIAI_BA = 3;
    const GIAI_KHUYEN_KHICH = 4;

    // trạng thái điểm rèn luyện
    const SCORE_CHUA_CO_DIEM = 0;
    const SCORE_CHO_DUYET = 1;
    const SCORE_KHONG_DUYET = 2;
    const SCORE_HOAN_THANH = 3;
    const SCORE_DUYET = 4;

    // Xếp loại
    const RANK_XUAT_SAC = 'Xuất sắc';
    const RANK_TOT = 'Tốt';
    const RANK_KHA = 'Khá';
    const RANK_TRUNG_BINH = 'Trung bình';
    const RANK_YEU = 'Yếu';
 }
