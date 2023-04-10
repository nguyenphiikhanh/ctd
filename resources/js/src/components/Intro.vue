<template>
<div class="wrap-content container mt-5">
		<h2>Hệ thống hỗ trợ đánh giá điểm rèn luyện của sinh viên trường Đại học Sư phạm Hà Nội</h2>

		<p>Liên kết đến trang đăng nhập của hệ thống: <a href="/dang-nhap">Truy cập</a></p>

		Tài khoản các tác nhân:
		<table width="100%" style="margin-top: 12px;">
			<tr>
				<th>STT</th>
				<th>Tác nhân</th>
				<th>Tài khoản</th>
				<th>Mật khẩu</th>
			</tr>
			<tr>
				<td class="t-center">1</td>
				<td>BCN khoa</td>
				<td>khoacntt</td>
				<td class="t-center">1</td>
			</tr>
            <tr>
				<td class="t-center">1</td>
				<td>Trợ lý hoạt động</td>
				<td>hongnt</td>
				<td class="t-center">1</td>
			</tr>
            <tr>
				<td class="t-center">1</td>
				<td>Phụ trách hoạt động chi tiết</td>
				<td>chindb</td>
				<td class="t-center">1</td>
			</tr>
			<tr>
				<td class="t-center">2</td>
				<td>Bí thư lớp(K69C)</td>
				<td>695105060</td>
				<td class="t-center">1</td>
			</tr>
            <tr>
				<td class="t-center">2</td>
				<td>Sinh viên(K69C)</td>
				<td>695105064</td>
				<td class="t-center">1</td>
			</tr>
			<tr>
				<td class="t-center">3</td>
				<td>Cố vấn học tập</td>
				<td>binhttt</td>
				<td class="t-center">binhhnue</td>
			</tr>
		</table>

		<p>Trình tự:</p>
		<ul>
			<li>Trợ lý hoạt động Khoa tạo ra hoạt động (Ví dụ hoạt động lớp học Đoàn viên ưu tú…). Các hoạt động này diễn ra thường niên trong một năm học của trướng Đại học Sư phạm Hà Nội</li>
			<li>Phụ trách hoạt động chi tiết: Giao các nhiệm vụ từ hoạt động vừa tạo xuống các lớp thông qua bí thư lớp</li>
			<li>Các nhiệm vụ giao xuống có thể là thông báo (không yêu cầu phản hồi) hoặc lấy danh sách người tham dự, thí sinh (Có yêu cầu phản hồi)</li>
			<li>Cán bộ bí thư lớp nhận được nhiệm vụ:</li>
			<ul>
				<li>Để hoàn thành nhiệm vụ, Bí thư lớp phải chuyển tiếp thông báo hoặc gửi danh sách (tùy thuộc vào yêu cầu của nhiệm vụ)</li>
				<li>Khi Bí thư lớp cử danh sách người tham dự sẽ có quyền điểm danh hoặc kiểm duyệt minh chứng của sinh viên cung cấp</li>
			</ul>
			<li>Sinh viên:</li>
			<ul>
				<li>Nhận nhiệm vụ từ bí thư lớp</li>
				<li>Được điểm danh khi tham gia nhiệm vụ hoặc gửi minh chứng liên quan tới nhiệm vụ</li>
			</ul>
			<li>Minh chứng được gửi từ đoàn viên ở các trạng thái:</li>
			<ul>
				<li>Chờ duyệt</li>
				<li>Từ chối (Không được duyệt và xác nhận không hoàn thành nhiệm vụ. Đoàn viên có thể gửi lại minh chứng nếu cần thiết)</li>
				<li>Xác nhận (Được duyệt và xác nhận hoàn thành nhiệm vụ)</li>
			</ul>
		</ul>
	</div>
</template>

<script>

export default {
    data(){
        return{

        }
    },
    methods:{
    },
    mounted() {
        document.title = `Giới thiệu - ${process.env.MIX_APP_NAME}`;
    },
}
</script>

<style scoped>
body{
		padding: 10px 20%;
		background-color: #eceef1;
	}
	.wrap-content{
		border-radius: 4px;
		padding: 16px;
		background-color: #fff;
	}
	table, tr, td, th{
		border: 1px solid #c7c7c7;
		border-collapse: collapse;
		padding: 3px;
	}
	td{
		padding: 5px;
	}
	th{
		background-color: #e5e8ec;
	}
	.t-center{
		text-align: center;
	}
	@media screen and (max-width: 768px) {
	  	body{
			padding: 5px;
		}
	}
</style>
