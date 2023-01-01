<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('activities')->updateOrInsert(
            ['id' => 1],
            ['activity_name' => 'Hoạt động Nghiên cứu Khoa học']
        );

        DB::table('activities')->updateOrInsert(
            ['id' => 2],
            ['activity_name' => 'Hoạt động Nghiệp vụ Sư phạm']
        );

        DB::table('activities')->updateOrInsert(
            ['id' => 3],
            ['activity_name' => 'Hoạt động Đoàn']
        );

        DB::table('activities')->updateOrInsert(
            ['id' => 4],
            ['activity_name' => 'Hoạt động Khác']
        );
    }
}
