<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">
                        <div class="nk-block-head nk-block-head-lg wide-sm">
                            <div class="nk-block-head-content">
                                <div class="nk-block-head-sub"><a class="back-to" href="/nhiem-vu"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>
                                <h2 class="nk-block-title fw-normal">Tạo nhiệm vụ</h2>
                                <div class="nk-block-des">
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered">
                                <form class="nk-stepper stepper-init is-alter nk-stepper-s1" action="#" id="stepper-create-profile">
                                    <div class="row g-0 col-sep col-sep-md col-sep-xl">
                                        <div class="col-md-8 col-xl-8">
                                            <div class="card-inner">
                                                <div class="nk-stepper-content">
                                                    <div class="nk-stepper-steps stepper-steps">
                                                        <div class="nk-stepper-step">
                                                            <h5 class="title mb-3">Chọn loại nhiệm vụ</h5>
                                                            <ul class="row g-5">
                                                                <li v-for="(act,index) in activitiy_list" :key="index" class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                                        <input type="radio" v-model="activity.activity" class="custom-control-input" name="cp1-profile-type" :id="`cp${index}`" :value="act.id" required>
                                                                        <label class="custom-control-label" :for="`cp${index}`">
                                                                                        <span class="d-flex flex-column text-center px-sm-3">
                                                                                            <em class="icon icon-circle icon-circle-lg bg-teal ni ni-task"></em>
                                                                                            <span class="lead-text mb-1 mt-3">{{act.activity_name}}</span>
                                                                                        </span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="nk-stepper-step">
                                                            <h5 class="title mb-3">Chọn hoạt động</h5>
                                                            <ul class="row g-5">
                                                                <li v-if="activity.activity == 1" class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                                        <input type="radio" v-model="activity.action" :value="actionType.NOTIFICATION_JOIN" class="custom-control-input" name="tb1-profile-type" id="tb1-profile-personal" required>
                                                                        <label class="custom-control-label" for="tb1-profile-personal">
                                                                                        <span class="d-flex flex-column text-center px-sm-3">
                                                                                            <em class="icon icon-circle icon-circle-lg bg-teal ni ni-todo"></em>
                                                                                            <span class="lead-text mb-1 mt-3">Tạo tiểu ban</span>
                                                                                        </span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li v-else-if="activity.activity == 2" class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                                        <input type="radio" v-model="activity.action" :value="actionType.NOTIFICATION_JOIN" class="custom-control-input" name="tb1-profile-type" id="tb1-profile-personal" required>
                                                                        <label class="custom-control-label" for="tb1-profile-personal">
                                                                                        <span class="d-flex flex-column text-center px-sm-3">
                                                                                            <em class="icon icon-circle icon-circle-lg bg-teal ni ni-todo"></em>
                                                                                            <span class="lead-text mb-1 mt-3">Tạo phần thi</span>
                                                                                        </span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li v-else class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                                        <input type="radio" v-model="activity.action" :value="actionType.NOTIFICATION_JOIN" class="custom-control-input" name="tb1-profile-type" id="tb1-profile-personal" required>
                                                                        <label class="custom-control-label" for="tb1-profile-personal">
                                                                                        <span class="d-flex flex-column text-center px-sm-3">
                                                                                            <em class="icon icon-circle icon-circle-lg bg-teal ni ni-todo"></em>
                                                                                            <span class="lead-text mb-1 mt-3">Tạo hoạt động</span>
                                                                                        </span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                                        <input type="radio" v-model="activity.action" :value="actionType.NOTIFICATION_VIEW" class="custom-control-input" name="tb1-profile-type" id="tb2-profile-personal" required>
                                                                        <label class="custom-control-label" for="tb2-profile-personal">
                                                                                        <span class="d-flex flex-column text-center px-sm-3">
                                                                                            <em class="icon icon-circle icon-circle-lg bg-teal ni ni-bell"></em>
                                                                                            <span class="lead-text mb-1 mt-3">Thông báo(Có phản hồi)</span>
                                                                                        </span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                                        <input type="radio" v-model="activity.action" :value="actionType.NOTIFICATION_NOT_RESPONSE" class="custom-control-input" name="tb1-profile-type" id="tb3-profile-personal" required>
                                                                        <label class="custom-control-label" for="tb3-profile-personal">
                                                                                        <span class="d-flex flex-column text-center px-sm-3">
                                                                                            <em class="icon icon-circle icon-circle-lg bg-teal ni ni-bell"></em>
                                                                                            <span class="lead-text mb-1 mt-3">Thông báo(Không phản hồi)</span>
                                                                                        </span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div v-if="activity.action != actionType.NOTIFICATION_JOIN" class="nk-stepper-step">
                                                            <h5 class="title mb-3">Chọn đối tượng nhận</h5>
                                                            <ul class="row g-5">
                                                                <li class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                                        <input type="radio" v-model="activity.bigObject" :value="bigObject.KHOI" class="custom-control-input" name="bigObj" id="bigObj1" required>
                                                                        <label class="custom-control-label" for="bigObj1">
                                                                                        <span class="d-flex flex-column text-center px-sm-3">
                                                                                            <em class="icon icon-circle icon-circle-lg bg-teal ni ni-todo"></em>
                                                                                            <span class="lead-text mb-1 mt-3">Theo khối</span>
                                                                                        </span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                                        <input type="radio" v-model="activity.bigObject" :value="bigObject.KHOA_DAO_TAO" class="custom-control-input" name="bigObj" id="bigObj2" required>
                                                                        <label class="custom-control-label" for="bigObj2">
                                                                                        <span class="d-flex flex-column text-center px-sm-3">
                                                                                            <em class="icon icon-circle icon-circle-lg bg-teal ni ni-todo"></em>
                                                                                            <span class="lead-text mb-1 mt-3">Theo khoá đào tạo</span>
                                                                                        </span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <li class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                                        <input type="radio" v-model="activity.bigObject" :value="bigObject.LOP" class="custom-control-input" name="bigObj" id="bigObj3" required>
                                                                        <label class="custom-control-label" for="bigObj3">
                                                                                        <span class="d-flex flex-column text-center px-sm-3">
                                                                                            <em class="icon icon-circle icon-circle-lg bg-teal ni ni-todo"></em>
                                                                                            <span class="lead-text mb-1 mt-3">Theo lớp</span>
                                                                                        </span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            </ul>

                                                            <ul v-if="activity.bigObject == 3" class="row g-5">
                                                                <span class="h4">Chọn lớp</span>
                                                                <li class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                                        <template v-for="(choose, i) in classList">
                                                                            <input type="checkbox" v-model="activity.user_class_choose" :key="i" :value="choose.id_user_cbl" class="custom-control-input" :id="`choose${i}`" required>
                                                                            <label class="custom-control-label" :for="`choose${i}`">
                                                                                        <span class="d-flex flex-column text-center px-sm-3">
                                                                                            <em class="icon icon-circle icon-circle-lg bg-teal ni ni-todo"></em>
                                                                                            <span class="lead-text mb-1 mt-3">{{choose.class_name}}</span>
                                                                                        </span>
                                                                            </label>
                                                                        </template>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="nk-stepper-step">
                                                            <h5 class="title mb-4">Thông tin nhiệm vụ</h5>
                                                            <div class="row g-3">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" >Tên nhiệm vụ</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" v-model="activity.taskName" class="form-control"  placeholder="Tên nhiệm vụ" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Thời gian</label>
                                                                        <div class="form-control-wrap">
                                                                            <div class="input-daterange date-picker-range input-group">
                                                                                <div class="input-group-addon">Từ</div>
                                                                                <input type="text" class="form-control" />
                                                                                <div class="input-group-addon">Đến</div>
                                                                                <input type="text" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="cp1-profile-description">Mô tả</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea class="form-control form-control-sm quill-basic" v-model="activity.details" placeholder="Mô tả hoạt động"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ul class="nk-stepper-pagination pt-4 gx-4 gy-2 stepper-pagination">
                                                        <li class="step-prev"><button class="btn btn-dim btn-primary">Quay lại</button></li>
                                                        <li class="step-next"><button class="btn btn-primary">Tiếp tục</button></li>
                                                        <li class="step-submit"><button class="btn btn-primary" :disabled="!validSubmit" @click="onSaveActivity()">Tạo nhiệm vụ</button></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- .nk-block -->
                    </div><!-- .components-preview -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import constants from "../constants";
