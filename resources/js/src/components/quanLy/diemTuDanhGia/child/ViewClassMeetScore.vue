<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="viewClassMeetScore">
        <div class="modal-dialog modal-dialog-top mw-98" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Điểm đánh giá cá nhân lớp {{classView.class_name}}</h5></div>
                <div class="modal-body">
                    <div class="form-group d-flex col-12">
                        <div class="col-6 d-flex">
                            <label class="col-form-label col-2">Chọn kỳ học</label>
                            <select class="form-control w-50" v-model="studyTime">
                                <option v-for="(time, index) in studyTimeList" :key="index" :value="time.id">{{time.name}}</option>
                            </select>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <button @click="viewTcList()" class="btn btn-outline-success">Xem tiêu chí đánh giá</button>
                        </div>
                    </div>
                    <div v-if="!awating && validScoreList" class="col-12 overflow-table">
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
                                <td style="height: 35px; width: 66px; text-align: center;">
                                    <p>{{ score.cvht_score  }}</p>
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
                <p v-if="!awating && !validScoreList" class="text-center">
                    Không có dữ liệu.
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
        studyTimeList: {type: Array}
    },
    components:{
        ViewTcList,
    },
    data(){
        return{
            awating: false,
            userScoreListClone: [],
            studyTime: null,
        }
    },
    computed:{
        validScoreList(){
            if(this.userScoreListClone.length > 0){
                const scores = this.userScoreListClone[0];
                return scores.scoreList.length > 0;
            }
            else return false;
        }
    },
    methods:{
        ...mapActions({
            getMeetScoreByClass: 'classMeet/getMeetScoreByClass'
        }),
        viewTcList(){
            this.$nextTick(() => {
                $('#viewTcList').modal('show');
            });
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
        this.studyTime = this.$store.getters['studyTime/getStudyTimeCurrent'].id;
    },
    watch:{
        async studyTime(val){
            this.awating = true;
            if(this.classView.id){
                const data = {
                    id_class: this.classView.id,
                    id_study_time: val
                }
                await this.getMeetScoreByClass(data).then(res => this.userScoreListClone = [...res.data]);
            }
            this.awating = false;
        }
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
