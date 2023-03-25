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
                                        <th scope="col">Điểm</th>
                                        <th scope="col">Ghi chú</th>
                                        <th scope="col">Hoạt động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(tc, index) in tcList" :key="index">
                                        <th scope="row">{{index+1}}</th>
                                        <td>{{tc.name}}</td>
                                        <td>{{tc.cvht_score}}</td>
                                        <td class="text-center">{{tc.note}}</td>
                                        <td class="text-center"><button class="btn btn-primary">Gửi minh chứng</button></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="3">
                                            <div class="text-center">Tổng điểm</div>
                                        </th>
                                        <th scope="row">
                                            <div class="text-center">
                                                <strong>{{selfScoreSum}}</strong>
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
export default {
    components:{
    },
    data(){
        return {
            tcList: []
        }
    },
    computed:{
        currentStudyTime(){
            return this.$store.getters['studyTime/getStudyTimeCurrent'];
        },
        selfScoreSum(){
            let sum = 0;
            this.tcList.map(_item => sum += Number(_item.self_score));
            return sum;
        }
    },
    methods:{
        ...mapActions({
            getCurrentStudyTime: 'studyTime/getCurrentStudyTime',
            getClassMeetScore: 'classMeet/getClassMeetScore',
            updatePersonClassMeetScore: 'classMeet/updatePersonClassMeetScore',
        }),
        async updateValue(index, score){
            if(score < 0 || score > this.tcList[index].max_score){
                this.$swal.fire(
                'Điểm không hợp lệ!',
                '',
                'error'
                )
            } else {
                this.tcList[index].self_score = score;
                const data = {
                    id_study_time: this.tcList[index].id_study_time,
                    id_tieu_chi: this.tcList[index].id_tieu_chi,
                    score: score,
                    person_flg: true
                }
                await this.updatePersonClassMeetScore(data);
            }
        },
        async increment(index, step) {
            this.tcList[index].self_score = Number(this.tcList[index].self_score) == Number(this.tcList[index].max_score) ?
            Number(this.tcList[index].self_score) : +this.tcList[index].self_score + step;
            await this.updateValue(index, this.tcList[index].self_score)
        },
        async decrement(index, step) {
            this.tcList[index].self_score = this.tcList[index].self_score == 0 ? 0 : +this.tcList[index].self_score - step;
            await this.updateValue(index, this.tcList[index].self_score);
        },
        convertVnTime(time){
            return time ? datetimeUtils.dateTimeVnFormat(time) : null;
        },
    },
    async mounted(){
        this.$loading(true);
        await this.getClassMeetScore(this.currentStudyTime.id).then(res => this.tcList = [...res.data]);
        this.$loading(false);
    },
}
</script>

<style scoped>
</style>