import {mapActions} from "vuex";
import activitiyServices from "../services/activitiy.services";

export default {
    data(){
        return{
            activity:{
                taskName: '',
                activity: null,
                action: null,
                details: '',
                bigObject: null,
                user_class_choose: [],
            },
            activitiy_list: [],
            classList: [],
        }
    },
    computed:{
        actionType(){
            return constants.ACTIVITY;
        },
        validSubmit(){
            return this.activity.activity && this.activity.taskName && this.activity.action;
        },
        bigObject(){
            return constants.OBJECT;
        },
    },
    methods:{
        ...mapActions({
            getActivityList: 'activity/getActivityList'
        }),

        async getActivities(){
            await activitiyServices.getActivityList()
                .then(response => this.activitiy_list = response.data.data);
        },
        async getClassByUser_CbKhoa(){
            await activitiyServices.getClassByUser_CbKhoa()
                .then(res => this.classList = res.data.data);
            console.log('class',this.classList);
        },
        async onSaveActivity(){
            console.log(this.activity);
            await activitiyServices.createChildActivity(this.activity)
        },
        onCloseModal(){
            this.activity.activity = null;
            this.activity.action = null;
            this.activity.taskName = '';
            this.activity.details = '';
        }
    },
    async mounted() {
        await this.getActivities();
        await this.getClassByUser_CbKhoa();
    },
}
</script>

<style scoped>
.custom-ml-3{
    margin-left: 0.75rem;
}
</style>
