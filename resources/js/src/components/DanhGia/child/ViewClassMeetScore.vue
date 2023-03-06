<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="viewClassMeetScore">
        <div class="modal-dialog modal-dialog-top mw-98" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Điểm đánh giá cá nhân lớp {{classView.class_name}}</h5></div>
                <div class="modal-body">
                    <div class="form-group d-flex justify-content-start col-10">
                        <label class="col-form-label col-1">Chọn kỳ học</label>
                        <select class="form-control w-20" v-model="studyTime">
                            <option v-for="(time, index) in studyTimeList" :key="index" :value="time.id">{{time.name}}</option>
                        </select>
                        <button class="btn btn-outline-success end_item">Xem tiêu chí đánh giá</button>
                    </div>
                    <div class="col-12 overflow-table">
                        <table class="table table-bordered table-responsive table-responsive-sm">
                            <thead class="table-header">
                            <tr>
                                <th scope="col" colspan="2"></th>
                                <!-- <th v-for="(tc,i) in tcList" :key="i">{{ tc.name }}</th> -->
                                <th v-for="(tc,i) in tcList" :key="i">{{ `Tiêu chí ${i+1}` }}</th>
                            </tr>
                            </thead>
                            <tbody v-if="!awating">
                            <tr v-for="(item,index) in tcList" :key="index+1">
                                <th scope="row" colspan="2">Nguyễn Phi Khánh(695105064)</th>
                                <td v-for="(tc,i) in tcList" :key="i">Khanhdz</td>
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
        studyTimeList: {type: Array},
        tcList: {type: Array},
    },
    data(){
        return{
            awating: false,
            studyTimeListShow: [],
            scoreListShow: this.scoreList,
            studyTime: null,
        }
    },
    methods:{
        ...mapActions({
            getNvspPointByStudyYear: "points/getNvspPointByStudyYear"
        }),
        closeModal(){
            this.studyTime = this.studyTimeList.reduce((max, obj) => obj.id > max ? obj.id : max, -Infinity);
            this.$emit('closeModal');
        },
    },
    computed: {
    },
    watch:{
        async studyTime(val){
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
        this.studyTime = this.studyTimeList.reduce((max, obj) => obj.id > max ? obj.id : max, -Infinity).id;
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
