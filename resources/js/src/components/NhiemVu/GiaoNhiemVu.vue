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
                                <div class="card-inner">
                                    <h6 class="title mt-4">Loại nhiệm vụ </h6>
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
                                        <li>
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
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="loai_phan_hoi" type="radio" :value="hoat_dong.TB_GUI_DS_THAM_DU" class="custom-control-input" id="act-act">
                                                <label class="custom-control-label" for="act-act">Gửi danh sách dự thi</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="loai_phan_hoi" type="radio" :value="hoat_dong.TB_GUI_DS_THAM_GIA" class="custom-control-input" id="act-join">
                                                <label class="custom-control-label" for="act-join">Gửi danh sách tham gia</label>
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
                                                    <date-picker v-model="activity_create.start_time" :show-second="false" format="HH:mm DD-MM-YYYY" type="datetime"></date-picker>
                                                    <div class="input-group-addon">Đến</div>
                                                    <date-picker v-model="activity_create.end_time" :show-second="false" format="HH:mm DD-MM-YYYY" type="datetime"></date-picker>
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
                                                    <input type="file" ref="fileUpload" @change="uploadFileChange($event.target.files)" multiple class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--                                đối tượng nhận-->
                                <GiaoNhiemVu_Truong :class-choose="doi_tuong" @emitChange="changeDoiTuong" v-if="thao_tac != null && thao_tac != hoat_dong.PHAN_THI_OR_TIEU_BAN"/>

                                <div class="col-12 d-flex justify-content-center">
                                    <button v-if="isValid" @click="onSaveChildActivity()" class="btn btn-primary mb-3">Tạo nhiệm vụ</button>
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
import GiaoNhiemVu_Truong from "./authorize/giaoNv/GiaoNhiemVu_Truong";
import {mapActions} from "vuex";
import { asyncLoading } from 'vuejs-loading-plugin';
import DatePicker from 'vue2-datepicker';
import { VueEditor } from "vue2-editor";

export default {
    components:{
      GiaoNhiemVu_Truong,
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
            loai_phan_hoi: '',
            //
            activitiy_list: [],
            activity_responsiable_list: [],
            doi_tuong: [],
            hoat_dong_assign: null,
            files: [],
        }
    },
    computed:{
        hoat_dong(){
            return constants.HOAT_DONG;
        },
        ten_hoat_dong(){
            if(this.hoat_dong_choose == 1) {
                return 'Tạo tiểu ban';
            } else if (this.hoat_dong_choose == 2){
                return 'Tạo phần thi';
            }
            else return 'Tạo hoạt động';
        },
        isValid(){
            if(this.thao_tac == this.hoat_dong.PHAN_THI_OR_TIEU_BAN){
                return this.activity_create.ten_hoat_dong;
            }
            else if(this.thao_tac == this.hoat_dong.THONG_BAO_C0_PHAN_HOI){
                return this.loai_phan_hoi && this.activity_create.ten_hoat_dong && this.hoat_dong_assign && this.doi_tuong.length > 0;
            }
            else {
                return this.activity_create.ten_hoat_dong && this.doi_tuong.length > 0;
            }
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
        changeDoiTuong(val){
            this.doi_tuong = [...val];
        },
        async onSaveChildActivity(){
            this.$loading(true);
            let formData = new FormData();
            formData.append('activity', this.hoat_dong_choose);
            formData.append('name', this.activity_create.ten_hoat_dong);
            formData.append('action', this.thao_tac || '');
            formData.append('responseType', this.loai_phan_hoi || '');
            formData.append('details', this.activity_create.mota);
            formData.append('start_time', this.activity_create.start_time ? datetimeUtils.convertTimezoneToDatetime(this.activity_create.start_time) : '');
            formData.append('end_time', this.activity_create.end_time ? datetimeUtils.convertTimezoneToDatetime(this.activity_create.end_time) : '');
            formData.append('assignChildActivity', this.hoat_dong_assign || '');
            for(let i = 0; i < this.doi_tuong.length; i++){
                formData.append('assignTo[]', this.doi_tuong[i]);
            }
            for(let i = 0; i < this.files.length; i++){
                let file = this.files[i];
                formData.append('files[' + i + ']', file);
            }
            await this.storeChildActivities(formData);
            this.resetForm();
            this.$loading(false);
        },
        resetForm(){
            this.activity_create = {
                    ten_hoat_dong : '',
                    mota: '',
                    start_time: '',
                    end_time: '',
            };
            this.$refs.fileUpload.value = null;
            this.hoat_dong_choose = null;
            this.files = [];
        },

        uploadFileChange(clientFiles){
            this.files = clientFiles;
        }

    },
    async mounted() {
        await asyncLoading(this.getActivitiyList());
    },
    watch:{
        hoat_dong_choose(){
            this.thao_tac = null;
        },
        thao_tac(val){
            this.loai_phan_hoi = null;
            if(val == this.hoat_dong.THONG_BAO_C0_PHAN_HOI){
                let queryParams = {
                    activity: this.hoat_dong_choose
                };
                asyncLoading(this.getActivityResponsiable(queryParams).then((res) => this.activity_responsiable_list = res.data));
            }
        }
    },
}
</script>

<style scoped>

</style>
