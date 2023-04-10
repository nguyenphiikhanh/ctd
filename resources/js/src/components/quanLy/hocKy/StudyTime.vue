<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Quản lý Kì học</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <button @click="showPopup()" type="button" class="btn btn-primary d-none d-md-inline-flex">
                                                    <em class="icon ni ni-plus"></em>
                                                    <span>Thêm kì học</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Năm học hiện tại: <span class="text-danger">{{ lastestStudyYear.year_name }}</span></h5>
                                <h5 class="nk-block-title">Danh sách kì học</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Học kì</th>
                                        <th scope="col">Thời gian bắt đầu</th>
                                        <!-- <th scope="col">Thời gian kết thúc</th> -->
                                        <!-- <th scope="col">Xét điểm rèn luyện</th> -->
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in studyTimeList" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{_item.name}}</td>
                                        <td>{{time_convert(_item.start_time)}}</td>
                                        <td>{{time_convert(_item.end_time)}}</td>
                                        <!-- <td>
                                            <span :class="_item.status == status.INVALID_VALUE ? 'text-warning' : 'text-success'">
                                                {{ _item.status == status.INVALID_VALUE ? 'Chưa xét duyệt' : 'Đã xét duyệt' }}
                                            </span>
                                        </td> -->
                                        <!-- <td class="d-flex justify-content-end">
                                            <div>
                                                <button class="btn btn-sm btn-info">Xét điểm rèn luyện</button>
                                            </div>
                                        </td> -->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="studyTimeList.length == 0" class="text-center col-12">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                    <create-or-update-dialog :createFlg="createFlg" :studyTime="studyTime"
                    :current-study-year="lastestStudyYear" :study-term="studyTermList"
                    @onSave="onSave" @closeModal="closeModal()"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { asyncLoading } from 'vuejs-loading-plugin';
import { mapActions } from 'vuex';
import createOrUpdateDialog from './child/CreateOrUpdateStudyTime.vue';
import datetimeUtils from "../../../helpers/utils/datetimeUtils";
import constants from '../../../constants';
export default {
    components:{
        createOrUpdateDialog,
    },
    data(){
        return{
            studyTimeList: [],
            studyTermList: [],
            createFlg: true,
            studyTime: {
                id: null,
                id_study_year: null,
                id_study_term: null,
                start_time: '',
                end_time: '',
            },
            lastestStudyYear: {}
        }
    },
    computed:{
        status(){
            return constants.BOOL_VALUE;
        }
    },
    methods:{
        ...mapActions({
            getLastestStudyYear: 'studyYear/getLastestStudyYear',
            getStudyTimes: 'studyTime/getStudyTime',
            getStudyTerms: 'studyTime/getStudyTerm',
        }),
        async getStudyTimeList(){
            await this.getStudyTimes().then(res => this.studyTimeList = [...res.data]);
        },
        showPopup(createFlg = true, studyTime = {}){
            if(!createFlg){
                this.createFlg = createFlg;
                this.studyTime = studyTime;
            }
            this.$nextTick(() => {
                $('#createOrUpdateDialog').modal('show');
            });
        },
        async onSave(createFlg){
            if(createFlg){
                await this.getStudyTimeList();
            }
            else{
            }
            this.$loading(false);
            this.closeModal();
            await asyncLoading(this.getStudyTimeList());
        },
        time_convert(tz = null){
            return tz ? datetimeUtils.dateTimeVnFormat(tz) : '';
        },
        closeModal(){
            this.$nextTick(() => {
                this.createFlg = true;
                this.studyTime = {
                    id: null,
                    id_study_year: null,
                    id_study_term: null,
                    start_time: '',
                    end_time: '',
                }
                $('#createOrUpdateDialog').modal('hide');
            });
        }
    },
    async mounted(){
        this.$loading(true);
        await this.getStudyTimeList();
        await this.getLastestStudyYear().then(res => {
            this.lastestStudyYear = {...res.data};
            this.studyTime.id_study_year = this.lastestStudyYear.id;
        });
        await this.getStudyTerms().then(res => this.studyTermList = [...res.data]);
        this.$loading(false);
    }
}
</script>

<style>

</style>
