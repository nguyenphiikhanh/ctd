<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="checkListModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">
                    {{childActivity.child_activity_type == types.THONG_BAO_C0_PHAN_HOI_THAM_DU ? `Danh sách tham dự: ${childActivity.name}`
                     : `Danh sách tham gia: ${childActivity.name}`}}</h5></div>
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
                            <tr v-for="(user, index) in userCheckList" :key="index">
                                <th scope="row">{{index + 1}}</th>
                                <td>{{user.username}}</td>
                                <td>{{user.fullname}}</td>
                                <td>
                                    <select @change="onUpdateStatus(user.id)" class="form-control w-90">
                                        <option>Chưa hoàn thành</option>
                                        <option>Hoàn thành</option>
                                        <option>Vắng mặt</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" placeholder="Ghi chú">
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
export default {
    props:{
        userCheckList: {type: Array, default: []},
        childActivity: {type: Object, default: {}}
    },
    methods:{
        onUpdateStatus(id){
          alert('updated');
        },
        closeModal(){
            this.$emit('onClose')
        }
    },
    computed:{
        types(){
            return constants.HOAT_DONG;
        }
    }
}
</script>

<style scoped>

</style>
