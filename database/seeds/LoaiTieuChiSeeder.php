<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoaiTieuChiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'Ý thức và thái độ trong học tập',
                'id_tieu_chi_big_type' => 1
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 2],
            [
                'name' => 'Ý thức và thái độ tham gia các câu lạc bộ học thuật, các hoạt động học thuật, ngoại khóa, hoạt động nghiên cứu khoa học',
                'id_tieu_chi_big_type' => 1
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 3],
            [
                'name' => 'Ý thức và thái độ tham gia các kỳ thi, cuộc thi',
                'id_tieu_chi_big_type' => 1
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 4],
            [
                'name' => 'Tinh thần vượt khó phấn đấu vươn lên trong học tập',
                'id_tieu_chi_big_type' => 1
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 5],
            [
                'name' => ' Kết quả học tập',
                'id_tieu_chi_big_type' => 1
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 6],
            [
                'name' => 'Ý thức chấp hành các văn bản chỉ đạo của ngành, của cơ quan chỉ đạo cấp trên được thực hiện trong nhà trường',
                'id_tieu_chi_big_type' => 2
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 7],
            [
                'name' => 'Ý thức chấp hành nội quy, quy chế và các quy định khác được áp dụng trong nhà trường',
                'id_tieu_chi_big_type' => 2
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 8],
            [
                'name' => 'Ý thức và hiệu quả tham gia các hoạt động rèn luyện về chính trị - xã hội, văn hóa, văn nghệ, thể thao',
                'id_tieu_chi_big_type' => 3
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 9],
            [
                'name' => 'Ý thức tham gia các hoạt động công ích, tình nguyện, công tác xã hội trong nhà trường',
                'id_tieu_chi_big_type' => 3
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 10],
            [
                'name' => 'Ý thức tham gia các hoạt động tuyên truyền, phòng chống tội phạm và các tệ nạn xã hội trong nhà trường',
                'id_tieu_chi_big_type' => 3
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 11],
            [
                'name' => 'Ý thức chấp hành và tham gia tuyên truyền các chủ trương của Đảng, chính sách, pháp luật của Nhà nước',
                'id_tieu_chi_big_type' => 4
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 12],
            [
                'name' => 'Có ý thức tham gia các hoạt động xã hội, có thành tích được ghi nhận, biểu dương, khen thưởng',
                'id_tieu_chi_big_type' => 4
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 13],
            [
                'name' => 'Có tinh thần chia sẻ, giúp đỡ người gặp khó khăn, hoạn nạn',
                'id_tieu_chi_big_type' => 4
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 14],
            [
                'name' => 'Ý thức, tinh thần, thái độ, uy tín và đạt hiệu quả công việc khi sinh viên được phân công nhiệm vụ quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên và các tổ chức khác trong Nhà trường',
                'id_tieu_chi_big_type' => 5
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 15],
            [
                'name' => 'Kỹ năng tổ chức, quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên và các tổ chức khác trong Nhà trường',
                'id_tieu_chi_big_type' => 5
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 16],
            [
                'name' => 'Hỗ trợ và tham gia tích cực các hoạt động chung của tập thể lớp, khoa, trường',
                'id_tieu_chi_big_type' => 5
            ]
        );
        DB::table('loai_tieu_chi')->updateOrInsert(
            ['id' => 17],
            [
                'name' => 'Đạt thành tích đặc biệt trong học tập, rèn luyện',
                'id_tieu_chi_big_type' => 5
            ]
        );
    }
}
