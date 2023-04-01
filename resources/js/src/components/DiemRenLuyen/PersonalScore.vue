<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Xem điểm rèn luyện cá nhân</h3>
                                <h4>Thời gian kết thúc đánh giá:
                                    <span class="text-danger">{{ currentStudyTime.end_time_class_meet ? convertVnTime(currentStudyTime.end_time_class_meet) : 'Chưa mở đánh giá' }}</span>
                                </h4>
                                <h4 class="d-inline">Trạng thái:
                                    <span :class="currentStudyTime.end_time_class_meet && new Date(currentStudyTime.end_time_class_meet) >= new Date() ? 'text-success' : 'text-danger'">
                                        {{ currentStudyTime.end_time_class_meet ? new Date(currentStudyTime.end_time_class_meet) >= new Date() ? 'Đang diễn ra' : 'Đã kết thúc' : 'Chưa mở đánh giá' }}
                                    </span>
                                </h4>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Điểm rèn luyện</h5>
                            </div>
                            <div class="nk-block-head-content">
                                <a class="d-block mb-1" :href="'/file-download/tieu_chi_danh_gia.xlsx'" :download="`tieu_chi_danh_gia.xlsx`">
                                    <button class="btn btn-success btn-lg">
                                        <em class="icon ni ni-file"></em>
                                        Xem quy định đánh giá
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Nội dung đánh giá</th>
                                        <th scope="col">Điểm tối đa</th>
                                        <th scope="col">Điểm đạt được</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Ghi chú</th>
                                        <th scope="col">Hoạt động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(tc, index) in tcList" :key="index">
                                        <th scope="row">{{index+1}}</th>
                                        <td>{{tc.name}}</td>
                                        <td><div class="text-center">{{tc.max_score}}</div></td>
                                        <td><div class="text-center">{{tc.score}}</div></td>
                                        <td :class="scoreStatusClassText(tc)">{{scoreStatusText(tc)}}</td>
                                        <td class="text-center">{{tc.note}}</td>
                                        <td class="text-center">
                                            <button v-if="canUploadProoves(tc)" @click="uploadProofPopup(tc)"
                                            :class="scoreButtonClassText(tc)">{{ proofButtonText(tc) }}</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="3">
                                            <div class="text-center">Tổng điểm</div>
                                        </th>
                                        <th scope="row">
                                            <div class="text-center">
                                                <strong>{{scoreSum}}</strong>
                                            </div>
                                        </th>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <UploadModal :tcInfo="tcInfo" @proofUploaded="proofUploaded()"/>
                    </div><!-- nk-block -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import datetimeUtils from "../../helpers/utils/datetimeUtils";
import constants from '../../constants';
import UploadModal from './child/UploadModal.vue';
export default {
    components:{
        UploadModal
    },
    data(){
        return {
            tcList: [],
            tcInfo: {},
        }
    },
    computed:{
        currentStudyTime(){
            return this.$store.getters['studyTime/getStudyTimeCurrent'];
        },
        scoreSum(){
            let sum = 0;
            this.tcList.map(_item => sum += Number(_item.score));
            return sum;
        },
    },
    methods:{
        ...mapActions({
            getCurrentStudyTime: 'studyTime/getCurrentStudyTime',
            getPersonalScore: 'personalScore/getPersonalScore',
        }),
        convertVnTime(time){
            return time ? datetimeUtils.dateTimeVnFormat(time) : null;
        },
        scoreStatusText(tc){
            const status = constants.status;
            switch(tc.status){
                case status.SCORE_CHO_DUYET:
                    return 'Chờ duyệt minh chứng';
                    break;
                case status.SCORE_KHONG_DUYET:
                    return 'Minh chứng không được duyệt';
                    break;
                case status.SCORE_HOAN_THANH:
                    return 'Đã đánh giá';
                    break;
                case status.SCORE_DUYET:
                    return 'Đã duyệt';
                    break;
                default: return 'Chưa có điểm';
            }
        },
        scoreStatusClassText(tc){
            const status = constants.status;
            switch(tc.status){
                case status.SCORE_CHO_DUYET:
                    return 'text-primary';
                    break;
                case status.SCORE_KHONG_DUYET:
                    return 'text-danger';
                    break;
                case status.SCORE_HOAN_THANH:
                    return 'text-success';
                    break;
                case status.SCORE_DUYET:
                    return 'text-success';
                    break;
                default: return 'text-warning';
            }
        },
        canUploadProoves(tc){
            const status = constants.status;
            if(!this.currentStudyTime.end_time_class_meet || new Date(this.currentStudyTime.end_time_class_meet) < new Date()) return false;
            if(tc.status == status.SCORE_HOAN_THANH || tc.status == status.SCORE_DUYET) return false;
            const tieuChi_uploads = constants.tieuChi.TIEU_CHI_UPLOADS;
            return tieuChi_uploads.includes(tc.id_tieu_chi);
        },
        scoreButtonClassText(tc){
            const status = constants.status;
            switch(tc.status){
                case status.SCORE_CHO_DUYET:
                    return 'btn btn-primary';
                    break;
                case status.SCORE_KHONG_DUYET:
                    return 'btn btn-danger';
                    break;
                case status.SCORE_HOAN_THANH:
                    return 'btn btn-success';
                    break;
                default: return 'btn btn-warning';
            }
        },
        proofButtonText(tc){
            const status = constants.status;
            return  tc.status == status.SCORE_CHUA_CO_DIEM ? 'Gửi minh chứng' : 'Gửi lại';
        },
        uploadProofPopup(tcInfo){
            this.tcInfo = tcInfo;
            this.$nextTick(() => {
                this.$nextTick(() => {
                    $('#uploadModal').modal('show');
                });
            })
        },
        async proofUploaded(){
            this.$loading(true);
            await this.getPersonalScore().then(res => this.tcList = [...res.data]);
            this.$loading(false);
        }
    },
    async mounted(){
        this.$loading(true);
        await this.getPersonalScore().then(res => this.tcList = [...res.data]);
        this.$loading(false);
    },
}
</script>

<style scoped>
</style>
