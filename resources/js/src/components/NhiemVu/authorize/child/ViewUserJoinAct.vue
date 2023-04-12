<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewUserJoinAct">
        <div class="modal-dialog modal-dialog-top mw-50" role="document">
            <div class="modal-content">
                <a @click="closeModal()" class="close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Danh sách tham dự có mặt</h5></div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Mã sinh viên</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Đơn vị</th>
                                <th scope="col">Trạng thái điểm danh</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, index) in userList" :key="index">
                                <th scope="row">{{index + 1}}</th>
                                <td>{{user.username}}</td>
                                <td>{{user.fullname}}</td>
                                <td>{{`${user.class_name}`}}</td>
                                <td>
                                    <span :class="`text-${classText(user.status)}`">{{ statusText(user.status) }}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <p v-if="userList.length == 0" class="text-center">
                    Không có dữ liệu.
                </p>
                <div class="modal-footer d-flex justify-content-center">
                    <button @click="closeModal()" class="btn btn-primary">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import constants from '../../../../constants';
export default {
    props:{
        userList: {
            type: Array
        },
    },
    data(){
        return{

        }
    },
    methods:{
        ...mapActions({
            updateUserActivityAward: 'activity/updateUserActivityAward',
        }),
        closeModal(){
            this.$emit('closeModal');
        },
        statusText(status){
            switch(status){
                case this.status.STATUS_HOAN_THANH:
                    return 'Đã hoàn thành';
                    break;
                case this.status.STATUS_DUYET:
                    return 'Đã hoàn thành';
                    break;
                case this.status.STATUS_CHO_DUYET:
                    return 'Chờ duyệt minh chứng';
                    break;
                case this.status.STATUS_VANG_MAT:
                    return 'Vắng mặt';
                    break;
                default: return 'Chưa hoàn thành';
            }
        },
        classText(status){
            switch(status){
                case this.status.STATUS_HOAN_THANH:
                    return 'success';
                    break;
                case this.status.STATUS_DUYET:
                    return 'success';
                    break;
                case this.status.STATUS_CHO_DUYET:
                    return 'warning';
                    break;
                default: return 'danger';
            }
        }
    },
    computed:{
        status(){
            return constants.status;
        },
        awards(){
            return constants.awards;
        },
        action(){
            return constants.HOAT_DONG;
        },
    }
};
</script>

<style scoped>
.mw-50{
    min-width: 70%;
}
</style>

