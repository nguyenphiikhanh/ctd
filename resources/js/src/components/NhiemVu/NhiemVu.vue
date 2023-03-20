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
                        <ul class="nav nav-tabs mb-3">
                            <li v-if="user.role == roles.ROLE_BI_THU_DOAN" class="nav-item" @click="getChildActList(loai_hoat_dong.HOAT_DONG_NCKH, 1)">
                                <a :class="`nav-link ${current_tab == loai_hoat_dong.HOAT_DONG_NCKH ? 'active' : ''}`" data-toggle="tab" href="#nckh"><em class="ni ni-view-list"></em> Nghiên cứu khoa học</a>
                            </li>
                            <li class="nav-item" @click="getChildActList(loai_hoat_dong.HOAT_DONG_NVSP, 2)">
                                <a :class="`nav-link ${current_tab == loai_hoat_dong.HOAT_DONG_NVSP ? 'active' : ''}`" data-toggle="tab" href="#nvsp"><em class="ni ni-view-list"></em> Nghiệp vụ Sư phạm</a>
                            </li>
                            <li v-if="user.role == roles.ROLE_BI_THU_DOAN" class="nav-item" @click="getChildActList(loai_hoat_dong.HOAT_DONG_DOAN, 3)">
                                <a :class="`nav-link ${current_tab == loai_hoat_dong.HOAT_DONG_DOAN ? 'active' : ''}`" data-toggle="tab" href="#doan"><em class="ni ni-view-list"></em> Hoạt động Đoàn</a>
                            </li>
                            <li v-if="user.role == roles.ROLE_BI_THU_DOAN" class="nav-item" @click="getChildActList(loai_hoat_dong.HOAT_DONG_KHAC, 4)">
                                <a :class="`nav-link ${current_tab == loai_hoat_dong.HOAT_DONG_KHAC ? 'active' : ''}`" data-toggle="tab" href="#khac"><em class="ni ni-view-list"></em> Hoạt động Khác</a>
                            </li>
                            <li v-if="user.role == roles.ROLE_BI_THU_DOAN && current_tab == 2" class="nav-item">
                                <button @click="confirmCollectPoint()" class="btn btn-sm btn-success"><em class="ni ni-col-4s"></em>Tổng hợp điểm tuần NVSP</button>
                            </li>
                        </ul>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="p-3">
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên hoạt động</th>
                                        <th scope="col">Loại hoạt động</th>
                                        <th scope="col">Yêu cầu</th>
                                        <th v-if="activity == loai_hoat_dong.HOAT_DONG_NVSP" scope="col">Phụ trách viên</th>
                                        <th ></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in child_activities" :key="index">
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>{{_item.name}}</td>
                                        <td><span>{{ activity_type(_item.id_activity) }}</span></td>
                                        <td><span>{{ requirement(_item.id_activity, _item.child_activity_type) }}
                                            <small class="text-danger">{{ joinTypeConvert(_item) }}</small></span></td>
                                        <td v-if="activity == loai_hoat_dong.HOAT_DONG_NVSP">
                                            <span :class="_item.id_user_assignee ? 'text-primary' : 'text-warning'">{{ _item.id_user_assignee ? _item.user_assign_name : 'Chưa có'}}</span>
                                            <button v-if="_item.child_activity_type == action.PHAN_THI_OR_TIEU_BAN && user.role == roles.ROLE_BI_THU_DOAN"
                                             @click="changeAssignee(_item)"
                                             class="btn btn-sm btn-warning"><em class="ni ni-repeat"></em></button>
                                        </td>
                                        <td>
                                            <button @click="viewAct(_item)" class="btn btn-sm btn-info"><em class="icon ni ni-eye"></em>Chi tiết</button>
                                            <button @click="showUserActivityList(_item.id)"
                                            v-if="_item.child_activity_type == action.PHAN_THI_OR_TIEU_BAN || _item.child_activity_type == action.TB_GUI_DS_THAM_GIA"
                                            class="btn btn-sm btn-primary"><em class="icon ni ni-list"></em>Danh sách</button>
                                            <button @click="showUserNckh(_item)"
                                            v-if="_item.id_activity == loai_hoat_dong.HOAT_DONG_NCKH && _item.child_activity_type == action.PHAN_THI_OR_TIEU_BAN"
                                            class="btn btn-sm btn-warning"><em class="icon ni ni-edit"></em>Sửa danh sách</button>
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
                <UpdateAssignee :assignees="assignees" :child-act="child_act_view"
                @onSave="getChildActList(activity, current_tab, true)"
                @closeModal="closeModal()"/>
                <UpdateUserNckh :child-act="child_act_view" :user-list="user_acts" @closeModal="closeModal()" :key="key"/>
            </div>
        </div>
    </div>
</template>

<script>

import {mapActions} from "vuex";
import constants from "../../constants";
import datetimeUtils from "../../helpers/utils/datetimeUtils";
import ViewChildActivity from "./authorize/child/ViewChildActivity.vue";
import ViewUserActivity from "./authorize/child/ViewUserActivity.vue";
import UpdateAssignee from './authorize/phuTrach/UpdateAssignee.vue';
import UpdateUserNckh from "./authorize/child/UpdateUserNckh.vue";

