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

    public static function getRoleName($roleFlg){
        switch($roleFlg){
            case self::ROLE_AMIN: return 'Admin';
            break;
            case self::ROLE_BI_THU_DOAN: return 'Bí thư Liên chi Đoàn';
            break;
            case self::ROLE_CVHT: return 'Cố vấn học tập';
            break;
            case self::ROLE_CBL: return 'Bí thư lớp';
            break;
            default: return 'Sinh viên';
        }
    }
 }
