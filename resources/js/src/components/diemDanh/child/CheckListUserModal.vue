<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="checkListModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">
                    {{activity.child_activity_type == types.THONG_BAO_C0_PHAN_HOI_THAM_DU ? `Danh sách tham dự: ${activity.name}`
                     : `Danh sách tham gia: ${activity.name}`}}</h5></div>
                <div class="modal-body">
                    <p v-if="userCheckList.length == 0" class="text-center">
                        Không có dữ liệu.
                    </p>
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Mã sinh viên</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Điểm danh</th>
                                <th scope="col">Ghi chú</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, index) in listUser" :key="index">
                                <th scope="row">{{index + 1}}</th>
                                <td>{{user.username}}</td>
                                <td>{{user.fullname}}</td>
                                <td>
                                    <select v-model="user.status" @change="onUpdateStatus(user)" class="form-control w-90">
                                        <option :value="statuses.STATUS_CHUA_HOAN_THANH">Chưa hoàn thành</option>
                                        <option :value="statuses.STATUS_HOAN_THANH">Hoàn thành</option>
                                        <option :value="null">Vắng mặt</option>
                                    </select>
                                </td>
                                <td>
                                    <input v-model="user.note" @blur="onUpdateStatus(user)" class="form-control" placeholder="Ghi chú">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import constants from "../../../constants";
import {mapActions} from "vuex";

export default {
    props:{
        userCheckList: {type: Array, default: []},
        activity: {type: Object,default: {} }
    },
    methods:{
        ...mapActions({
            updateUserCheckListStatus: 'activity/updateUserCheckListStatus',
        }),
        async onUpdateStatus(userObj){
            let data = {
                user_id: userObj.id,
                activity_details_id: this.activity.id,
                child_activity_type: this.activity.child_activity_type,
                status: userObj.status,
                note: userObj.note
            }
            await this.updateUserCheckListStatus(data);
        },
        closeModal(){
            this.$emit('onClose')
        }
    },
    computed:{
        listUser(){
          return [...this.userCheckList];
        },
        types(){
            return constants.HOAT_DONG;
        },
        statuses(){
            return constants.status;
        }
    },
}
</script>

<style scoped>

</style>
