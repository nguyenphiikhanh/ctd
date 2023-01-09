<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">
                        <div class="nk-block-head nk-block-head-lg wide-sm">
                            <div class="nk-block-head-content">
                                <div class="nk-block-head-sub">
                                    <router-link :to="{name: 'NhiemVu-List'}">
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
                                                <input v-model="activity.hoat_dong" type="radio" :value="act.id" class="custom-control-input" name="hoat-dong" :id="`act-${index}`">
                                                <label class="custom-control-label" :for="`act-${index}`">{{act.activity_name}}</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="activity.hoat_dong" class="card-inner">
                                    <h6 class="title mb-3 mt-4">Hoạt động</h6>
                                    <ul class="custom-control-group">
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="activity.thao_tac" type="radio" :value="hoat_dong.PHAN_THI_OR_TIEU_BAN" class="custom-control-input" name="thao-tac" id="hd-1">
                                                <label class="custom-control-label" for="hd-1">{{ten_hoat_dong}}</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="activity.thao_tac" type="radio" :value="hoat_dong.THONG_BAO_C0_PHAN_HOI" class="custom-control-input" name="thao-tac" id="hd-2">
                                                <label class="custom-control-label" for="hd-2">Thông báo(phản hồi)</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="activity.thao_tac" type="radio" :value="hoat_dong.THONG_BA0_KHONG_PHAN_HOI" class="custom-control-input" name="thao-tac" id="hd-3">
                                                <label class="custom-control-label" for="hd-3">Thông báo(không phản hồi)</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!--                                chọn đối tượng nhận-->
                                <div v-if="activity.thao_tac && activity.thao_tac != hoat_dong.PHAN_THI_OR_TIEU_BAN" class="card-inner">
                                    <h6 class="title mb-3 mt-4">Chọn đối tượng</h6>
                                    <ul class="custom-control-group">
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="activity.doi_tuong" type="radio" :value="doi_tuong.KHOA" class="custom-control-input" name="doi-tuong" id="dt-1">
                                                <label class="custom-control-label" for="dt-1">Khoa</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="activity.doi_tuong" type="radio" :value="doi_tuong.KHOI" class="custom-control-input" name="doi-tuong" id="dt-2">
                                                <label class="custom-control-label" for="dt-2">Khối</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="activity.doi_tuong" type="radio" :value="doi_tuong.KHOA_DAO_TAO" class="custom-control-input" name="doi-tuong" id="dt-3">
                                                <label class="custom-control-label" for="dt-3">Khoá</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="activity.doi_tuong" type="radio" :value="doi_tuong.LOP" class="custom-control-input" name="doi-tuong" id="dt-4">
                                                <label class="custom-control-label" for="dt-4">Cán bộ lớp</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="activity.doi_tuong == doi_tuong.KHOA" class="card-inner">
                                    <!--start:  Chọn khoa-->
                                    <h6 class="title mb-3 mt-4">Chọn khoa</h6>
                                    <div class="form-group">
                                        <div class="form-control-wrap w-50 ">
                                            <div class="form-control-select">
                                                <select v-model="khoa_choose" class="form-control" id="khoa">
                                                    <option v-for="(option, index) in khoa" :key="index" value="default_option">{{option.faculty_name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- chọn lớp trong khoa-->
                                    <template v-if="khoa_choose">
                                        <h6 class="title mb-3 mt-4">Chọn lớp</h6>
                                        <ul class="custom-control-group">
                                            <li v-for="(option, index) in lop" :key="index">
                                                <div class="custom-control custom-radio custom-control-pro no-control">
                                                    <input v-model="lop_choose" :value="option" type="checkbox" class="custom-control-input" :id="`khoa-lop-${index}`">
                                                    <label class="custom-control-label" :for="`khoa-lop-${index}`">{{option.class_name}}</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </template>

                                    <!--  end:  Chọn khoa-->
                                </div>

                                <!--                               cHỌN KHỐI-->
                                <div v-if="activity.doi_tuong == doi_tuong.KHOI" class="card-inner">
                                    <h6 class="title mb-3 mt-4">Chọn khối</h6>
                                    <div class="form-group">
                                        <div class="form-control-wrap w-50 ">
                                            <div class="form-control-select">
                                                <select v-model="khoi_choose" class="form-control" id="khoi">
                                                    <option v-for="(option, index) in khoi" :key="index" value="default_option">{{option.class_type_name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--                                Chọn khoá-->
                                <div v-if="activity.doi_tuong == doi_tuong.KHOA_DAO_TAO" class="card-inner">
                                    <h6 class="title mt-4">Chọn khoá </h6>
                                    <ul class="custom-control-group">
                                        <li v-for="(act, index) in khoa_dao_tao" :key="index">
                                            <div class="custom-control custom-radio custom-control-pro no-control">
                                                <input v-model="khoa_dao_tao_choose" type="radio" :value="act.id" class="custom-control-input" name="khoa-dao-tao" :id="`khoa-tao-tao-${index}`">
                                                <label class="custom-control-label" :for="`khoa-tao-tao-${index}`">{{act.term_name}}</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div><!-- .nk-block -->
                    </div><!-- .components-preview -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import constants from "../../constants";

export default {
    data(){
        return{
            activity:{
                ten_hoat_dong : '',
                hoat_dong: null,
                thao_tac: null,
                mota: '',
                doi_tuong: null,
            },
            khoa_choose: null,
            khoi_choose: null,
            khoa_dao_tao_choose: null,
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
            khoa:[
                {
                    id: 1,
                    faculty_name: 'Tâm lý học'
                },
                {
                    id: 2,
                    faculty_name: 'Công nghệ thông tin'
                },
            ],
            khoa_dao_tao: [
                {
                    id: 1,
                    term_name: 'K69'
                },
                {
                    id: 2,
                    term_name: 'K70'
                },
                {
                    id: 3,
                    term_name: 'K71'
                },
            ],
            khoi: [
                {
                    id: 1,
                    class_type_name: 'Sư phạm',
                },
                {
                    id: 1,
                    class_type_name: 'Ngoài Sư phạm',
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
            if(this.activity.hoat_dong == 1) {
                return 'Tạo tiểu ban';
            } else if (this.activity.hoat_dong == 2){
                return 'Tạo phần thi';
            }
            else return 'Tạo hoạt động';
        },
        validSubmit(){
            return this.activity.activity && this.activity.taskName && this.activity.action;
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
}
</script>

<style scoped>

</style>
