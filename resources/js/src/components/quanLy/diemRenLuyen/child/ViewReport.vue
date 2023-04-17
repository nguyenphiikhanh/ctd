<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewReport">
        <div class="modal-dialog modal-dialog-top mw-80 fs-10" id="report-data" role="document">
            <div class="modal-content">
                <a @click="closeModal()" class="close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Biên bản điểm rèn luyện lớp {{ classView.class_name }}</h5></div>
                <div class="modal-body p-5">
                    <div class="form-group d-flex justify-content-end align-items-center">
                        <button @click="exportPDF()"
                         class="btn btn-primary btn-sm">
                         <em class="icon ni ni-file-download"></em>Xuất biên bản</button>
                    </div>
                    <div class="col-12 px-5 pt-3" ref="reportContent">
                        <div class="text-center">
                            <span class="h4"><b>BIÊN BẢN HỌP LỚP ĐÁNH GIÁ KẾT QUẢ RÈN LUYỆN</b></span>
                            <p>{{studyTime.name}}</p>
                        </div>
                        <div class="mt-3">
                            <p>Nội dung: Họp đánh giá kết quả điểm rèn luyện</p>
                            <p><b>I. Thành phần:</b></p>
                            <p>1. Cố vấn học tập (chủ tọa): {{ dataReport.cvht }}</p>
                            <p>2. Thư ký (sinh viên): {{ dataReport.cbl }}</p>
                            <p>3. Đại diện Ban cán sự lớp: {{ dataReport.lt }}</p>
                            <p>4. Tình hình sinh viên tham dự họp: </p>
                            <p>4.1. Tổng số: {{ dataReport.student_list.length }} ,Có mặt: {{ dataReport.check_count }} ,Vắng mặt: {{ dataReport.uncheck_count }}</p>
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
                                    <tr v-for="(user, index) in dataReport.student_uncheck" :key="index">
                                        <th scope="row" class="text-center">{{ index + 1 }}</th>
                                        <td class="text-center">{{ user.fullname }}</td>
                                        <td class="text-center">{{ user.username }}</td>
                                        <td class="text-center">{{ Number(user.class_meet_check) == status.HOP_XET_VANG_MAT_CO_LI_DO ? 'x' : '' }}</td>
                                        <td class="text-center">{{ Number(user.class_meet_check) == status.HOP_XET_VANG_MAT_KHONG_LI_DO ? 'x' : '' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2">
                                <p><b>II. Kết quả đánh giá:</b></p>
                                <p>1. Tổng số sinh viên nộp phiếu đánh giá kết quả rèn luyện: {{ dataReport.student_submited_count }}</p>
                                <p>2. Tổng số sinh viên không nộp phiếu đánh giá kết quả rèn luyện sẽ bị xếp loại kém (đạt điểm không): {{ dataReport.student_unsubmited.length }}, gồm những sinh viên có tên sau:</p>
                                <div class="col-12 d-flex justify-content-center">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">STT</th>
                                            <th scope="col" class="text-center">Họ và tên</th>
                                            <th scope="col" class="text-center">Mã số sinh viên</th>
                                            <th scope="col" class="text-center">Ghi chú</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(user, index) in dataReport.student_unsubmited" :key="index">
                                            <th scope="row" class="text-center">{{ index + 1 }}</th>
                                            <td class="text-center">{{ user.fullname }}</td>
                                            <td class="text-center">{{ user.username }}</td>
                                            <td class="text-center"></td>
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
                                            <th scope="col" class="text-center">Xếp loại trước khi bị hạ</th>
                                            <th scope="col" class="text-center">Xếp loại sau khi bị hạ(trừ 1 bậc)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(user, index) in dataReport.student_uncheck_no_reason" :key="index">
                                            <th scope="row" class="text-center">{{ index + 1 }}</th>
                                            <td class="text-center">{{ user.fullname }}</td>
                                            <td class="text-center">{{ user.username }}</td>
                                            <td class="text-center">{{ convertOriginLevel(user.sum_score) }}</td>
                                            <td class="text-center">{{ convertExecptOneLevel(user.sum_score) }}</td>
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
                                            <td class="text-center">{{ dataReport.rare_xs.count }}</td>
                                            <td class="text-center">{{ Number(dataReport.rare_xs.percent).toFixed(2) }}%</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-center">2</th>
                                            <td class="text-center">Từ 80 đến dưới 90 điểm</td>
                                            <td class="text-center">Tốt</td>
                                            <td class="text-center">{{ dataReport.rare_t.count }}</td>
                                            <td class="text-center">{{ Number(dataReport.rare_t.percent).toFixed(2) }}%</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-center">3</th>
                                            <td class="text-center">Từ 65 đến dưới 80 điểm</td>
                                            <td class="text-center">Khá</td>
                                            <td class="text-center">{{ dataReport.rare_k.count }}</td>
                                            <td class="text-center">{{ Number(dataReport.rare_k.percent).toFixed(2) }}%</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-center">4</th>
                                            <td class="text-center">Từ 50 đến dưới 65 điểm</td>
                                            <td class="text-center">Trung bình</td>
                                            <td class="text-center">{{ dataReport.rare_tb.count }}</td>
                                            <td class="text-center">{{ Number(dataReport.rare_tb.percent).toFixed(2) }}%</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-center">5</th>
                                            <td class="text-center">Từ 35 đến dưới 50d điểm</td>
                                            <td class="text-center">Yếu</td>
                                            <td class="text-center">{{ dataReport.rare_y.count }}</td>
                                            <td class="text-center">{{ Number(dataReport.rare_y.percent).toFixed(2) }}%</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-center">6</th>
                                            <td class="text-center">Dưới 35 điểm</td>
                                            <td class="text-center">Kém</td>
                                            <td class="text-center">{{ dataReport.rare_kem.count }}</td>
                                            <td class="text-center">{{ Number(dataReport.rare_kem.percent).toFixed(2) }}%</td>
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
import constants from '../../../../constants';
import { originLevel, exceptOneLevel } from '../../../../helpers/utils/levelUtil';
import html2pdf from "html2pdf.js";
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
    computed:{
        status(){
            return constants.status;
        }
    },
    methods:{
        convertOriginLevel(score){
            return originLevel(Number(score));
        },
        convertExecptOneLevel(score){
            return exceptOneLevel(Number(score));
        },
        exportPDF(){
            const options = {
                filename: `bien-ban-${this.classView.class_name}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: {},
                jsPDF: { unit: 'pt', format: 'a4', orientation: 'portrait' }
            }
            html2pdf().set(options).from(this.$refs.reportContent).save()
        },
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
