<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">
                        <div class="nk-block-head nk-block-head-lg wide-sm">
                            <div class="nk-block-head-content">
                                <div class="nk-block-head-sub">
                                    <router-link :to="{name: 'NhiemVu_List'}">
                                        <a class="back-to" href="#"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a>
                                    </router-link>
                                </div>
                                <h2 class="nk-block-title fw-normal">Tạo nhiệm vụ</h2>
                                <div class="nk-block-des">
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered">
                                <div class="card-inner" v-if="user.role == roles.ROLE_BI_THU_DOAN">
                                    <h6 class="title mt-4">Loại nhiệm vụ</h6>
                                    <ul class="custom-control-group">
                                        <li v-for="(act, index) in activitiy_list" :key="index">
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="hoat_dong_choose" type="radio" :value="act.id" class="custom-control-input" name="hoat-dong" :id="`act-${index}`">
                                                <label class="custom-control-label" :for="`act-${index}`">{{act.activity_name}}</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="hoat_dong_choose" class="card-inner">
                                    <h6 class="title mb-3 mt-4">Hoạt động</h6>
                                    <ul class="custom-control-group">
                                        <li v-if="user.role == roles.ROLE_BI_THU_DOAN">
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="thao_tac" type="radio" :value="hoat_dong.PHAN_THI_OR_TIEU_BAN" class="custom-control-input" name="thao-tac" id="hd-1">
                                                <label class="custom-control-label" for="hd-1">{{ten_hoat_dong}}</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="thao_tac" type="radio" :value="hoat_dong.THONG_BAO_C0_PHAN_HOI" class="custom-control-input" name="thao-tac" id="hd-2">
                                                <label class="custom-control-label" for="hd-2">Thông báo(phản hồi)</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="thao_tac" type="radio" :value="hoat_dong.THONG_BA0_KHONG_PHAN_HOI" class="custom-control-input" name="thao-tac" id="hd-3">
                                                <label class="custom-control-label" for="hd-3">Thông báo(không phản hồi)</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="thao_tac == hoat_dong.THONG_BAO_C0_PHAN_HOI" class="card-inner">
                                    <h6 class="title mb-3 mt-4">Loại phản hồi</h6>
                                    <ul class="custom-control-group">
                                        <li>
                                            <div v-if="hoat_dong_choose == loai_hoat_dong.HOAT_DONG_NVSP" class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="loai_phan_hoi" type="radio" :value="hoat_dong.TB_GUI_DS_THAM_DU" class="custom-control-input" id="act-act">
                                                <label class="custom-control-label" for="act-act">Gửi danh sách dự thi</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="loai_phan_hoi" type="radio" :value="hoat_dong.TB_GUI_DS_THAM_GIA" class="custom-control-input" id="act-join">
                                                <label class="custom-control-label" for="act-join">Gửi danh sách tham dự(có mặt)</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="hoat_dong_choose == loai_hoat_dong.HOAT_DONG_NVSP && thao_tac == hoat_dong.PHAN_THI_OR_TIEU_BAN" class="card-inner">
                                    <h6 class="title mb-3 mt-4">Mức độ hoạt động</h6>
                                    <ul class="custom-control-group">
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="level" type="radio" :value="actLevel.KHOA" class="custom-control-input" id="lvKhoa">
                                                <label class="custom-control-label" for="lvKhoa">NVSP cấp Khoa</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="level" type="radio" :value="actLevel.TRUONG" class="custom-control-input" id="lvTruong">
                                                <label class="custom-control-label" for="lvTruong">NVSP cấp Trường</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="level" type="radio" :value="actLevel.TOA_DAM" class="custom-control-input" id="toaDam">
                                                <label class="custom-control-label" for="toaDam">Tọa đàm NVSP</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="hoat_dong_choose == loai_hoat_dong.HOAT_DONG_NVSP && thao_tac == hoat_dong.PHAN_THI_OR_TIEU_BAN && level != actLevel.TOA_DAM" class="card-inner">
                                    <h6 class="title mb-3 mt-4">Hình thức dự thi(Nếu có phần thi)</h6>
                                    <ul class="custom-control-group">
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="hinh_thuc_thi" type="radio" :value="hinh_thuc_du_thi.THI_NHOM" class="custom-control-input" id="join-gr">
                                                <label class="custom-control-label" for="join-gr">Dự thi theo nhóm</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="hinh_thuc_thi" type="radio" :value="hinh_thuc_du_thi.THI_CA_NHAN" class="custom-control-input" id="join-ps">
                                                <label class="custom-control-label" for="join-ps">Dự thi cá nhân</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
