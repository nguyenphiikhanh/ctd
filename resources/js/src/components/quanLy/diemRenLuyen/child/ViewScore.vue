<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewScore">
        <div class="modal-dialog modal-dialog-top mw-70" role="document">
            <div class="modal-content">
                <a @click="closeModal()" class="close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Điểm rèn luyện nghiệp vụ Sư phạm lớp {{classView.class_name}}</h5></div>
                <div class="modal-body">
                    <div class="form-group d-flex">
                        <label class="col-form-label col-1">Chọn năm học</label>
                        <select class="form-control w-33" v-model="studyTime">
                            <option v-for="(time, index) in studyTimeList" :key="index" :value="time.id">{{time.name}}</option>
                        </select>
                        <div class="col-7 d-flex justify-content-end align-items-center">
                            <button :disabled="!scoreListShow.length" @click="viewReportData()"
                                    class="btn btn-warning text-secondary btn-sm mr-cus-3"><em class="icon ni ni-file-xls"></em>Xem biên bản</button>
                            <button :disabled="!scoreListShow.length" @click="exportData()"
                                    class="btn btn-primary btn-sm"><em class="icon ni ni-file-xls"></em>Xuất kết quả</button>
                        </div>
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">STT</th>
                                <th scope="col">Họ và tên</th>
                                <th scope="col" v-if="user.role == roles.ROLE_CVHT" class="text-center">Tổng số điểm</th>
                                <th scope="col">Xếp hạng</th>
                                <th scope="col" class="text-center">Điểm kết luận</th>
                                <th scope="col" class="text-center">Ghi chú</th>
                                <th scope="col" class="text-center">Hoạt động</th>
                            </tr>
                            </thead>
                            <tbody v-if="!awating">
                            <tr v-for="(_item, index) in scoreListShow" :key="index">
                                <th scope="row" class="text-center">{{index + 1}}</th>
                                <td>{{_item.fullname}}</td>
                                <td v-if="user.role == roles.ROLE_CVHT" class="text-center">{{_item.sum_score}}</td>
                                <td>{{_item.rank}}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <input class="form-control w-50 text-center"
                                               type="number" max="100" min="0" ref="score_last_item"
                                               @change="changeLastScore(_item)" @blur="changeLastScore(_item)"
                                               v-model="_item.last_score">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <input class="form-control w-75 text-center" @blur="changeLastScore(_item)" v-model="_item.note">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a :href="`/diem-ren-luyen/view-details/student-${_item.id_user}/time-${studyTime}`" target="_blank" class="text-primary btn hover-underline">Xem chi tiết</a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <p v-if="awating" class="text-center">
                    Đang lấy dữ liệu điểm...
                </p>
                <p v-if="scoreListShow.length == 0 && !awating" class="text-center">
                    Không có dữ liệu.
                </p>
                <div class="modal-footer d-flex justify-content-center">
                    <button @click="closeModal()" class="btn btn-primary">Đóng</button>
                </div>
                <ViewReport :class-view="classView" :data-report="dataReport" :study-time="studyTimeProps"/>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import constants from '../../../../constants';
