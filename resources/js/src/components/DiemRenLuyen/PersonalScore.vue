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
                                <h5 class="nk-block-title">Đánh giá</h5>
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
                                        <td class="text-center"><button v-if="canUploadProoves(tc)" class="btn btn-primary">Gửi minh chứng</button></td>
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
export default {
    components:{
    },
    data(){
        return {
            tcList: [],
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
                    return 'Đã hoàn thành';
                    break;
                default: return 'Chưa có điểm';
            }
        },
        scoreStatusClassText(tc){
            const status = constants.status;
            switch(tc.status){
                case status.SCORE_CHO_DUYET:
                    return 'text-info';
                    break;
                case status.SCORE_KHONG_DUYET:
                    return 'text-danger';
                    break;
                case status.SCORE_HOAN_THANH:
                    return 'text-primary';
                    break;
                default: return 'text-warning';
            }
        },
        canUploadProoves(tc){
            const tieuChi_uploads = constants.tieuChi.TIEU_CHI_UPLOADS;
            return tieuChi_uploads.includes(tc.id_tieu_chi);
        }
    },
    async mounted(){
        this.$loading(true);
        await this.getPersonalScore().then(res => this.tcList = [...res.data]);;
        this.$loading(false);
    },
}
</script>

<style scoped>
</style>
