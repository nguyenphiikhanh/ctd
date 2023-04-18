<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Điểm danh hoạt động</h3>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Danh sách hoạt động</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Loại hoạt động</th>
                                        <th scope="col">Tên hoạt động</th>
                                        <th scope="col">Yêu cầu hoạt động</th>
                                        <th scope="col">Thời gian</th>
                                        <th scope="col">Trạng thái</th>
                                        <th ></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in checkList" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{ activityText(_item.id_activity) }}</td>
                                        <td>{{_item.name}}</td>
                                        <td>
                                            <span v-if="_item.child_activity_type == type.TB_GUI_DS_THAM_DU || (_item.id_activity == act.HOAT_DONG_NCKH && _item.child_activity_type == type.PHAN_THI_OR_TIEU_BAN)">Danh sách dự thi</span>
                                            <span v-if="_item.child_activity_type == type.TB_GUI_DS_THAM_GIA">Có mặt tham dự</span>
                                        </td>
                                        <td>
                                            <span>{{ convertDateTime(_item.start_time) }} đến {{ convertDateTime(_item.end_time) }}</span>
                                        </td>
                                        <td>
                                            <span v-if="validCheckList(_item)" class="mx-auto my-auto badge-dim bg-success">Đang diễn ra</span>
                                            <span v-else class="mx-auto my-auto badge-dim bg-danger">Đã kết thúc</span>
                                        </td>
                                        <td>
                                            <button v-if="validCheckList(_item)" @click="showUserCheckList(_item)" class="btn btn-sm btn-primary">Điểm danh</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="checkList.length == 0" class="text-center col-12">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                    <CheckListUserModal @confirmed="onConfirmed" :activity="activity" :user-check-list="userCheckList" @onClose="onClose"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import {asyncLoading} from "vuejs-loading-plugin";
import constants from "../../constants";
import datetimeUtils from "../../helpers/utils/datetimeUtils";
import CheckListUserModal from "./child/CheckListUserModal.vue";

export default {
    components:{
      CheckListUserModal,
    },
    data(){
        return{
            checkList: [],
            userCheckList: [],
            activity: {
                child_activity_type: 3
            },
        }
    },
    methods:{
        ...mapActions({
            getActivitiesForCheckList: 'activity/getActivitiesForCheckList',
            getUserForCheckList: 'activity/getUserForCheckList',
        }),
        async getCheckList(){
            await this.getActivitiesForCheckList().then(res => this.checkList = [...res.data]);
        },
        async showUserCheckList(activity){
            this.$loading(true);
            this.activity = activity;
            await this.getUserForCheckList(this.activity).then(res => this.userCheckList = [...res.data])
                .finally(() => this.$loading(false));
            this.$nextTick(() => {
                $('#checkListModal').modal('show');
            });
        },
        onClose(){
            this.$nextTick(() => {
                $('#checkListModal').modal('hide');
            });
        },
        async onConfirmed(activity){
            this.activity = activity;
            await this.getUserForCheckList(this.activity).then(res => this.userCheckList = [...res.data]);
        },
        convertDateTime(datetime){
           return datetime ? datetimeUtils.dateTimeVnFormat(datetime) : '';
        },
        activityText(id_activity){
            switch(id_activity){
                case this.act.HOAT_DONG_NCKH:
                    return 'Nghiên cứu khoa học';
                    break;
                case this.act.HOAT_DONG_NVSP:
                    return 'Nghiệp vụ Sư phạm';
                    break;
                case this.act.HOAT_DONG_DOAN:
                    return 'Hoạt động Đoàn';
                    break;
                default: return 'Hoạt động khác';
            }
        },
        validCheckList(_item){
            let deadlineUpload = datetimeUtils.addOneDay(_item.end_time);
            return deadlineUpload > new Date();
        },
    },
    computed:{
        act(){
            return constants.LOAI_HOAT_DONG;
        },
        type(){
            return constants.HOAT_DONG;
        }
    },
    async mounted() {
        await asyncLoading(this.getCheckList());
    }
}
</script>

<style scoped>

</style>
