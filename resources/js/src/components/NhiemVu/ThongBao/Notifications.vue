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
                            <table class="table table-orders">
                                <thead class="tb-odr-head">
                                <tr class="tb-odr-item">
                                    <th class="tb-odr-info">
                                        <span class="tb-odr-id">Thời gian</span>
                                        <span class="tb-odr-date d-none d-md-inline-block">Tên nhiệm vụ</span>
                                    </th>
                                    <th class="tb-odr-amount">
                                        <span class="tb-odr-total">Mô tả</span>
                                        <span class="tb-odr-status d-none d-md-inline-block">Trạng thái</span>
                                    </th>
                                    <th class="tb-odr-action">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody class="tb-odr-body">
                                <tr class="tb-odr-item" v-for="(item, index) in notiList" :key="index">
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-date">{{item.created_at}}</span>
                                        <span class="tb-odr-id"><a href="#">{{item.name}}</a></span>

                                    </td>
                                    <td class="tb-odr-amount">
                                            <span class="tb-odr-total">
                                                <span class="amount">{{item.details}}</span>
                                            </span>
                                        <span class="tb-odr-status">
                                               <span class="badge badge-dot bg-success" v-if="item.status == status.STATUS_HOAN_THANH">Đã hoàn thành</span>
                                                <span class="badge badge-dot bg-warning" v-if="item.status == status.STATUS_CHUA_HOAN_THANH">Chưa hoàn thành</span>
                                            </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="tb-odr-btns d-none d-md-inline">
                                            <a href="#" @click="viewNotify(item.id)" class="btn btn-sm btn-primary">Xem</a>
                                            <a href="#" v-if="item.status == status.STATUS_CHUA_HOAN_THANH" @click="forwardChildAct(item.id, item.child_activity_type == action.THONG_BA0_KHONG_PHAN_HOI)" class="btn btn-sm btn-primary">{{item.child_activity_type == action.THONG_BAO_C0_PHAN_HOI ? 'Chọn danh sách' : 'Chuyển tiếp'}}</a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- .card -->
                    </div><!-- nk-block -->
                    <forward-modal :userList="userList" :readonly="readonlyFlg" @forward="onForward()" @closeModal="closeForward()" @changeSelected="selectUser" @changeDetails="changeSmallRoleDetails"/>
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


export default {
    components:{
        ForwardModal,
    },
    data(){
        return{
            id: null,
            notiList: [],
            userList: [],
            user_selected: [],
            readonlyFlg: true,
            small_role_details: '',
        }
    },
    computed:{
        status(){
            return constants.status;
        },
        action(){
            return constants.HOAT_DONG;
        }
    },
    methods:{
        ...mapActions({
            getActReceive: 'activity/getActivitiesReceive',
            forwardActivities: 'activity/forwardActivities',
            getUserList: 'userModule/getUserByCanBoLop',
        }),
        async getActivitiesReceive(){
            await this.getActReceive().then(res => this.notiList = res.data);
        },
        async getUserListForward(readonly = null){
            await this.getUserList(readonly).then(res => this.userList = res.data);
        },
        async forwardChildAct(id, readonly = false){
            this.$loading(true)
            this.id = id;
            await this.getUserListForward(readonly ? readonly : null);
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
        viewNotify(id){
            alert(id+ ' Chưa làm chức năng này đâu, chờ tí');
        },
        closeForward(){
            this.$nextTick(() => {
                $('#forwardModal').modal('hide');
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
