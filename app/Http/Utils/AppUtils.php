<?php

namespace App\Http\Utils;

/**
 * Created by KhanhNp
 * 01-01-2023
 */

 class AppUtils{
    // Kiểu(child_activities)
    const THONG_BA0_KHONG_PHAN_HOI = 1;
    const THONG_BAO_CO_PHAN_HOI = 2;
    const THONG_BAO_C0_PHAN_HOI_THAM_DU = 3;
    const THONG_BAO_C0_PHAN_HOI_THAM_GIA = 4;
    const PHAN_THI_OR_TIEU_BAN = 5;
    const TB_GUI_DS_THAM_DU = 6;
    const TB_GUI_DS_THAM_GIA = 7;

    // Loại nhiệm vụ(activities)
    const ACTION_NCKH = 1;
    const ACTION_NVSP = 2;
    const ACTION_DOAN = 3;
    const ACTION_KHAC = 4;

    // trạng thái nhiệm vụ(status)
    const STATUS_CHUA_HOAN_THANH = 0;
    const STATUS_HOAN_THANH = 1;
    const STATUS_CHO_DUYET = 9;
    const STATUS_DUYET = 8;
    const STATUS_TU_CHOI = 7;
    const STATUS_VANG_MAT = null;
 }
