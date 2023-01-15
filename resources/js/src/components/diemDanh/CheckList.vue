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
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên hoạt động</th>
                                        <th scope="col">Loại</th>
                                        <th scope="col">Trạng thái</th>
                                        <th ></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in checkList" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{_item.name}}</td>
                                        <td>{{_item.child_activity_type == type.THONG_BAO_C0_PHAN_HOI_THAM_DU ? 'DS tham dự' : 'DS tham gia'}}</td>
                                        <td><span class="mx-auto my-auto badge-dim bg-success">Đang diễn ra</span></td>
                                        <td>
                                            <button @click="showUserCheckList(_item)" class="btn btn-sm btn-primary">Điểm danh</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="checkList.length == 0" class="text-center col-12">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                    <CheckListUserModal :activity="activity" :user-check-list="userCheckList" @onClose="onClose"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import {asyncLoading} from "vuejs-loading-plugin";
import constants from "../../constants";

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
        }
    },
    computed:{
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
