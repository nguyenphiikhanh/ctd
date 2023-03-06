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
                                <h5 class="nk-block-title">Danh sách đánh giá</h5>
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
                                        <th scope="col">Kì học</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>{{ `${currentStudyTime.name} - năm học ${currentStudyTime.year_name}` }}</td>
                                        <td class="d-flex justify-content-end">
                                            <div>
                                                <button @click="showPopup(classInfo)" class="btn btn-sm btn-primary">
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
                    <cbCheckpointClassMeetScore :class-view="classView" :user-score-list="userScoreList"
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
import cbCheckpointClassMeetScore from "./child/CbCheckpointClassMeetScore";
import datetimeUtils from '../../helpers/utils/datetimeUtils';
export default {
    components:{
        cbCheckpointClassMeetScore,
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
            userScoreList: [],
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
        classInfo(){
            const classInf = {
                id: this.$store.getters['auth/user'].id_class,
            }
            return classInf;
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
            await this.getMeetScoreByClass(data).then(res => this.userScoreList = [...res.data]);
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
