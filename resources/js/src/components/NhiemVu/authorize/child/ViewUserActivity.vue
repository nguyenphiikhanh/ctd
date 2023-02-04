<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewUserAct">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Danh sách dự thi</h5></div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Mã sinh viên</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Trạng thái điểm danh</th>
                                <th scope="col">Giải thưởng</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, index) in userList" :key="index">
                                <th scope="row">{{index + 1}}</th>
                                <td>{{user.username}}</td>
                                <td>{{user.fullname}}</td>
                                <td>
                                    <span :class="`text-${classText(user.status)}`">{{ statusText(user.status) }}</span>
                                </td>
                                <td>
                                    <input v-if="user.status != status.STATUS_DUYET && user.status != status.STATUS_HOAN_THANH" class="form-control" disabled placeholder="Chưa thể cập nhật">
                                    <select v-else v-model="user.award" class="form-select">
                                        <option :value="awards.NO_AWARDS">Chưa có giải thưởng</option>
                                        <option :value="awards.GIAI_NHAT">Giải nhất</option>
                                        <option :value="awards.GIAI_NHI">Giải nhì</option>
                                        <option :value="awards.GIAI_BA">Giải ba</option>
                                        <option :value="awards.GIAI_KHUYEN_KHICH">Giải Khuyến khích</option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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

</style>
