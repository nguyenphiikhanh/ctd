<template>
   <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Nhiệm vụ</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-right">
                                                        <em class="btn icon ni ni-search"></em>
                                                    </div>
                                                    <input type="text" class="form-control" id="default-04" placeholder="Tìm kiếm">
                                                </div>
                                            </li>
                                            <li class="nk-block-tools-opt">
                                                <router-link :to="{name: 'NhiemVu_Create'}">
                                                    <button type="button" class="btn btn-primary d-none d-md-inline-flex">
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Tạo nhiệm vụ</span>
                                                    </button>
                                                </router-link>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Danh sách nhiệm vụ</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên hoạt động</th>
                                        <th scope="col">Loại hoạt động</th>
                                        <th scope="col">Yêu cầu</th>
                                        <th ></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in child_activities" :key="index">
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>{{_item.name}}</td>
                                        <td><span>{{ activity_type(_item.id_activity) }}</span></td>
                                        <td><span>{{ requirement(_item.id_activity, _item.child_activity_type) }}</span></td>
                                        <td>
                                            <button @click="viewAct(_item)" class="btn btn-sm btn-info">Chi tiết</button>
                                            <button @click="showUserActivityList(_item.id)" v-if="_item.child_activity_type == action.PHAN_THI_OR_TIEU_BAN" class="btn btn-sm btn-primary">Danh sách</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="child_activities.length == 0" class="text-center col-12 mt-5">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                </div>
                <ViewChildActivity :childActInfo="child_act_view" @onUpdate="onUpdateChildActivity()" @closeModal="closeModal()"/>
                <ViewUserActivity :user-list="user_acts" @closeModal="closeModal()"/>
            </div>
        </div>
    </div>
</template>

<script>

import {mapActions} from "vuex";
import {asyncLoading} from "vuejs-loading-plugin";
import constants from "../../constants";
import ViewChildActivity from "./authorize/child/ViewChildActivity.vue";
import ViewUserActivity from "./authorize/child/ViewUserActivity.vue";

export default {
    components:{
        ViewChildActivity,
        ViewUserActivity
    },
    data(){
        return{
            child_activities: [],
            child_act_view: {
                files: [],
            },
            user_acts: [],
            key: 0,
        }
    },
    computed:{
        loai_hoat_dong(){
          return constants.LOAI_HOAT_DONG;
        },
        action(){
            return constants.HOAT_DONG;
        }
    },
    methods:{
        ...mapActions({
            getChildActivities: "activity/getChildActivities",
            getUserActivities: "activity/getUserActivities",
        }),
        async getChildActList(){
            await this.getChildActivities().then(res => this.child_activities = [...res.data]);
        },
        viewAct(act){
            this.child_act_view = act;
            this.$nextTick(() => {
                $('#viewChildAct').modal('show');
            });
        },
        async onUpdateChildActivity(){
            await this.getChildActList();
            this.closeModal();
        },
        closeModal(){
            this.$nextTick(() => {
                $('#viewChildAct').modal('hide');
                $('#viewUserAct').modal('hide');
            });
        },
        async showUserActivityList(child_act_id){
            this.$loading(true);
            await this.getUserActivities(child_act_id)
                .then(res => {
                    this.user_acts = [...res.data];
                    this.$nextTick(() => {
                        $('#viewUserAct').modal('show');
                    });
                })
                .finally(() => this.$loading(false));
        },
        activity_type(id_act){
            switch (id_act){
                case this.loai_hoat_dong.HOAT_DONG_NCKH:
                    return 'Nghiên cứu khoa học';
                    break;
                case this.loai_hoat_dong.HOAT_DONG_NVSP:
                    return 'Nghiệp vụ Sư phạm';
                    break;
                case this.loai_hoat_dong.HOAT_DONG_DOAN:
                    return 'Hoạt động Đoàn';
                    break;
                default: return 'Khác';
            }
        },
        requirement(id_activity, child_activity_type){
            switch (id_activity){
                case this.loai_hoat_dong.HOAT_DONG_NCKH:
                    switch (child_activity_type) {
                        case this.action.PHAN_THI_OR_TIEU_BAN:
                            return 'Tiểu ban';
                            break;
                        case this.action.TB_GUI_DS_THAM_DU:
                            return 'Gửi danh sách dự thi';
                            break;
                        case this.action.TB_GUI_DS_THAM_GIA:
                            return 'Gửi danh sách tham gia';
                            break;
                        case this.action.THONG_BA0_KHONG_PHAN_HOI:
                            return 'Thông báo';
                            break;
                    }
                    break;
                case this.loai_hoat_dong.HOAT_DONG_NVSP:
                    switch (child_activity_type) {
                        case this.action.PHAN_THI_OR_TIEU_BAN:
                            return 'Phần thi';
                            break;
                        case this.action.TB_GUI_DS_THAM_DU:
                            return 'Gửi danh sách dự thi';
                            break;
                        case this.action.TB_GUI_DS_THAM_GIA:
                            return 'Gửi danh sách tham gia';
                            break;
                        case this.action.THONG_BA0_KHONG_PHAN_HOI:
                            return 'Thông báo';
                            break;
                    }
                    break;
                default:
                    switch (child_activity_type) {
                        case this.action.PHAN_THI_OR_TIEU_BAN:
                            return 'Hoạt động';
                            break;
                        case this.action.TB_GUI_DS_THAM_DU:
                            return 'Gửi danh sách dự thi';
                            break;
                        case this.action.TB_GUI_DS_THAM_GIA:
                            return 'Gửi danh sách tham gia';
                            break;
                        case this.action.THONG_BA0_KHONG_PHAN_HOI:
                            return 'Thông báo';
                            break;
                    }
            }
        }
    },
    mounted() {
        asyncLoading(this.getChildActList());
    }
}
</script>

<style scoped>
.custom-ml-3{
    margin-left: 0.75rem;
}
</style>
