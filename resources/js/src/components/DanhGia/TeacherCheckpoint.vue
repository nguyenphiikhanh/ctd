<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Điểm rèn luyện đánh giá cá nhân theo lớp
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
                                <h5 class="nk-block-title">Danh sách lớp cố vấn</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="text-center mt-3" v-if="!currentStudyTime.end_time_class_meet || new Date(currentStudyTime.end_time_class_meet) < new Date()">
                                <span class="text-center">Kỳ đánh giá đã kết thúc hoặc chưa diễn ra.</span>
                            </div>
                            <div class="table-responsive" v-else>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên lớp</th>
                                        <th scope="col">Khối</th>
                                        <th scope="col">Khóa đào tạo</th>
                                        <th scope="col">Số lượng sinh viên</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in classList" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{_item.class_name}}</td>
                                        <td>{{_item.type_name}}</td>
                                        <td>{{_item.term_name}}</td>
                                        <td>{{_item.student_count}}</td>
                                        <td class="d-flex justify-content-end">
                                            <div>
                                                <button @click="showPopup(_item)" class="btn btn-sm btn-primary">
                                                    <em class="icon ni ni-check-round-cut"></em>Đánh giá
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                    </div><!-- nk-block -->
                    <CheckpointClassMeetScore :class-view="classView" :score-list="scoreList"
                     :key="viewKey" :tc-list="tcList"
                     @closeModal="closeModal()"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { asyncLoading } from 'vuejs-loading-plugin';
import { mapActions } from 'vuex';
import CheckpointClassMeetScore from "./child/CheckpointClassMeetScore.vue";
import constants from '../../constants';
import datetimeUtils from '../../helpers/utils/datetimeUtils';
export default {
    components:{
        CheckpointClassMeetScore,
    },
    data(){
        return{
            classList: [],
            classView:{
                id: null,
                class_name: '',
                id_class_type: null,
                id_faculty: null,
                id_term: null,
                id_user_cvht: null,
            },
            scoreList: [],
            studyTimeList: [],
            studyTime: null,
            viewKey: 1,
            tcList: [],
        }
    },
    computed:{
        currentStudyTime(){
            return this.$store.getters['studyTime/getStudyTimeCurrent'];
        },
        reOpenTime(){
            return constants.timeReopen;
        }
    },
    methods:{
        ...mapActions({
            getClasses: 'classes/getClasses',
            getListTcSelf: 'tieuChi/getListTcSelf',
            getMeetScoreByClass: 'classMeet/getMeetScoreByClass'
        }),
        async getClassListData(){
            const params = {};
            await this.getClasses(params).then(res => this.classList = [...res.data]);
        },
        convertVnTime(time){
            return time ? datetimeUtils.dateTimeVnFormat(time) : null;
        },
        async showPopup(_class){
            this.$loading(true);
            this.classView = _class;
            let data = {
                id_class: this.classView.id,
                id_study_time: this.$store.getters['studyTime/getStudyTimeCurrent'].id
            }
            await this.getMeetScoreByClass(data).then(res => this.scoreList = [...res.data]);
            this.$loading(false);
            this.$nextTick(() => {
                $('#viewClassMeetScore').modal('show');
            });
            this.viewKey++;
        },
        closeModal(){
            this.$nextTick(() => {
                $('#viewClassMeetScore').modal('hide');
            });
        },
    },
    async mounted(){
        asyncLoading(this.getClassListData());
        await this.getListTcSelf().then(res => this.tcList = [...res.data]);
        this.viewKey++;
    }
}
</script>

<style>

</style>
