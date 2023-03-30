<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" id="userListConfirm">
        <div class="modal-dialog modal-dialog-top" role="document">
            <div class="modal-content mh-90">
                <a @click="closeModal()" class="close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Gửi minh chứng</h5></div>
                <div class="modal-body">
                    <div v-if="!listUser.length" class="text-center mb-3">Không có dữ liệu xét duyệt</div>
                    <div class="col-12" v-else>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Mã sinh viên</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Hoạt động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, index) in listUser" :key="index">
                                <th scope="row"><span>{{index+1}}</span></th>
                                <td><span>{{user.username}}</span></td>
                                <td><span>{{user.fullname}}</span></td>
                                <td :class="`d-flex justify-content-start`">
                                    <div v-if="waiting == false">
                                        <button class="btn btn-sm btn-info ml-auto" @click="onViewProof(user.prooves)">Xem minh chứng</button>
                                        <button class="btn btn-sm btn-success" @click="onConfirmProof(user)">Duyệt</button>
                                        <button class="btn btn-sm btn-danger" @click="onConfirmProof(user, false)">Từ chối</button>
                                    </div>
                                    <div v-else class="text-center">Đang cập nhật...</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <ViewProof :prooves="prooves" @onClose="closeProofModal()"/>
                    <div class="d-flex justify-content-center"><button @click="closeModal()" class="btn btn-outline-secondary">Đóng</button></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {mapActions} from "vuex";
import ViewProof from "./ViewProof";
import constants from "../../../constants";
export default {
    components:{
        ViewProof
    },
    props:{
        tcId: {type: Number, default: null},
        listUser: {type: Array, default: []},
    },
    data(){
        return {
            prooves: [],
            waiting: false,
        }
    },
    methods:{
        ...mapActions({
            uploadProoves: 'personalScore/sendProof',
            confirmTcProoves: 'personalScore/confirmTcProoves'
        }),
        onViewProof(prooves){
            this.prooves = prooves;
            this.$nextTick( () => {
                $('#viewProofModal').modal('show');
            });
        },
        async onConfirmProof(user, confirmFlg = true){
            this.waiting = true;
            const status = constants.status;
            let data = {
                id: user.id,
                status: confirmFlg ? status.SCORE_DUYET : status.SCORE_KHONG_DUYET
            }
            await this.confirmTcProoves(data);
            await this.$emit('confirmed', user.id);
            this.waiting = false;
        },
        closeProofModal(){
            this.$nextTick(() => {
                $('#viewProofModal').modal('hide');
            });
        },
        closeModal(){
            this.$nextTick(() => {
                $('#userListConfirm').modal('hide');
            });
        }
    },
    computed:{
        authUser(){
            return this.$store.getters['auth/user'];
        }
    }
}
</script>

<style scoped>
.mw-80{
    min-width: 80%;
}
</style>
