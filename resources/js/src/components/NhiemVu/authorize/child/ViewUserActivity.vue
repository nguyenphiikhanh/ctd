<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewUserAct">
        <div class="modal-dialog modal-dialog-top mw-50" role="document">
            <div class="modal-content">
                <a @click="closeModal()" class="close">
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
                                <th scope="col">Đơn vị</th>
                                <th scope="col">Trạng thái điểm danh</th>
                                <th scope="col">Giải thưởng</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, index) in userList" :key="index">
                                <th scope="row">{{index + 1}}</th>
                                <td>{{user.username}}</td>
                                <td>{{user.fullname}}</td>
                                <td>{{`${user.class_name} ${user.team_name ? '('+ user.team_name  + ')' : ''} `}}</td>
                                <td>
                                    <span :class="`text-${classText(user.status)}`">{{ statusText(user.status) }}</span>
                                </td>
                                <td>
                                    <input v-if="user.status != status.STATUS_DUYET && user.status != status.STATUS_HOAN_THANH" class="form-control" disabled placeholder="Chưa thể cập nhật">
                                    <select v-else v-model="user.award" @change="onUpdateAward(user)" class="form-select">
                                        <option :value="awards.NO_AWARDS">Chưa có Giải thưởng</option>
                                        <option :value="awards.GIAI_NHAT">Giải Nhất</option>
                                        <option :value="awards.GIAI_NHI">Giải Nhì</option>
                                        <option :value="awards.GIAI_BA">Giải Ba</option>
                                        <option :value="awards.GIAI_KHUYEN_KHICH">Giải Khuyến khích</option>
                                    </select>
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
        async onUpdateAward(user){
            const data = {
                id: user.id_user_activity,
                award: user.award
            }
            await this.updateUserActivityAward(data);
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
