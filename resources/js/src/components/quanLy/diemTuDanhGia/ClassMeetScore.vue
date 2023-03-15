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
                                    <div class="dropdown">
                                        <button v-if="currentStudyTime.end_time_class_meet && new Date(currentStudyTime.end_time_class_meet) < new Date()"
                                            id="dropdownReopenTimeButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            class="btn btn-sm btn-success dropdown-toggle">
                                            <em class="icon ni ni-curve-up-left"></em>Mở lại
                                        </button>
                                        <button v-else-if="!currentStudyTime.end_time_class_meet" @click="updateClassMeet(reOpenTime.THIRTY_DAYS)"
                                            class="btn btn-sm btn-success">
                                            <em class="icon ni ni-plus-c"></em>Mở
                                        </button>
                                        <button v-else class="btn btn-sm btn-danger" @click="updateClassMeet()">
                                            <em class="icon ni ni-cross-circle"></em>Kết thúc
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownReopenTimeButton">
                                            <a class="dropdown-item" href="#" @click="updateClassMeet(reOpenTime.ONE_HOUR)">1 giờ</a>
                                            <a class="dropdown-item" href="#" @click="updateClassMeet(reOpenTime.SIX_HOUR)">6 giờ</a>
                                            <a class="dropdown-item" href="#" @click="updateClassMeet(reOpenTime.ONE_DAY)">24 giờ</a>
                                            <a class="dropdown-item" href="#" @click="updateClassMeet(reOpenTime.THREE_DAY)">3 ngày</a>
                                            <a class="dropdown-item" href="#" @click="updateClassMeet(reOpenTime.ONE_WEEK)">7 ngày</a>
                                            <a class="dropdown-item" href="#" @click="updateClassMeet(reOpenTime.THIRTY_DAYS)">30 ngày</a>
                                        </div>

                                    </div>
                                </h4>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Danh sách lớp</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
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
                                                    <em class="icon ni ni-eye"></em>Xem đánh giá
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="classList.length == 0" class="text-center col-12 mt-5">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                    <ViewClassMeetScore :user-score-list="userScoreList" :class-view="classView"
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
import ViewClassMeetScore from "./child/ViewClassMeetScore.vue";
import datetimeUtils from '../../../helpers/utils/datetimeUtils';
import constants from '../../../constants';
export default {
    components:{
        ViewClassMeetScore,
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
        reOpenTime(){
            return constants.timeReopen;
        }
    },
    methods:{
        ...mapActions({
            getClasses: 'classes/getClasses',
            getStudyTime: 'studyTime/getStudyTime',
            getCurrentStudyTime: 'studyTime/getCurrentStudyTime',
            updateFacultyTimeSetting: 'studyTime/updateFacultyTimeSetting',
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
        async updateClassMeet(hours = 0){
            Date.prototype.addHours = function(h){
                this.setHours(this.getHours()+h);
                return this;
            }
            const endTimeMeet = datetimeUtils.convertTimezoneToDatetime(new Date().addHours(hours));
            this.$loading(true);
            const data = {
                id: this.currentStudyTime.id,
                end_time_class_meet: endTimeMeet
            }
            await this.updateFacultyTimeSetting(data);
            await this.getCurrentStudyTime();
            this.$loading(false);
        },
        closeModal(){
            this.studyTime = this.studyTimeList.reduce((max, obj) => obj.id > max ? obj.id : max, -Infinity)
            this.$nextTick(() => {
                $('#viewClassMeetScore').modal('hide');
            });
        },
    },
    async mounted(){
        asyncLoading(this.getClassListData());
        await this.getStudyTime().then(res => {
            this.studyTimeList = [...res.data];
            this.studyTime = this.studyTimeList.reduce((max, obj) => obj.id > max ? obj.id : max, -Infinity)
        })
        await this.getListTcSelf().then(res => this.tcList = [...res.data]);
        this.viewKey++;
    }
}
</script>

<style>

</style>
