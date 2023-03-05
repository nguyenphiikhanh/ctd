<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Đánh giá điểm rèn luyện cá nhân
                                    <span>(<small class="text-danger">{{ `${currentStudyTime.name} - năm học ${currentStudyTime.year_name}` }}</small>)</span>
                                </h3>
                                <h4>Thời gian kết thúc:
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
                                        <th scope="col">Điểm tự đánh giá</th>
                                        <th scope="col">Ghi chú</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(tc, index) in tcList">
                                        <th scope="row">{{index+1}}</th>
                                        <td>{{tc.name}}</td>
                                        <td>{{tc.max_score}}</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-control-wrap number-spinner-wrap">
                                                    <button @click="decrement(index, Number(tc.self_score) === tc.self_score && tc.self_score % 1 !== 0 ? 0.5 : 1 )" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                                    <input type="number" class="form-control number-spinner" :id="`score-spin-${index+1}`" :value="tc.self_score" @focusout="updateValue(index, $event.target.value)">
                                                    <button @click="increment(index, Number(tc.self_score) === tc.self_score && tc.self_score % 1 !== 0 ? 0.5 : 1 )" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{tc.note}}</td>
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
    },
    methods:{
        ...mapActions({
            // getStudyTime: 'studyTime/getStudyTime',
            getCurrentStudyTime: 'studyTime/getCurrentStudyTime',
            getClassMeetScore: 'classMeet/getClassMeetScore',
        }),
        updateValue(index, score){
            this.tcList[index].self_score = score;
            console.log(score);
        },
        increment(index, step) {
            this.tcList[index].self_score == this.tcList[index].max_score ? this.tcList[index].self_score : this.tcList[index].self_score += step;
        },
        decrement(index, step) {
            this.tcList[index].self_score == 0 ? 0 : this.tcList[index].self_score -= step;
        },
        convertVnTime(time){
            return time ? datetimeUtils.dateTimeVnFormat(time) : null;
        },
    },
    async mounted(){
        this.$loading(true);
        // await this.getStudyTime().then(res => {
        //     this.studyTimeList = [...res.data];
        //     this.studyTime = this.studyTimeList.reduce((max, obj) => obj.id > max ? obj.id : max, -Infinity)
        // })
        await this.getClassMeetScore(this.currentStudyTime.id).then(res => this.tcList = [...res.data]);
        this.$loading(false);
    }
}
</script>

<style scoped>
input.show-arrows::-webkit-outer-spin-button,
input.show-arrows::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input.show-arrows[type="number"] {
    -moz-appearance: textfield;
}
</style>
