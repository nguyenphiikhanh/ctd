<?php

use App\Http\Utils\RoleUtils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->updateOrInsert(
            ['id' => 1],
            [
                'ho' => 'doan',
                'ten' => 'thanh nien',
                'username' => 'doanthanhnien',
                'password' => Hash::make('password'),
                'role' => RoleUtils::ROLE_DOAN_TRUONG,
            ]
        );

        for($i = 2; $i <= 9; $i++){
            DB::table('users')->updateOrInsert(
                ['id' => $i],
                [
                    'ho' => 'Nguyễn Văn',
                    'ten' => 'Huy',
                    'username' => '694543174'.$i,
                    'password' => Hash::make('password'),
                    'role' => RoleUtils::ROLE_SINHVIEN,
                    'id_class' => 1,
                ]
            );
        }
    }
}
