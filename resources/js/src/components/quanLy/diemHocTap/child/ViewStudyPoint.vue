<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="viewClassMeetScore">
        <div class="modal-dialog modal-dialog-top mw-98" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Điểm học tập lớp {{classView.class_name}}</h5></div>
                <div class="modal-body">
                    <div class="form-group d-flex col-12">
                        <div class="col-6 d-flex">
                            <label class="col-form-label col-2">Chọn kỳ học</label>
                            <select class="form-control w-50" v-model="studyTime">
                                <option v-for="(time, index) in studyTimeList" :key="index" :value="time.id">{{time.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div v-if="!awating && studyPoints.length > 0" class="col-12">
                        <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">STT</th>
                                <!-- <th scope="col">Mã sinh viên</th> -->
                                <th scope="col">Họ và tên</th>
                                <th scope="col">TBC HT10</th>
                                <th scope="col">TBC HT4</th>
                                <th scope="col">Xếp loại thang 4</th>
                                <th scope="col">Xếp loại thang 10</th>
                                <!-- <th scope="col">Số HP nợ</th> -->
                                <th scope="col">Số tín chỉ nợ</th>
                                <!-- <th scope="col">Tổng số tín chỉ đăng ký</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(point, index) in studyPoints" :key="index">
                                <th scope="row">{{ index + 1 }}</th>
                                <!-- <td>{{ point.username }}</td> -->
                                <td>{{ point.fullname }}</td>
                                <td>{{ point.ten_level_avg.toFixed(2) }}</td>
                                <td>{{ point.four_level_avg.toFixed(2) }}</td>
                                <td>{{ point.four_level_evaluate }}</td>
                                <td>{{ point.ten_level_evaluate }}</td>
                                <!-- <td>{{ point.object_in_debt }}</td> -->
                                <td>{{ point.credit_in_debt }}</td>
                                <!-- <td>{{ point.tong_so_tin_dang_ky }}</td> -->
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <p v-if="awating" class="text-center">
                    Đang lấy dữ liệu điểm...
                </p>
                <p v-if="!awating && studyPoints.length == 0" class="text-center">
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
        studyPointList: {type: Array },
        classView: {type:Object},
        studyTimeList: {type: Array}
    },
    components:{

    },
    data(){
        return{
            awating: false,
            studyTime: null,
            studyPoints: [],
        }
    },
    computed:{
    },
    methods:{
        ...mapActions({
            getStudyPoints: 'points/getStudyPoints',
        }),
        closeModal(){
            this.$emit('closeModal');
        },
    },
    mounted(){
        this.studyPoints = JSON.parse(JSON.stringify(this.studyPointList));
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
                await this.getStudyPoints(data).then(res => this.studyPoints = [...res.data]);
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
</style>
