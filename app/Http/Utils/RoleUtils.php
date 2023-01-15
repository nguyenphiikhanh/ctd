<?php

namespace App\Http\Utils;

use function PHPUnit\Framework\returnSelf;

/**
 * Created by KhanhNp
 * 01-01-2023
 */

 class RoleUtils{
    const ROLE_AMIN = 0;
    const ROLE_DOAN_TRUONG = 1;
    const ROLE_DOAN_KHOA = 2;
    const ROLE_CVHT = 3;
    const ROLE_CBL = 4;
    const ROLE_SINHVIEN = 5;

    public static function getRoleName($roleFlg){
        switch($roleFlg){
            case self::ROLE_AMIN: return 'Admin';
            break;
            case self::ROLE_DOAN_TRUONG: return 'Bí thư Đoàn trường';
            break;
            case self::ROLE_DOAN_KHOA: return 'Bí thư Liên chi Đoàn khoa';
            break;
            case self::ROLE_CVHT: return 'Cố vấn học tập chi Đoàn';
            break;
            case self::ROLE_CBL: return 'Bí thư chi Đoàn';
            break;
            default: return 'Đoàn viên chi Đoàn';
        }
    }
 }
