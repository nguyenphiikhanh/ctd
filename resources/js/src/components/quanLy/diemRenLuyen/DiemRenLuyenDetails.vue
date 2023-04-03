<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Điểm rèn luyện sinh viên:
                                    <span class="text-danger">{{ studentInfo.ho + ' ' + studentInfo.ten }}</span>
                                </h3>
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
                                    <tr v-for="(tc, index) in scoreList" :key="index">
                                        <th scope="row">{{index+1}}</th>
                                        <td>{{tc.name}}</td>
                                        <td><div class="text-center">{{tc.max_score}}</div></td>
                                        <td><div class="text-center">{{tc.score}}</div></td>
                                        <td :class="scoreStatusClassText(tc)">{{scoreStatusText(tc)}}</td>
                                        <td class="text-center">{{tc.note}}</td>
                                        <td class="text-center">
                                            <button v-if="canViewProoves(tc)" class="btn btn-info"
                                            @click="onViewProof(tc.prooves)">Xem minh chứng</button>
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
                    </div><!-- nk-block -->
                </div>
                <ViewProof :prooves="prooves" @onClose="closeProofModal()"/>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import constants from '../../../constants';
import ViewProof from "./child/ViewProof.vue";
export default {
    components:{
        ViewProof
    },
    data(){
        return{
            studentInfo: {
                ho: '',
                ten: '',
            },
            scoreList: [],
            prooves: [],
        }
    },
    computed:{
        scoreSum(){
            let sum = 0;
            this.scoreList.map(_item => sum += Number(_item.score));
            return sum;
        },
    },
    methods:{
        ...mapActions({
            getStudentInfo: 'student/getStudentInfo',
            getStudentLastScore: "points/getStudentLastScore",
        }),
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
        canViewProoves(tc){
            const status = constants.status;
            if(tc.status != status.SCORE_HOAN_THANH && tc.status != status.SCORE_DUYET) return false;
            const tieuChi_uploads = constants.tieuChi.TIEU_CHI_UPLOADS;
            return tieuChi_uploads.includes(tc.id_tieu_chi);
        },
        onViewProof(prooves){
            this.prooves = prooves;
            this.$nextTick( () => {
                $('#viewProofModal').modal('show');
            });
        },
        closeProofModal(){
            this.$nextTick(() => {
                $('#viewProofModal').modal('hide');
            });
        },
    },
    async mounted(){
        this.$loading(true);
        const id_student = this.$route.params.id_student;
        await this.getStudentInfo(id_student).then(res => this.studentInfo = {...res.data});
        const params = {
            id_student: id_student,
            id_study_time: this.$route.params.id_study_time
        }
        await this.getStudentLastScore(params).then(res => this.scoreList = [...res.data]);
        this.$loading(false);
    }
}
</script>

<style>

</style>
