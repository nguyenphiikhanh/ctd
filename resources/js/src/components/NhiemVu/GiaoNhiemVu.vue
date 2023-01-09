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
                                            <label class="form-label">Datepicker Range</label>
                                            <div class="form-control-wrap">
                                                <div class="input-daterange date-picker-range input-group">
                                                    <input type="text" class="form-control" />
                                                    <div class="input-group-addon">TO</div>
                                                    <input type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="cp1-profile-description">Mô tả</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control form-control-sm quill-basic" v-model="activity_create.mota" placeholder="Mô tả hoạt động"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<!--                                đối tượng nhận-->
                                <GiaoNhiemVu_Truong :class_choose="lop_choose" :is-showing="thao_tac != null && thao_tac != hoat_dong.PHAN_THI_OR_TIEU_BAN"/>
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
import GiaoNhiemVu_Truong from "./authorize/giaoNv/GiaoNhiemVu_Truong";

export default {
    components:{
      GiaoNhiemVu_Truong,
    },
    data(){
        return{
            activity_create:{
                ten_hoat_dong : '',
                mota: '',
                doi_tuong: null,
            },
            //todo activities
            hoat_dong_choose: null,
            thao_tac: null,
            //
            lop_choose: [],
            activitiy_list: [
                {
                    id: 1,
                    activity_name: 'Hoạt động Nghiên cứu Khoa học'
                },
                {
                    id: 2,
                    activity_name: 'Hoạt động Nghiệp vụ Sư phạm'
                },
                {
                    id: 3,
                    activity_name: 'Hoạt động Đoàn'
                },
                {
                    id: 4,
                    activity_name: 'Hoạt động Khác'
                }
            ],
            lop: [
                {
                    id: 1,
                    class_name: 'K69C',
                    id_faculty: 2,
                    id_class_type: 2,
                    id_term: 1
                },
                {
                    id: 1,
                    class_name: 'K69A',
                    id_faculty: 2,
                    id_class_type: 1,
                    id_term: 1
                }
            ],
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
        doi_tuong(){
            return constants.DOI_TUONG;
        },
    },
    methods:{
    },
    async mounted() {
        console.log(...this.activitiy_list);
    },
    watch:{
        hoat_dong_choose(){
            this.thao_tac = null;
        }
    },
}
</script>

<style scoped>

</style>
