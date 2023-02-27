<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewPoint">
        <div class="modal-dialog modal-dialog-top mw-70" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Điểm rèn luyện nghiệp vụ Sư phạm lớp {{classView.class_name}}</h5></div>
                <div class="modal-body">
                    <div class="form-group d-flex justify-content-start">
                        <label class="col-form-label col-1">Chọn năm học</label>
                        <select class="form-control w-20" v-model="studyYear">
                            <option v-for="(year, index) in studyYearList" :key="index" :value="year.id">{{year.year_name}}</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Mã sinh viên</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Điểm cụ thể</th>
                                <th scope="col">Xếp loại</th>
                                <th scope="col">Hình thức thi</th>
                                <th scope="col">Ghi chú</th>
                            </tr>
                            </thead>
                            <tbody v-if="!awating">
                            <tr v-for="(_item, index) in scoreListShow" :key="index">
                                <th scope="row">{{index + 1}}</th>
                                <td>{{_item.username}}</td>
                                <td>{{_item.fullname}}</td>
                                <td>{{_item.level_text}}</td>
                                <td>{{_item.level}}</td>
                                <td>{{_item.join_type}}</td>
                                <td>{{_item.note}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <p v-if="awating" class="text-center">
                    Đang lấy dữ liệu điểm...
                </p>
                <p v-if="scoreListShow.length == 0 && !awating" class="text-center">
                    Không có dữ liệu.
                </p>
                <div class="modal-footer d-flex justify-content-center">
                    <button @click="closeModal()" class="btn btn-primary">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    props:{
        scoreList: {type: Array },
        classView: {type:Object},
        studyYearList: {type: Array},
    },
    data(){
        return{
            awating: false,
            studyYearListShow: [],
            scoreListShow: this.scoreList,
            studyYear: null,
        }
    },
    methods:{
        ...mapActions({
            getNvspPointByStudyYear: "points/getNvspPointByStudyYear"
        }),
        closeModal(){
            this.studyYear = this.studyYearList.reduce((max, obj) => obj.id > max ? obj.id : max, -Infinity);
            this.$emit('closeModal');
        },
    },
    computed: {
    },
    watch:{
        async studyYear(val){
            this.awating = true;
            let data = {
                id_class: this.classView.id,
                id_study_year: val
            }
            await this.getNvspPointByStudyYear(data).then(res => this.scoreListShow = [...res.data]);
            this.awating = false;
        }
    },
    mounted() {
        this.studyYear = this.studyYearList.reduce((max, obj) => obj.id > max ? obj.id : max, -Infinity);
    }
};
</script>

<style scoped>
.mw-70{
    min-width: 70%;
}
</style>
