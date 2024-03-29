<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Quản lý điểm học tập</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="d-flex justify-content-end">
                                    <input type="file" accept=".xlsx, .xls, .xlsm" class="d-none" @change="uploadStudyPoint($event.target.files)" ref="studyPointFile">
                                    <button @click="$refs.studyPointFile.click()" class="btn btn-lg btn-info">
                                        <em class="icon ni ni-upload"></em>
                                        {{ fileTitle }}</button>
                                    <button class="btn btn-lg btn-success ml-10px"
                                    v-if="validUpload"
                                    @click="storeStudyPoints()">
                                        <em class="icon ni ni-send-alt"></em>
                                        Cập nhật</button>
                                </div>
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
                                                    <em class="icon ni ni-eye"></em>Xem điểm học tập
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
                    <ViewStudyPoint :study-point-list="studyPoints" :class-view="classView"
                     :key="viewKey"
                     :study-time-list="studyTimeList"
                     @closeModal="closeModal()"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { asyncLoading } from 'vuejs-loading-plugin';
import { mapActions } from 'vuex';
import ViewStudyPoint from "./child/ViewStudyPoint.vue";
import datetimeUtils from '../../../helpers/utils/datetimeUtils';
export default {
    components:{
        ViewStudyPoint,
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
            studyPoints: [],
            studyTimeList: [],
            studyTime: null,
            viewKey: 1,
            studyPointFiles: [],
        }
    },
    computed:{
        validUpload(){
            return this.studyPointFiles.length;
        },
        fileTitle(){
            return this.studyPointFiles.length == 0 ? 'Cập nhật điểm' : this.studyPointFiles[0].name;
        }
    },
    methods:{
        ...mapActions({
            getClasses: 'classes/getClasses',
            getStudyTime: 'studyTime/getStudyTime',
            getStudyPoints: 'points/getStudyPoints',
            storeStudypoints: 'points/storeStudypoints',
        }),
        uploadStudyPoint(studyPointFiles){
            this.studyPointFiles = [...studyPointFiles];
        },
        async storeStudyPoints(){
            this.$loading(true);
            let formData = new FormData();
            formData.append('file', this.studyPointFiles[0]);
            await this.storeStudypoints(formData);
            this.studyPointFiles = [];
            this.$loading(false);
        },
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
            await this.getStudyPoints(data).then(res => this.studyPoints = [...res.data]);
            this.$loading(false);
            this.$nextTick(() => {
                $('#viewClassMeetScore').modal('show');
            });
            this.viewKey++;
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
        this.viewKey++;
    }
}
</script>

<style scoped>
.ml-10px{
    margin-left: 10px;
}
</style>