import Exceljs from 'exceljs';
import ViewReport from "./ViewReport";
import status from '../../../../constants/status';
export default {
    components:{ViewReport},
    props:{
        scoreList: {type: Array },
        classView: {type:Object},
        studyTimeList: {type: Array},
    },
    data(){
        return{
            awating: false,
            studyTimeListShow: [],
            scoreListShow: [],
            studyTime: null,
            dataReport: {
                cvht: null,
                cbl: null,
                lt: null,
                student_list: [],
                student_submited_count: 0,
                student_unsubmited: [],
                student_uncheck: [],
                student_uncheck_no_reason: [],
                rare_xs: {
                    count: 0,
                    percent: 0
                },
                rare_t: {
                    count: 0,
                    percent: 0
                },
                rare_k: {
                    count: 0,
                    percent: 0
                },
                rare_tb: {
                    count: 0,
                    percent: 0
                },
                rare_y: {
                    count: 0,
                    percent: 0
                },
                rare_kem: {
                    count: 0,
                    percent: 0
                },
            }
        }
    },
    methods:{
        ...mapActions({
            getScoreByClass: "points/getScoreByClass",
            updateLastScore: 'points/updateLastScore',
            getReportData: 'points/getReportData',
        }),
        async changeLastScore(item){
            await this.updateLastScore(item);
            let data = {
                id_class: this.classView.id,
                id_study_time: this.studyTime,
            }
            if(data.id_class){
                await this.getScoreByClass(data).then(res => this.scoreListShow = [...res.data]);
            }
        },
        async viewReportData(){
            let data = {
                id_class: this.classView.id,
                id_study_time: this.studyTime,
            }
            await this.getReportData(data).then(res => {
                const resData = {...res.data};
                this.dataReport.cvht = resData.cvht;
                const cbl = resData.student_list.find(user => Number(user.role) == this.roles.ROLE_CBL);
                this.dataReport.cbl = cbl.fullname;
                const lt = resData.student_list.find(user => Number(user.role) == this.roles.ROLE_LOP_TRUONG);
                this.dataReport.lt = lt.fullname;
                this.dataReport.student_list = resData.student_list;
                this.dataReport.student_uncheck = resData.user_uncheck;
                this.dataReport.student_uncheck_no_reason = resData.user_uncheck.filter(_item => Number(_item.class_meet_check) == status.HOP_XET_VANG_MAT_KHONG_LI_DO);
                this.dataReport.check_count = resData.student_list.length - resData.user_uncheck.length;
                this.dataReport.uncheck_count = this.dataReport.student_uncheck.length
                this.dataReport.student_unsubmited = resData.student_unsubmited;
                this.dataReport.student_submited_count = resData.student_list.length - resData.student_unsubmited.length;
                //xs
                const level_xs = resData.score_data.filter(item => Number(item.last_score) >= 90 && Number(item.last_score) <= 100);
                this.dataReport.rare_xs = {
                    count: level_xs.length,
                    percent: level_xs.length / resData.score_data.length * 100,
                }
                //tot
                const level_t = resData.score_data.filter(item => Number(item.last_score) >= 80 && Number(item.last_score) < 90);
                this.dataReport.rare_t = {
                    count: level_t.length,
                    percent: level_t.length / resData.score_data.length * 100,
                }

                //kha
                const level_k = resData.score_data.filter(item => Number(item.last_score) >= 65 && Number(item.last_score) < 80);
                this.dataReport.rare_k = {
                    count: level_k.length,
                    percent: level_k.length / resData.score_data.length * 100,
                }

                //trung binh
                const level_tb = resData.score_data.filter(item => Number(item.last_score) >= 50 && Number(item.last_score) < 65);
                this.dataReport.rare_tb = {
                    count: level_tb.length,
                    percent: level_tb.length / resData.score_data.length * 100,
                }

                //yeu
                const level_y = resData.score_data.filter(item => Number(item.last_score) >= 35 && Number(item.last_score) < 50);
                this.dataReport.rare_y = {
                    count: level_y.length,
                    percent: level_y.length / resData.score_data.length * 100,
                }

                //yeu
                const level_kem = resData.score_data.filter(item => Number(item.last_score) < 35);
                this.dataReport.rare_kem = {
                    count: level_kem.length,
                    percent: level_kem.length / resData.score_data.length * 100,
                }
            });
            this.$nextTick(() => {
                $("#viewReport").modal('show');
            })
        },
        exportData(){
            const workbook = new Exceljs.Workbook();
            const worksheet = workbook.addWorksheet('Sheet1');
            worksheet.columns = [
                { header: 'STT', key: 'stt', width: 20 },
                { header: 'Họ và tên', key: 'fullname', width: 40 },
                { header: 'Tổng số điểm', key: 'sum_score', width: 10 },
                { header: 'Xếp hạng', key: 'rank', width: 30 },
                { header: 'Điểm kết luận', key: 'last_score', width: 10 },
                { header: 'Ghi chú', key: 'note', width: 50 },
            ];
            this.scoreListShow.map((_item, index) => {
                worksheet.addRow({
                    stt: index + 1,
                    fullname: _item.fullname,
                    sum_score: _item.sum_score,
                    rank: _item.rank,
                    last_score: _item.last_score,
                    note: _item.note,
                });
            });
            workbook.xlsx.writeBuffer().then((buffer) => {
                const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = `kq-diem-ren-luyen-${this.classView.class_name}.xlsx`; // file name
                link.click();
                URL.revokeObjectURL(url);
            });
        },
        closeModal(){
            this.studyTime = this.studyTimeList.reduce((max, obj) => obj.id > max ? obj.id : max, -Infinity);
            this.$emit('closeModal');
        },
    },
    computed: {
        roles(){
            return constants.roles;
        },
        user(){
            return this.$store.getters['auth/user'];
        },
        studyTimeProps(){
            const stdTime = this.studyTimeList.find(item => item.id == this.studyTime);
            return stdTime;
        }
    },
    watch:{
        async studyTime(val){
            this.awating = true;
            this.studyTime = val;
            let data = {
                id_class: this.classView.id,
                id_study_time: this.studyTime,
            }
            if(data.id_class){
                await this.getScoreByClass(data).then(res => this.scoreListShow = [...res.data]);
                this.scoreListShow.map(_item => _item.editFlg = false);
            }
            this.awating = false;
        }
    },
    mounted() {
        this.studyTime = this.studyTimeList.reduce((max, obj) => obj.id > max ? obj.id : max, -Infinity);
    }
};
</script>

<style scoped>
.mw-70{
    min-width: 70%;
}
.hover-underline:hover{
    text-decoration: underline;
}
.mr-cus-3{
    margin-right: 3em;
}
.w-33{
    width: 33.333333333%;
}
</style>
