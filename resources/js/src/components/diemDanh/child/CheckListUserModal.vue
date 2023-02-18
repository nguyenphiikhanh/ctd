<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" id="checkListModal">
        <div class="modal-dialog modal-dialog-top mw-70" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">
                    {{activity.child_activity_type == types.TB_GUI_DS_THAM_DU ? `Danh sách tham dự: ${activity.name}`
                     : `Danh sách tham gia: ${activity.name}`}}</h5></div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Mã sinh viên</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Trạng thái điểm danh</th>
                                <th scope="col">Ghi chú</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, index) in listUser" :key="index">
                                <th scope="row"><span :class="authUser.id == user.id ? 'text-warning' : ''">{{index + 1}}</span></th>
                                <td><span :class="authUser.id == user.id ? 'text-warning' : ''">{{user.username}}</span></td>
                                <td><span :class="authUser.id == user.id ? 'text-warning' : ''">{{user.fullname}}</span></td>
                                <td>
                                    <span v-if="!canUpdate(user)" class="text-success">Đã hoàn thành</span>
                                    <select v-if="canUpdate(user) && authUser.id != user.id && (user.status != statuses.STATUS_CHO_DUYET && user.status != statuses.STATUS_DUYET && user.status != statuses.STATUS_TU_CHOI)" v-model="user.status" @change="onUpdateStatus(user)" class="form-control w-90">
                                        <option :value="statuses.STATUS_CHUA_HOAN_THANH">Chưa hoàn thành</option>
                                        <option :value="statuses.STATUS_HOAN_THANH">Hoàn thành</option>
                                        <option :value="statuses.STATUS_VANG_MAT">Vắng mặt</option>
                                    </select>
                                    <select v-if="!canUpdate(user) || authUser.id == user.id" disabled class="form-control w-90">
                                        <option>Không thể cập nhật</option>
                                    </select>
                                    <span v-if="canUpdate(user) && (user.status == statuses.STATUS_CHO_DUYET)" class="text-warning">Chờ xét duyệt</span>
                                    <span v-if="canUpdate(user) && (user.status == statuses.STATUS_DUYET)" class="text-success">Đã xét duyệt</span>
                                    <span v-if="canUpdate(user) && (user.status == statuses.STATUS_TU_CHOI)" class="text-danger">Không duyệt minh chứng</span>
                                </td>
                                <td>
                                    <input v-if="canUpdate(user) && authUser.id != user.id" v-model="user.note" @keyup.enter="$event.target.blur()" @blur="onUpdateStatus(user)" class="form-control" placeholder="Ghi chú">
                                    <input v-if="!canUpdate(user) || authUser.id == user.id" class="form-control" disabled placeholder="Không thể cập nhật">
                                </td>
                                <td class="d-flex justify-content-center">
                                    <div v-if="user.status == statuses.STATUS_CHO_DUYET">
                                        <button class="btn btn-info ml-auto" @click="onViewProof(user)">Xem minh chứng</button>
                                        <button class="btn btn-success" @click="onConfirmProof(user)">Duyệt</button>
                                        <button class="btn btn-danger"  @click="onConfirmProof(user, false)">Từ chối</button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                <p v-if="userCheckList.length == 0" class="text-center">Không có dữ liệu.</p>
                </div>
                <ViewProof :prooves="prooves" @onClose="closeProofModal()"/>
            </div>
        </div>
    </div>
</template>

<script>
import constants from "../../../constants";
import ViewProof from "./ViewProof.vue";
import {mapActions} from "vuex";

export default {
    components:{ViewProof},
    props:{
        userCheckList: {type: Array, default: []},
        activity: {type: Object,default: {} }
    },
    data(){
        return{
            prooves: [],
        }
    },
    methods:{
        ...mapActions({
            updateUserCheckListStatus: 'activity/updateUserCheckListStatus',
            getProoves: 'activity/getProoves',
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
        async onViewProof(userObj){
            this.$loading(true);
            let data = {
                user_id: userObj.id,
                activity_details_id: this.activity.id,
                child_activity_type: this.activity.child_activity_type
            }
            await this.getProoves(data).then(res => {
                this.prooves = [...res.data];
                this.$nextTick(async () => {
                    $('#viewProofModal').modal('show');
                });
            }).finally(() => this.$loading(false));
            $('#checkListModal').modal('show');
        },
        async onConfirmProof(userObj, confirmFlg = true){
            let data = {
                user_id: userObj.id,
                activity_details_id: this.activity.id,
                child_activity_type: this.activity.child_activity_type,
                status: confirmFlg ? this.statuses.STATUS_DUYET : this.statuses.STATUS_TU_CHOI,
                note: userObj.note
            }
            await this.updateUserCheckListStatus(data).then(() => this.$emit('confirmed',this.activity));
        },
        canUpdate(user){
            if(this.activity.child_activity_type == this.types.TB_GUI_DS_THAM_DU){
                return user.award == this.awards.NO_AWARDS;
            }
            return true;
        },
        closeModal(){
            this.$emit('onClose')
        },
        closeProofModal(){
            this.$nextTick(() => {
                $('#viewProofModal').modal('hide');
            });
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
        },
        awards(){
            return constants.awards;
        },
        authUser(){
            return this.$store.getters['auth/user'];
        }
    },
}
</script>

<style scoped>
.mw-70{
    min-width: 70%;
}
</style>