export default {
    components:{
        ViewChildActivity,
        ViewUserActivity,
        UpdateAssignee,
        UpdateUserNckh,
    },
    data(){
        return{
            activity:  1,
            current_tab: 1,
            child_activities: [],
            child_act_view: {
                files: [],
            },
            user_acts: [],
            key: 0,
            assignees: [],
        }
    },
    computed:{
        loai_hoat_dong(){
          return constants.LOAI_HOAT_DONG;
        },
        action(){
            return constants.HOAT_DONG;
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
        joinType(){
            return constants.HINH_THUC_THI;
        }
    },
    methods:{
        ...mapActions({
            getChildActivities: "activity/getChildActivities",
            getUserActivities: "activity/getUserActivities",
            getAssignee: 'userModule/getAssignees',
            nvspCreatePoint: 'points/nvspCreatePoint',
            getStudentByFaculty: 'student/getStudentByFaculty',
        }),
        async getChildActList(activity = this.loai_hoat_dong.HOAT_DONG_NCKH, current_tab = null, reGet = false){
            if(this.current_tab == current_tab && !reGet) return;
            this.current_tab = current_tab || 1;
            this.$loading(true);
            this.activity = activity;
            let params = {
                id_activity: this.activity,
            }
            await this.getChildActivities(params).then(res => this.child_activities = [...res.data]);
            localStorage.setItem('child_act_current_tab', this.current_tab);
            this.$loading(false);
        },
        viewAct(act){
            this.child_act_view = act;
            this.$nextTick(() => {
                $('#viewChildAct').modal('show');
            });
        },
        changeAssignee(act){
            this.child_act_view = act;
            this.$nextTick(() => {
                $('#assigneeSetting').modal('show');
            });
        },
        async onUpdateChildActivity(){
            await this.getChildActList();
            this.closeModal();
        },
        closeModal(){
            this.child_act_view = {
                files: [],
            }
            this.$nextTick(() => {
                $('#viewChildAct').modal('hide');
                $('#viewUserAct').modal('hide');
                $('#showUserNckh').modal('hide');
                $('#assigneeSetting').modal('hide');
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
        async showUserNckh(child_act){
            this.child_act_view = child_act;
            this.$loading(true);
            const reqs = {
                    id_faculty: this.user.id_khoa,
                    params:{
                        start_time: datetimeUtils.convertTimezoneToDatetime(child_act.start_time),
                        end_time: datetimeUtils.convertTimezoneToDatetime(child_act.end_time)
                    }
                };
            await this.getStudentByFaculty(reqs)
                .then(res => {
                    this.user_acts = [...res.data];
                    this.key++
                    this.$nextTick(() => {
                        $('#showUserNckh').modal('show');
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
                            return 'Danh sách dự thi';
                            break;
                        case this.action.TB_GUI_DS_THAM_GIA:
                            return 'Danh sách có mặt tham dự';
                            break;
                        case this.action.THONG_BA0_KHONG_PHAN_HOI:
                            return 'Thông báo';
                            break;
                    }
                    break;
                case this.loai_hoat_dong.HOAT_DONG_NVSP:
                    switch (child_activity_type) {
                        case this.action.PHAN_THI_OR_TIEU_BAN:
                            return 'Hoạt động';
                            break;
                        case this.action.TB_GUI_DS_THAM_DU:
                            return 'Danh sách dự thi';
                            break;
                        case this.action.TB_GUI_DS_THAM_GIA:
                            return 'Danh sách có mặt tham dự';
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
                            return 'Danh sách dự thi';
                            break;
                        case this.action.TB_GUI_DS_THAM_GIA:
                            return 'Danh sách có mặt tham dự';
                            break;
                        case this.action.THONG_BA0_KHONG_PHAN_HOI:
                            return 'Thông báo';
                            break;
                    }
            }
        },
        statusText(child_act){

        },
        confirmCollectPoint(){
            this.$swal.fire({
                title: 'Tổng hợp điểm Nghiệp vụ Sư phạm?',
                text: "Điểm cho tuần lễ Nghiệp vụ Sư phạm sẽ được hệ thống tự động tính và bạn sẽ không thể thao tác cập nhật các hoạt động.\nChú ý: quá trình này có thể mất nhiều thời gian với dữ liệu lớn.",
                showCancelButton: true,
                confirmButtonColor: '#1abe92',
                confirmButtonText: 'Tổng hợp điểm',
                cancelButtonText: 'Đóng',
                }).then(async (result) => {
                if (result.isConfirmed) {
                    this.$loading(true);
                    await this.nvspCreatePoint();
                    this.$loading(false);
                    }
                })
        },
        joinTypeConvert(act){
            if(act.id_activity == this.loai_hoat_dong.HOAT_DONG_NVSP){
                if(act.level == this.actLevel.TOA_DAM){
                    return '(Tọa đàm NVSP)';
                } else if(act.join_type == this.joinType.THI_NHOM){
                    return '(Thi theo nhóm)';
                } else if(act.join_type == this.joinType.THI_CA_NHAN){
                    return '(Thi cá nhân)'
                }
            }
            else return '';
        }
    },
    async mounted() {
        this.$loading(true);
        if(this.user.role == this.roles.ROLE_PHU_TRACH_NVSP){
            this.current_tab = this.loai_hoat_dong.HOAT_DONG_NVSP;
        }
        else{
            const current_tab = localStorage.getItem('child_act_current_tab');
            if(current_tab) this.current_tab = current_tab;
        }
        await this.getChildActList(this.current_tab, this.current_tab, true);
        await this.getAssignee().then(res => this.assignees = [...res.data]);
        this.$loading(false);
    }
}
</script>

<style scoped>
.custom-ml-3{
    margin-left: 0.75rem;
}
</style>
