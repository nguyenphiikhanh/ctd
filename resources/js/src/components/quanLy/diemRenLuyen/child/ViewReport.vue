<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewReport">
        <div class="modal-dialog modal-dialog-top mw-80 fs-10" role="document">
            <div class="modal-content">
                <a @click="closeModal()" class="close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Biên bản điểm rèn luyện lớp {{ classView.class_name }}</h5></div>
                <div class="modal-body p-5">
                    <div class="form-group d-flex justify-content-end align-items-center">
                        <button class="btn btn-primary btn-sm"><em class="icon ni ni-file-pdf"></em>Xuất biên bản</button>
                    </div>
                    <div class="col-12">
                        <div class="text-center">
                            <span class="h4"><b>BIÊN BẢN HỌP LỚP ĐÁNH GIÁ KẾT QUẢ RÈN LUYỆN</b></span>
                            <p>{{studyTime.name}}</p>
                        </div>
                        <div class="mt-3">
                            <p>Nội dung: Họp đánh giá kết quả điểm rèn luyện</p>
                            <p><b>I. Thành phần:</b></p>
                            <p>1. Cố vấn học tập (chủ tọa): </p>
                            <p>2. Thư ký (sinh viên): </p>
                            <p>3. Đại diện Ban cán sự lớp: </p>
                            <p>4. Tình hình sinh viên tham dự họp: </p>
                            <p>4.1. Tổng số: 29 ,Có mặt: 21 ,Vắng mặt: 8</p>
                            <p>4.2.Danh sách sinh viên vắng mặt:</p>
                            <div class="col-12 d-flex justify-content-center">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">STT</th>
                                        <th scope="col" class="text-center">Họ và tên</th>
                                        <th scope="col" class="text-center">Mã số SV</th>
                                        <th scope="col" class="text-center">Vắng mặt có phép</th>
                                        <th scope="col" class="text-center">Vắng mặt không phép</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row" class="text-center">1</th>
                                        <td class="text-center">Phạm Phúc Kiên</td>
                                        <td class="text-center">695105068</td>
                                        <td class="text-center"></td>
                                        <td class="text-center">X</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2">
                                <p><b>II. Kết quả đánh giá:</b></p>
                                <p>1. Tổng số sinh viên nộp phiếu đánh giá kết quả rèn luyện: 27</p>
                                <p>2. Tổng số sinh viên không nộp phiếu đánh giá kết quả rèn luyện sẽ bị xếp loại kém (đạt điểm không): 1, gồm những sinh viên có tên sau:</p>
                                <div class="col-12 d-flex justify-content-center">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">STT</th>
                                            <th scope="col" class="text-center">Họ và tên</th>
                                            <th scope="col" class="text-center">Mã số SV</th>
                                            <th scope="col" class="text-center">Vắng mặt có phép</th>
                                            <th scope="col" class="text-center">Vắng mặt không phép</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row" class="text-center">1</th>
                                            <td class="text-center">Phạm Phúc Kiên</td>
                                            <td class="text-center">695105068</td>
                                            <td class="text-center"></td>
                                            <td class="text-center">X</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p>3. Tổng số sinh viên không tham gia họp lớp xét điểm rèn luyện (vắng mặt không có lý do) bị hạ một bậc xếp loại rèn luyện và có điểm bằng với điểm cận dưới của loại sau khi bị hạ bậc như sau:</p>
                                <div class="col-12 d-flex justify-content-center">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">STT</th>
                                            <th scope="col" class="text-center">Họ và tên</th>
                                            <th scope="col" class="text-center">Mã số SV</th>
                                            <th scope="col" class="text-center">Vắng mặt có phép</th>
                                            <th scope="col" class="text-center">Vắng mặt không phép</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row" class="text-center">1</th>
                                            <td class="text-center">Phạm Phúc Kiên</td>
                                            <td class="text-center">695105068</td>
                                            <td class="text-center"></td>
                                            <td class="text-center">X</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p>4. Tổng hợp kết quả rèn luyện của lớp:</p>
                                <div class="col-12 d-flex justify-content-center">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">TT</th>
                                            <th scope="col" class="text-center">Khung điểm</th>
                                            <th scope="col" class="text-center">Xếp loại</th>
                                            <th scope="col" class="text-center">Số lượng</th>
                                            <th scope="col" class="text-center">Tỉ lệ %</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row" class="text-center">1</th>
                                            <td class="text-center">Từ 90 đến 100 điểm</td>
                                            <td class="text-center">Xuất sắc</td>
                                            <td class="text-center">6</td>
                                            <td class="text-center">20,69%</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button @click="closeModal()" class="btn btn-primary">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        classView: {type:Object},
        dataReport: {type: Object},
        studyTime: {type: Object},
    },
    data(){
        return{
        }
    },
    methods:{
        closeModal(){
            this.$nextTick(() => {
                $("#viewReport").modal('hide');
            })
        },
    },
    mounted() {
    }
};
</script>

<style scoped>
.mw-80{
    min-width: 80%;
}
.fs-10{
    font-size: 15px;
}
</style>
