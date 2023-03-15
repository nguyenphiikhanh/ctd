<?php

namespace App\Http\Utils;

use function PHPUnit\Framework\returnSelf;

/**
 * Created by KhanhNp
 * 01-01-2023
 */

 class RoleUtils{
    const ROLE_AMIN = 0;
    const ROLE_BI_THU_DOAN = 1;
    const ROLE_CVHT = 3;
    const ROLE_CBL = 4;
    const ROLE_SINHVIEN = 5;
    const ROLE_LOP_TRUONG = 6;
    const ROLE_PHU_TRACH_NVSP = 7;
    const ROLE_QUAN_LY_KHOA = 8;


    public static function getRoleName($roleFlg){
        switch($roleFlg){
            case self::ROLE_AMIN: return 'Admin';
            break;
            case self::ROLE_BI_THU_DOAN: return 'Bí thư Liên chi Đoàn';
            break;
            case self::ROLE_QUAN_LY_KHOA: return 'Quản lý khoa';
            break;
            case self::ROLE_CVHT: return 'Cố vấn học tập';
            break;
            case self::ROLE_CBL: return 'Bí thư lớp';
            break;
            case self::ROLE_LOP_TRUONG: return 'Lớp trưởng';
            break;
            case self::ROLE_PHU_TRACH_NVSP: return 'Phụ trách viên';
            default: return 'Sinh viên';
        }
    }
 }
