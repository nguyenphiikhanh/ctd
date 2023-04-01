<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Điểm rèn luyện sinh viên</h3>
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
                                                    <em class="icon ni ni-eye"></em>Xem điểm rèn luyện
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
                    <ViewScore :class-view="classView" :score-list="scoreList" :key="viewKey" :study-time-list="studyTimeList"
                    @closeModal="closeModal()"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { asyncLoading } from 'vuejs-loading-plugin';
import { mapActions } from 'vuex';
import ViewScore from "./child/ViewScore.vue";
export default {
    components:{
        ViewScore,
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
            viewKey: 1
        }
    },
    methods:{
        ...mapActions({
            getClasses: 'classes/getClasses',
            getStudyTime: 'studyTime/getStudyTime',
            getScoreByClass: "points/getScoreByClass",
        }),
        async getClassListData(){
            const params = {};
            await this.getClasses(params).then(res => this.classList = [...res.data]);
        },
        async showPopup(_class){
            this.$loading(true);
            this.classView = _class;
            let data = {
                id_class: this.classView.id,
                id_study_time: this.studyTime
            }
            await this.getScoreByClass(data).then(res => this.scoreList = [...res.data]);
            this.$loading(false);
            this.$nextTick(() => {
                $('#viewScore').modal('show');
            });
            this.viewKey++;
        },
        closeModal(){
            this.studyYear = this.studyTimeList.reduce((max, obj) => obj.id > max ? obj.id : max, -Infinity)
            this.$nextTick(() => {
                $('#viewScore').modal('hide');
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

<style>

</style>