<!--                                thông tin nhiệm vụ-->
                                <div v-if="thao_tac" class="card-inner">
                                    <h5 class="title mb-4">Thông tin nhiệm vụ</h5>
                                    <div class="row g-3">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label" >Tên nhiệm vụ</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" v-model="activity_create.ten_hoat_dong" class="form-control"  placeholder="Tên nhiệm vụ" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Thời gian thực hiện</label>
                                            <div class="form-control-wrap">
                                                <div class="input-daterange date-picker-range input-group">
                                                    <div class="input-group-addon">Từ</div>
                                                    <date-picker v-model="activity_create.start_time"
                                                    :show-second="false"
                                                    :confirm="true"
                                                     format="HH:mm DD-MM-YYYY" type="datetime"
                                                     placeholder="Chọn thời gian bắt đầu"
                                                     @confirm="timeValidate()">
                                                    </date-picker>
                                                    <div class="input-group-addon">Đến</div>
                                                    <date-picker v-model="activity_create.end_time"
                                                    :show-second="false"
                                                    :confirm="true"
                                                     format="HH:mm DD-MM-YYYY" type="datetime"
                                                     placeholder="Chọn thời gian kết thúc"
                                                     @confirm="timeValidate()">
                                                    </date-picker>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="thao_tac == hoat_dong.THONG_BAO_C0_PHAN_HOI">
                                            <label class="form-label">Chọn hoạt động</label>
                                            <div class="form-control-wrap">
                                                <select v-model="hoat_dong_assign" class="form-control js-select2">
                                                    <option :value="null">Chọn hoạt động</option>
                                                    <option v-for="(option, index) in activity_responsiable_list" :key="index" :value="option.id">{{option.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Mô tả</label>
                                                <div class="form-control-wrap">
                                                    <vue-editor placeholder="Mô tả" v-model="activity_create.mota"></vue-editor>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Tài liệu kèm theo</label>
                                                <div class="form-control-wrap">
                                                    <input type="file" :key="fileKey" @change="uploadFileChange($event.target.files)" multiple class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--                                đối tượng nhận-->
                                <SetUpChildActivity @emitChange="changeDoiTuongClasses" v-if="thao_tac != null && thao_tac != hoat_dong.PHAN_THI_OR_TIEU_BAN"/>
                                <SetupTieuBanNCKH @emitChange="changeDoiTuongStudents" :start_time="activity_create.start_time" :end_time="activity_create.end_time" v-if="hoat_dong_choose == loai_hoat_dong.HOAT_DONG_NCKH && thao_tac != null && thao_tac == hoat_dong.PHAN_THI_OR_TIEU_BAN"/>
                                <div class="col-12 d-flex justify-content-center">
                                    <button v-if="isValid && isTimeValid" @click="onSaveChildActivity()" class="btn btn-primary mb-3">Tạo nhiệm vụ</button>
                                </div>
                            </div>
                            </div>
                        </div><!-- .nk-block -->
                    </div><!-- .components-preview -->
                </div>
            </div>
        </div>
</template>

<script>
import constants from "../../constants";
import datetimeUtils from "../../helpers/utils/datetimeUtils";
import SetUpChildActivity from "./authorize/giaoNv/SetUpChildActivity.vue";
import SetupTieuBanNCKH from "./authorize/giaoNv/SetupTieuBanNCKH.vue";
import {mapActions} from "vuex";
import { asyncLoading } from 'vuejs-loading-plugin';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/locale/vi'
DatePicker.locale('vi');
import { VueEditor } from "vue2-editor";
import roles from '../../constants/roles';

export default {
    components:{
      SetUpChildActivity,
      SetupTieuBanNCKH,
      DatePicker,
      VueEditor
    },
    data(){
        return{
            activity_create:{
                ten_hoat_dong : '',
                mota: '',
                start_time: '',
                end_time: '',
            },
            //todo activities
            hoat_dong_choose: null,
            thao_tac: null,
            level: constants.LEVEL.KHOA,
            loai_phan_hoi: '',
            hinh_thuc_thi: constants.HINH_THUC_THI.THI_NHOM,
            //
            activitiy_list: [],
            activity_responsiable_list: [],
            doi_tuong_classes: [],
            doi_tuong_students: [],
            hoat_dong_assign: null,
            files: [],
            fileKey: 0
        }
    },
    computed:{
        loai_hoat_dong(){
            return constants.LOAI_HOAT_DONG;
        },
        hoat_dong(){
            return constants.HOAT_DONG;
        },
        ten_hoat_dong(){
            if(this.hoat_dong_choose == 1) {
                return 'Tạo tiểu ban';
            }
            else return 'Tạo hoạt động';
        },
        isTimeValid(){
            if(this.activity_create.start_time && this.activity_create.end_time){
                const startTime = new Date(datetimeUtils.convertTimezoneToDatetime(this.activity_create.start_time));
                const endTime = new Date(datetimeUtils.convertTimezoneToDatetime(this.activity_create.end_time));
                return (startTime < endTime);
            }
            else return false;
        },
        isValid(){
            if(this.hoat_dong_choose == this.loai_hoat_dong.HOAT_DONG_NCKH && this.thao_tac == this.hoat_dong.PHAN_THI_OR_TIEU_BAN){
                return this.activity_create.ten_hoat_dong && this.activity_create.start_time && this.activity_create.end_time;
            }
            else{
                if(this.thao_tac == this.hoat_dong.PHAN_THI_OR_TIEU_BAN){
                    return this.activity_create.ten_hoat_dong
                    && this.activity_create.start_time && this.activity_create.end_time;
                }
                else if(this.thao_tac == this.hoat_dong.THONG_BAO_C0_PHAN_HOI){
                    return this.loai_phan_hoi && this.activity_create.ten_hoat_dong && this.hoat_dong_assign && this.doi_tuong_classes.length > 0
                    && this.activity_create.start_time && this.activity_create.end_time;
                }
                else {
                    return this.activity_create.ten_hoat_dong && this.doi_tuong_classes.length > 0
                    && this.activity_create.start_time && this.activity_create.end_time;
                }
            }
        },
        roles(){
            return constants.roles;
        },
        user(){
            return this.$store.getters['auth/user'];
        },
        actLevel(){
            return constants.LEVEL;
        },
        hinh_thuc_du_thi(){
            return constants.HINH_THUC_THI;
        }
    },
    methods:{
        ...mapActions({
           getActivities: 'activity/getActivities',
            storeChildActivities: 'activity/storeChildActivity',
            getActivityResponsiable: 'activity/getActivityResponsiable'
        }),
        async getActivitiyList(){
            await this.getActivities().then(res => this.activitiy_list = [...res.data]);
        },
        changeDoiTuongClasses(val){
            this.doi_tuong_classes = [...val];
        },
        changeDoiTuongStudents(val){
            this.doi_tuong_students = [...val];
        },
        async onSaveChildActivity(){
            this.$loading(true);
            let formData = new FormData();
            formData.append('activity', this.hoat_dong_choose);
            formData.append('name', this.activity_create.ten_hoat_dong);
            formData.append('action', this.thao_tac || '');
            formData.append('responseType', this.loai_phan_hoi || '');
            formData.append('level', this.level);
            formData.append('details', this.activity_create.mota);
            formData.append('start_time', this.activity_create.start_time ? datetimeUtils.convertTimezoneToDatetime(this.activity_create.start_time) : '');
            formData.append('end_time', this.activity_create.end_time ? datetimeUtils.convertTimezoneToDatetime(this.activity_create.end_time) : '');
            formData.append('id_activities_details_assign', this.hoat_dong_assign || '');
            formData.append('level', this.level);
            formData.append('join_type', this.hinh_thuc_thi);
            for(let i = 0; i < this.doi_tuong_classes.length; i++){
                formData.append('assignToClasses[]', this.doi_tuong_classes[i]);
            }
            for(let i = 0; i < this.doi_tuong_students.length; i++){
                formData.append('assignToStudents[]', this.doi_tuong_students[i]);
            }
            for(let i = 0; i < this.files.length; i++){
                let file = this.files[i];
                formData.append('files[' + i + ']', file);
            }
            await this.storeChildActivities(formData);
            this.resetForm();
            this.$loading(false);
        },
        timeValidate(){
           if(this.activity_create.start_time && this.activity_create.end_time){
            const startTime = new Date(datetimeUtils.convertTimezoneToDatetime(this.activity_create.start_time));
            const endTime = new Date(datetimeUtils.convertTimezoneToDatetime(this.activity_create.end_time));
            if(startTime > endTime){
                this.$swal.fire(
                'Vui lòng chọn thời gian hợp lệ!',
                '',
                'error'
                )
            }
           }
        },
        resetForm(){
            this.activity_create = {
                    ten_hoat_dong : '',
                    mota: '',
                    start_time: '',
                    end_time: '',
            };
            this.doi_tuong_classes = [];
            this.hoat_dong_assign = null;
            this.hinh_thuc_thi = null;
            this.doi_tuong_students = [];
            this.level = this.actLevel.KHOA;
            this.hinh_thuc_thi = this.hinh_thuc_du_thi.THI_NHOM;
            this.fileKey++;
            this.thao_tac = null;
            this.hoat_dong_choose = this.user.role == roles.ROLE_PHU_TRACH_NVSP ? this.loai_hoat_dong.HOAT_DONG_NVSP : null;
            this.files = [];
        },

        uploadFileChange(clientFiles){
            this.files = clientFiles;
        }

    },
    async mounted() {
        if(this.user.role == this.roles.ROLE_PHU_TRACH_NVSP){
            this.hoat_dong_choose = this.loai_hoat_dong.HOAT_DONG_NVSP;
        }
        await asyncLoading(this.getActivitiyList());
    },
    watch:{
        hoat_dong_choose(){
            this.thao_tac = null
            this.activity_create = {
                    ten_hoat_dong : '',
                    mota: '',
                    start_time: '',
                    end_time: '',
            };
            this.doi_tuong_classes = [];
            this.doi_tuong_students = [];
            this.level = this.actLevel.KHOA;
            this.hinh_thuc_thi = this.hinh_thuc_du_thi.THI_NHOM;
            this.hoat_dong_assign = null;
            this.fileKey++;
            this.files = [];
        },
        thao_tac(val){
            this.loai_phan_hoi = null;
            this.hoat_dong_assign = null;
            this.doi_tuong_classes = [];
            this.level = this.actLevel.KHOA;
            this.hinh_thuc_thi = this.hinh_thuc_du_thi.THI_NHOM;
            this.doi_tuong_students = [];
            this.fileKey++;
            if(val == this.hoat_dong.THONG_BAO_C0_PHAN_HOI){
                let queryParams = {
                    activity: this.hoat_dong_choose
                };
                asyncLoading(this.getActivityResponsiable(queryParams).then((res) => this.activity_responsiable_list = res.data));
            }
        },
        level(val){
            if(val == this.actLevel.TOA_DAM){
                this.hinh_thuc_thi = this.hinh_thuc_du_thi.THI_NHOM;
            }
        }
    },
}
</script>

<style scoped>

</style>
