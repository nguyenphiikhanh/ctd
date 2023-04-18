<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="viewClassMeetScore">
        <div class="modal-dialog modal-dialog-top mw-98" role="document">
            <div class="modal-content">
                <a @click="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Điểm đánh giá cá nhân lớp {{classView.class_name}}</h5></div>
                <div class="modal-body">
                    <div class="form-group d-flex justify-content-start col-10">
                        <button @click="viewTcList()" class="btn btn-outline-success end_item">Xem tiêu chí đánh giá</button>
                    </div>
                    <div class="col-12 overflow-table">
                        <table style="width: auto;" class="table table-bordered" cellspacing="0">
                        <tbody>
                            <template v-for="(user, userIndex) in userScoreListClone">
                            <tr style="height: 35px;">
                                <td style="height: 140px; width: 243px;" rowspan="4">
                                    <p><strong>{{ user.ho + ' ' + user.ten + `(${user.username})` }}</strong></p>
                                </td>
                                <template v-for="(score, scoreIndex) in user.scoreList">
                                    <td style="height: 35px; width: 371px; text-align: center;" colspan="3">
                                    <p><strong>Ti&ecirc;u ch&iacute; {{ scoreIndex + 1 }}</strong></p>
                                </td>
                                </template>
                            </tr>
                            <tr style="height: 35px;">
                                <template v-for="(score, scoreIndex) in user.scoreList">
                                    <td style="height: 35px; width: 371px; text-align: center;" colspan="3">
                                    <p><strong>Điểm đ&aacute;nh gi&aacute; của</strong></p>
                                </td>
                                </template>
                            </tr>
                            <tr style="height: 35px;">
                                <template v-for="(score, scoreIndex) in user.scoreList">
                                    <td style="height: 35px; width: 66px; text-align: center;">
                                        <p>SV</p>
                                    </td>
                                    <td style="height: 35px; width: 66px; text-align: center;">
                                        <p>Lớp</p>
                                    </td>
                                    <td style="height: 35px; width: 239px; text-align: center;">
                                        <p>CVHT</p>
                                    </td>
                                </template>
                            </tr>
                            <tr style="height: 35px;">
                                <template v-for="(score, scoreIndex) in user.scoreList">
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p>{{ score.self_score }}</p>
                                </td>
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p>{{ score.cbl_score  }}</p>
                                </td>
                                <td style="height: 35px; width: 239px; text-align: center;">
                                    <div class="form-group" style="width: 150px;">
                                        <div class="form-control-wrap number-spinner-wrap">
                                            <button @click="decrement(userIndex, scoreIndex, Number(score.max_score) === score.max_score && score.max_score % 1 !== 0 ? 0.5 : 1 )" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                            <input type="number" class="form-control number-spinner"
                                            :id="`${generateUid()}`"
                                            :min="0"
                                            :max="score.max_score"
                                            :value="score.cvht_score"
                                            @change="updateValue(userIndex, scoreIndex, $event.target.value)">
                                            <button @click="increment(userIndex, scoreIndex, Number(score.max_score) === score.max_score && score.max_score % 1 !== 0 ? 0.5 : 1 )" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></button>
                                        </div>
                                    </div>
                                </td>
                                </template>
                            </tr>
                            </template>
                        </tbody>
                        </table>
                    </div>
                </div>
                <p v-if="awating" class="text-center">
                    Đang lấy dữ liệu điểm...
                </p>
                <div class="modal-footer d-flex justify-content-center">
                    <button @click="closeModal()" class="btn btn-primary">Đóng</button>
                </div>
            </div>
            <ViewTcList :tcList="tcList"/>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import ViewTcList from './ViewTcList.vue';
export default {
    props:{
        userScoreList: {type: Array },
        classView: {type:Object},
        tcList: {type: Array},
    },
    components:{
        ViewTcList,
    },
    data(){
        return{
            awating: false,
            userScoreListClone: [],
        }
    },
    methods:{
        ...mapActions({
            updatePersonClassMeetScore: 'classMeet/updatePersonClassMeetScore',
        }),
        viewTcList(){
            this.$nextTick(() => {
                $('#viewTcList').modal('show');
            });
        },
        async updateValue(userIndex, scoreIndex, score){
            let scores = this.userScoreListClone[userIndex].scoreList;
            let originScore = scores[scoreIndex];
            if(score < 0 || score > originScore.max_score){
                this.$swal.fire(
                'Điểm không hợp lệ!',
                '',
                'error'
                )
            } else {
                originScore.cvht_score = score;
                const data = {
                    id_study_time: originScore.id_study_time,
                    id_tieu_chi: originScore.id_tieu_chi,
                    id_user: originScore.id_user,
                    score: score
                }
                await this.updatePersonClassMeetScore(data);
            }
        },
        async increment(userIndex, scoreIndex, step) {
            let scores = this.userScoreListClone[userIndex].scoreList;
            let originScore = scores[scoreIndex];
            originScore.cvht_score = Number(originScore.cvht_score) == Number(originScore.max_score) ?
            Number(originScore.cvht_score) : +originScore.cvht_score + step;
            await this.updateValue(userIndex, scoreIndex, originScore.cvht_score)
        },
        async decrement(userIndex, scoreIndex, step) {
            let scores = this.userScoreListClone[userIndex].scoreList;
            let originScore = scores[scoreIndex];
            originScore.cvht_score = originScore.cvht_score == 0 ? 0 : +originScore.cvht_score - step;
            await this.updateValue(userIndex, scoreIndex, originScore.cvht_score);
        },
        generateUid() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        },
        closeModal(){
            this.$emit('closeModal');
        },
    },
    mounted(){
        this.userScoreListClone = JSON.parse(JSON.stringify(this.userScoreList));
    }
};
</script>

<style scoped>
.mw-98{
    min-width: 98%;
}
.overflow-table{
    overflow: auto;
    max-width: 100%;
    max-height: 500px;
}
.table-header th{
    position: sticky;
    top: 0;
    background-color: #97dfe8;
}
</style>
