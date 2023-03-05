<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TieuChiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'Đi học đầy đủ, đúng giờ',
                'max_score' => 3,
                'id_loai_tieu_chi' => 1,
                'type' => 1,
                'note' => '(-1 điểm/ 1 lần vắng không phép, -2 điểm/ 3 buổi đi muộn'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 2],
            [
                'name' => 'Chuẩn bị bài đầy đủ',
                'max_score' => 2,
                'id_loai_tieu_chi' => 1,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 3],
            [
                'name' => 'Có tham gia nghiên cứu khoa học',
                'max_score' => 1.5,
                'id_loai_tieu_chi' => 2,
                'type' => null,
                'note' => '(+1,5 có đề tài được báo cáo)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 4],
            [
                'name' => 'Đạt giải nghiên cứu khoa học',
                'max_score' => 0.5,
                'id_loai_tieu_chi' => 2,
                'type' => null,
                'note' => '(+0,5 được giải NCKH)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 5],
            [
                'name' => 'Có tham gia các câu lạc bộ học thuật, ngoại khóa',
                'max_score' => 1.5,
                'id_loai_tieu_chi' => 2,
                'type' => null,
                'note' => '(+1,5 tham gia 1 CLB, ngoại khóa)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 6],
            [
                'name' => 'Nhận được giấy khen hoạt động ngoại khóa và các câu lạc bộ',
                'max_score' => 0.5,
                'id_loai_tieu_chi' => 1,
                'type' => null,
                'note' => '(+0,5 nhận giấy khen ngoại khóa, CLB)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 7],
            [
                'name' => 'Tham gia đầy đủ các buổi thi',
                'max_score' => 1,
                'id_loai_tieu_chi' => 3,
                'type' => 1,
                'note' => '(-1 điểm / vắng thi)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 8],
            [
                'name' => 'Thi lại',
                'max_score' => 1.5,
                'id_loai_tieu_chi' => 3,
                'type' => 3
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 9],
            [
                'name' => 'Tham gia đầy đủ các buổi rèn luyện NVSP',
                'max_score' => 1,
                'id_loai_tieu_chi' => 3,
                'type' => 1,
                'note' => '(-1 điểm / vắng 1 buổi)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 10],
            [
                'name' => 'Tham dự thi NVSP cấp khoa, trường',
                'max_score' => 1,
                'id_loai_tieu_chi' => 3,
                'type' => null,
                'note' => '(+1 điểm/ tham gia 1 thi NVSP cấp khoa, cấp trường'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 11],
            [
                'name' => 'Đạt giải nhất, nhì, ba trong các cuộc thi từ cấp khoa trở lên',
                'max_score' => 1,
                'id_loai_tieu_chi' => 3,
                'type' => null,
                'note' => '(+1 điểm/ đạt giải thừ 3 trở lên)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 12],
            [
                'name' => 'Phấn đấu rèn luyện, tu dưỡng đạo đức, có long kiên trì, nhẫn nại… có thể vượt qua mọi khó khăn của cuộc sống để vươn lên trong học tập',
                'max_score' => 1.5,
                'id_loai_tieu_chi' => 4,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 13],
            [
                'name' => 'Điểm TBC cả kì',
                'max_score' => 2.5,
                'id_loai_tieu_chi' => 5,
                'type' => 3
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 14],
            [
                'name' => 'Thực hiện tốt nội quy, quy định của Đảng, Bộ Giáo dục và Đào tạo, của trường',
                'max_score' => 5,
                'id_loai_tieu_chi' => 6,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 15],
            [
                'name' => 'Chấp hành đầy đủ nội quy nội, ngoại trú của lớp, khoa, trường',
                'max_score' => 4,
                'id_loai_tieu_chi' => 6,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 16],
            [
                'name' => 'Tham gia tích cực việc tuyên truyền, phổ biến nội quy, quy chế của trường, của Bộ Giáo dục và Đào tạo',
                'max_score' => 3,
                'id_loai_tieu_chi' => 6,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 17],
            [
                'name' => 'Có hành vi giúp đỡ, đấu tranh để đảm bảo nội quy, quy chế được thực hiện',
                'max_score' => 3,
                'id_loai_tieu_chi' => 6,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 18],
            [
                'name' => 'Vi phạm quy chế thi bị trừ:',
                'max_score' => 0,
                'id_loai_tieu_chi' => 6,
                'type' => 3,
                'note' => 'Khiển trách: (-10 điểm/ vi phạm); Cảnh cáo: (-15 điểm/ vi phạm); Đình chỉ thi: (-25 điểm/ vi phạm)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 19],
            [
                'name' => 'Vi phạm quy chế công tác học sinh sinh viên bị trừ:',
                'max_score' => 0,
                'id_loai_tieu_chi' => 6,
                'type' => 3,
                'note' => 'Khiển trách: (-10 điểm/ vi phạm); Cánh cáo: (-15 điểm/ vi phạm); Đình chỉ học tập: (-25 điểm/ vi phạm)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 20],
            [
                'name' => 'Thực hiện tốt nội quy, quy định khác được áp dụng trong nhà trường',
                'max_score' => 4,
                'id_loai_tieu_chi' => 7,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 21],
            [
                'name' => 'Tham gia tích cực việc tuyên truyền, phổ biến nội quy, quy chế khác (ngoài ngành)',
                'max_score' => 3,
                'id_loai_tieu_chi' => 7,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 22],
            [
                'name' => 'Có hành vi giúp đỡ, đấu tranh để đảm bảo nội quy, quy chế khác (ngoài ngành) được thực hiện',
                'max_score' => 3,
                'id_loai_tieu_chi' => 7,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 23],
            [
                'name' => 'Tham gia đầy đủ, đạt yêu cầu “Tuần sinh hoạt công dân sinh viên” (đánh giá chung cho cả 2 học kỳ trong năm học)',
                'max_score' => 3,
                'id_loai_tieu_chi' => 8,
                'type' => null,
                'note' => '(-1 điểm/ vắng)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 24],
            [
                'name' => 'Có ý thức tham gia đầy đủ, nghiêm túc hoạt động rèn luyện về chính trị, xã hội, văn hóa, văn nghệ, thể thao do Nhà trường, Đoàn, Hội tổ chức điều động (vắng 1 lần không có phép bị trừ 1 điểm)',
                'max_score' => 3,
                'id_loai_tieu_chi' => 8,
                'type' => null,
                'note' => '(-1 điểm/ vắng)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 25],
            [
                'name' => 'Là thành viên của Chi đoàn, Chi hội, câu lạc bộ được nhận các danh hiệu thi đua khen thưởng từ cấp khoa trở lên',
                'max_score' => 2,
                'id_loai_tieu_chi' => 8,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 26],
            [
                'name' => 'Tham gia các hoạt động văn hóa, văn nghệ, thể dục – thể thao đạt giải nhất, nhì , ba',
                'max_score' => 2,
                'id_loai_tieu_chi' => 8,
                'type' => null,
                'note' => '(+2 điểm / đạt giải)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 27],
            [
                'name' => 'Tham gia các hoạt động tình nguyện (Hiến máu nhân đạo, tiếp sức mùa thi, mùa hè xanh)',
                'max_score' => 3,
                'id_loai_tieu_chi' => 9,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 28],
            [
                'name' => 'Được kết nạp Đảng',
                'max_score' => 1,
                'id_loai_tieu_chi' => 9,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 29],
            [
                'name' => 'Học và có giấy chứng nhận Đoàn viên Ưu tú',
                'max_score' => 0.5,
                'id_loai_tieu_chi' => 9,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 30],
            [
                'name' => 'Học và có giấy chứng nhận nhận thức về Đảng',
                'max_score' => 0.5,
                'id_loai_tieu_chi' => 9,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 31],
            [
                'name' => 'Có ý thức tham gia các hoạt động tuyên truyền, phòng chống tội phạm và các tệ nạn xã hội trong và ngoài nhà trường',
                'max_score' => 3,
                'id_loai_tieu_chi' => 10,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 32],
            [
                'name' => 'Được biểu dương khen thưởng từ cấp khoa trở lên do có thành tích trong các hoạt động phòng chống tội phạm, các tệ nạn xã hội',
                'max_score' => 2,
                'id_loai_tieu_chi' => 10,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 33],
            [
                'name' => 'Có ý thức chấp hành tốt chính sách, pháp luật của Nhà nước',
                'max_score' => 1.5,
                'id_loai_tieu_chi' => 11,
                'type' => 4,
                'note' => 'Không vi phạm: (1,5); Vi phạm 1 lần: (- 2 điểm); Vi phạm 2 lần trở lên: (Trừ toàn bộ điểm tiêu chí)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 34],
            [
                'name' => 'Tích cực tham gia tuyên truyền chính sách, pháp luật của Nhà nước',
                'max_score' => 1.5,
                'id_loai_tieu_chi' => 11,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 35],
            [
                'name' => 'Tham gia giữ gìn trật tự an toàn xã hội',
                'max_score' => 1.5,
                'id_loai_tieu_chi' => 11,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 36],
            [
                'name' => 'Tham gia có hiệu quả các buổi học tập tìm hiểu luật pháp do các tổ chức ngoài nhà trường đứng ra tổ chức',
                'max_score' => 1.5,
                'id_loai_tieu_chi' => 11,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 37],
            [
                'name' => 'Có tham gia bảo hiểm y tế (bắt buộc) theo luật bảo hiểm y tế (không tham gia bảo hiểm y tế bị trừ 1 điểm)',
                'max_score' => 1,
                'id_loai_tieu_chi' => 11,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 38],
            [
                'name' => 'Có ý thức chấp hành, tham gia tuyên truyền các quy định về bảo đảm an toàn giao thông và “văn hóa giao thông”',
                'max_score' => 1,
                'id_loai_tieu_chi' => 11,
                'type' => null,
                'note' => '(-1 điểm/ vi phạm)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 39],
            [
                'name' => 'Có ý thức tham gia các hoạt động xã hội, có thành tích được ghi nhận, biểu dương, khen thưởng',
                'max_score' => 4,
                'id_loai_tieu_chi' => 12,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 40],
            [
                'name' => 'Có ý thức giữ gìn vệ sinh mội trường trong nhà trường và xã hội',
                'max_score' => 3,
                'id_loai_tieu_chi' => 12,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 41],
            [
                'name' => 'Có tinh thần chia sẻ, giúp đỡ người gặp khó khăn, hoạn nạn',
                'max_score' => 3,
                'id_loai_tieu_chi' => 13,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 42],
            [
                'name' => 'Có lối sống lành mạnh, có mối quan hệ tốt với bạn trong lớp, trong trường',
                'max_score' => 3,
                'id_loai_tieu_chi' => 13,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 43],
            [
                'name' => 'Có tinh thần đoàn kết giúp đỡ nhau cùng tiến bộ trong học tập',
                'max_score' => 3,
                'id_loai_tieu_chi' => 13,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 44],
            [
                'name' => 'Được biểu dương khen thưởng về tham gia giữ gìn trật tự an toàn xã hội và cộng đồng',
                'max_score' => 1,
                'id_loai_tieu_chi' => 13,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 45],
            [
                'name' => 'Có ý thức, tinh thần, thái độ, uy tín và đạt hiệu quả công việc khi sinh viên được phân công nhiệm vụ Ban cán sự lớp, là Chi ủy viên trong các tổ chức Đảng, trong Ban Chấp hành Đoàn Thanh niên, Hội Sinh viên và các tổ chức khác trong Nhà trường',
                'max_score' => 2,
                'id_loai_tieu_chi' => 14,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 46],
            [
                'name' => 'Tham gia đầy đủ các công tác đoàn thể xã hội do Nhà trường, Đoàn Thanh niên, Hội Sinh viên trường phát động',
                'max_score' => 2,
                'id_loai_tieu_chi' => 14,
                'type' => 1,
                'note' => '(Trừ 2/ vắng 1 nhiệm vụ đoàn)'
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 47],
            [
                'name' => 'Đảm nhận, tích cực hoạt động phát huy tốt vai trò, kỹ năng tổ chức, quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên và các tổ chức khác trong Nhà trường',
                'max_score' => 1,
                'id_loai_tieu_chi' => 15,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 48],
            [
                'name' => 'Được khen thưởng từ cấp lớp trở lên',
                'max_score' => 1,
                'id_loai_tieu_chi' => 15,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 49],
            [
                'name' => 'Đạt danh hiệu sinh viên 5 tốt',
                'max_score' => 1,
                'id_loai_tieu_chi' => 16,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 50],
            [
                'name' => 'Vận động, tuyên truyền, tham gia giúp đỡ người khác, tham gia công việc chung của trường, lớp, Đoàn, Hội hiệu quả',
                'max_score' => 1,
                'id_loai_tieu_chi' => 16,
                'type' => null
            ]
        );
        DB::table('tieu_chi')->updateOrInsert(
            ['id' => 51],
            [
                'name' => 'Vận động, tuyên truyền, tham gia giúp đỡ người khác, tham gia công việc chung của trường, lớp, Đoàn, Hội hiệu quả',
                'max_score' => 1,
                'id_loai_tieu_chi' => 17,
                'type' => null
            ]
        );
    }
}
