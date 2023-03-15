<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="viewClassMeetScore">
        <div class="modal-dialog modal-dialog-top mw-98" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
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
                        <div class="col-6 d-flex justify-content-end">
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
                    </div>
                    <div v-if="!awating && studyPoints.length > 0" class="col-12">
                        <table class="table table-bordered" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Mã sinh viên</th>
                                <th scope="col">Họ và tên</th>
                                <th scope="col">TBC HT10</th>
                                <th scope="col">TBC HT4</th>
                                <th scope="col">Xếp loại thang 4</th>
                                <th scope="col">Xếp loại thang 10</th>
                                <th scope="col">Số HP nợ</th>
                                <th scope="col">Số tín chỉ nợ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>@mdo</td>
                                <td>@mdo</td>
                                <td>@mdo</td>
                                <td>@mdo</td>
                                <td>@mdo</td>
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
            getMeetScoreByClass: 'classMeet/getMeetScoreByClass',
            storeStudypoints: 'points/storeStudypoints',
        }),
        uploadStudyPoint(studyPointFiles){
            this.studyPointFiles = [...studyPointFiles];
        },
        async storeStudyPoints(){
            this.$nextTick(() => {
                $('#viewClassMeetScore').modal('hide');
            });
            this.$loading(true);
            let formData = new FormData();
            formData.append('file', this.studyPointFiles[0]);
            await this.storeStudypoints(formData);
            this.$loading(false);
        },
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
.ml-10px{
    margin-left: 10px;
}
</style>
