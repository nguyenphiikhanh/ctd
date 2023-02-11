<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Nhiệm vụ và thông báo</h3>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Danh sách nhiệm vụ và thông báo</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Thời gian</th>
                                        <th scope="col">Tên nhiệm vụ</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Yêu cầu hoạt động</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in notiList" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{ convertDateTime(_item.start_time) }}</td>
                                        <td>{{_item.name}}</td>
                                        <td>
                                            <span class="tb-odr-status">
                                               <span class="badge bg-success" v-if="_item.status == status.STATUS_HOAN_THANH || _item.status == status.STATUS_DUYET">Đã hoàn thành</span>
                                               <span class="badge bg-warning" v-if="_item.status == status.STATUS_CHO_DUYET">Đang chờ duyệt</span>
                                               <span class="badge bg-danger" v-if="_item.status == status.STATUS_CHUA_HOAN_THANH">Chưa hoàn thành</span>
                                               <span class="badge bg-danger" v-if="_item.status == status.STATUS_TU_CHOI">Minh chứng không được xét duyệt</span>
                                               <span class="badge bg-danger" v-if="_item.status == status.STATUS_VANG_MAT">Vắng mặt</span>
                                            </span>
                                        </td>
                                        <td>
                                            <span v-if="_item.child_activity_type == action.THONG_BA0_KHONG_PHAN_HOI">Thông báo</span>
                                            <span v-if="_item.child_activity_type == action.THONG_BAO_C0_PHAN_HOI_THAM_GIA">Tham gia</span>
                                            <span v-if="_item.child_activity_type == action.THONG_BAO_C0_PHAN_HOI_THAM_DU">Tham dự</span>
                                            <span v-if="_item.child_activity_type == action.TB_GUI_DS_THAM_DU">Gửi danh sách tham dự</span>
                                            <span v-if="_item.child_activity_type == action.TB_GUI_DS_THAM_GIA">Gửi danh sách tham gia</span>
                                        </td>
                                        <td class="d-flex justify-content-end">
                                            <div>
                                            <button @click="viewNotify(_item)" class="btn btn-sm btn-info mr-2">Xem chi tiết</button>
                                            <button v-if="canForward(_item, user.role)" @click="forwardChildAct(_item, _item.child_activity_type == action.THONG_BA0_KHONG_PHAN_HOI)"
                                               class="btn btn-sm btn-primary mr-2">{{_item.child_activity_type == action.THONG_BAO_C0_PHAN_HOI  || _item.child_activity_type == action.TB_GUI_DS_THAM_GIA || _item.child_activity_type == action.TB_GUI_DS_THAM_DU
                                                ? 'Chọn danh sách' : 'Chuyển tiếp'}}</button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="notiList.length == 0" class="text-center col-12 mt-5">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                    <forward-modal :userList="userList" :readonly="readonlyFlg" @forward="onForward()" @closeModal="closeForward()" @changeSelected="selectUser" @changeDetails="changeSmallRoleDetails"/>
                    <view-notification :notify-info="child_act_info" @closeModal="closeForward()" @proofUploaded="getActivitiesReceive()"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {mapActions} from "vuex";
import { asyncLoading } from 'vuejs-loading-plugin';
import constants from '../../../constants';
import ForwardModal from './child/ForwardModal.vue';
import ViewNotification from "./child/ViewNotification.vue";
import datetimeUtils from '../../../helpers/utils/datetimeUtils';

export default {
    components:{
        ForwardModal,
        ViewNotification,
    },
    data(){
        return{
            id: null,
            notiList: [],
            userList: [],
            user_selected: [],
            readonlyFlg: true,
            small_role_details: '',

            child_act_info:{
                id: null,
                name: '',
                start_time: '',
                end_time: '',
                details: '',
                files: [
                    {
                        file_name: '',
                        file_path: '',
                    }
                ],
            }
        }
    },
    computed:{
        status(){
            return constants.status;
        },
        action(){
            return constants.HOAT_DONG;
        },
        role(){
            return constants.roles;
        },
        user(){
            return this.$store.getters['auth/user'];
        }
    },
    methods:{
        ...mapActions({
            getActReceive: 'activity/getActivitiesReceive',
            forwardActivities: 'activity/forwardActivities',
            getUserList: 'userModule/getStudentByCanBoLop',
        }),
        convertDateTime(datetime){
           return datetime ? datetimeUtils.dateTimeVnFormat(datetime) : '';
        },
        canForward(noti, userRole){
            if(userRole == this.role.ROLE_CBL){
                return noti.status == this.status.STATUS_CHUA_HOAN_THANH
                && userRole == this.role.ROLE_CBL
                && (noti.child_activity_type == this.action.TB_GUI_DS_THAM_DU ||
                noti.child_activity_type == this.action.TB_GUI_DS_THAM_GIA ||
                noti.child_activity_type == this.action.PHAN_THI_OR_TIEU_BAN);
            }
            else return false;
        },
        async getActivitiesReceive(){
            await this.getActReceive().then(res => this.notiList = res.data);
        },
        async getUserListForward(readonly = null, id_activities_details_assign = null){
            const params = {
                readonly: readonly,
                id_activities_details_assign: id_activities_details_assign
            }
            await this.getUserList(params).then(res => this.userList = res.data);
        },
        async forwardChildAct(noti, readonly = false){
            this.$loading(true)
            this.id = noti.id;
            await this.getUserListForward(readonly ? readonly : null, noti.id_activities_details_assign);
            this.$loading(false);
            this.readonlyFlg = readonly;
            this.$nextTick(() => {
                $('#forwardModal').modal('show');
            });
        },
        async onForward(){
            let data = {
                id: this.id,
                assignTo: this.user_selected,
                readonlyFlg: this.readonlyFlg ? true : null,
                small_role_details: this.small_role_details,
            }
            await asyncLoading(this.forwardActivities(data));
            asyncLoading(this.getActivitiesReceive());
        },
        selectUser(val){
            this.user_selected = [...val];
        },
        changeSmallRoleDetails(val){
            this.small_role_details = val;
        },
        viewNotify(item){
            this.child_act_info = {...item};
            this.child_act_info.start_time = this.child_act_info.start_time ? datetimeUtils.dateTimeVnFormat(item.start_time) : '';
            this.child_act_info.end_time = this.child_act_info.end_time ? datetimeUtils.dateTimeVnFormat(item.end_time) : '';
            this.$nextTick(() => {
                $('#viewNotification').modal('show');
            });
        },
        closeForward(){
            this.$nextTick(() => {
                $('#forwardModal').modal('hide');
                $('#viewNotification').modal('hide');
            })
        }
    },
    mounted() {
        asyncLoading(this.getActivitiesReceive());
    }
}
</script>

<style scoped>

</style>
