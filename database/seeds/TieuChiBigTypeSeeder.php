<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TieuChiBigTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tieu_chi_big_type')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'I. Đánh giá về ý thức học tập (Khung điểm đánh giá: Từ 0 đến 20 điểm)'
            ]
        );
        DB::table('tieu_chi_big_type')->updateOrInsert(
            ['id' => 2],
            [
                'name' => 'II. Đánh giá về ý thức và kết quả chấp hành nội quy, quy chế trong nhà trường (Khung điểm đánh giá từ 0 đến 25 điểm)'
            ]
        );
        DB::table('tieu_chi_big_type')->updateOrInsert(
            ['id' => 3],
            [
                'name' => 'III. Đánh giá về ý thức và việc tham gia các hoạt động chính trị - xã hội, văn hóa, văn nghệ, thể thao, phòng chống các tệ nạn xã hội (Khung điểm đánh giá từ 0 đến 20 điểm)'
            ]
        );
        DB::table('tieu_chi_big_type')->updateOrInsert(
            ['id' => 4],
            [
                'name' => 'IV. Đánh giá về phẩm chất công dân và quan hệ cộng đồng (Khung điểm đánh giá từ 0 đến 25 điểm)'
            ]
        );
        DB::table('tieu_chi_big_type')->updateOrInsert(
            ['id' => 5],
            [
                'name' => 'V. Đánh giá về ý thức và kết quả tham gia công tác phụ trách lớp, các đoàn thể, tổ chức trong nhà trường hoặc đạt được thành tích đặc biệt trong học tập, rèn luyện của sinh viên (Khung điểm đánh giá từ 0 đến 10 điểm)'
            ]
        );
    }
}
