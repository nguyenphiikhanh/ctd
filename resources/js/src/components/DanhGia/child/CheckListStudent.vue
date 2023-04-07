<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="checkListStudent">
        <div class="modal-dialog modal-dialog-top mw-98" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Điểm đánh giá cá nhân lớp {{classView.class_name}}</h5></div>
                <div class="modal-body">
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Danh sách sinh viên</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Mã Sinh viên</th>
                                        <th scope="col">Họ tên</th>
                                        <th scope="col">Điểm danh</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in studentListClone" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{_item.username}}</td>
                                        <td>{{_item.fullname}}</td>
                                        <td class="d-flex justify-content-start">
                                            <select v-model="_item.class_meet_check" @change="onUpdateStatus(_item)" class="form-control">
                                                <option :value="statuses.HOP_XET_CO_MAT">Có mặt</option>
                                                <option :value="statuses.HOP_XET_VANG_MAT">Vắng mặt</option>
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="studentList.length == 0" class="text-center col-12 mt-5">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
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
import constants from '../../../constants';
export default {
    props:{
        studentList: {type: Array},
        classView: {type:Object},
    },
    computed:{
        statuses(){
            return constants.status;
        }
    },
    data(){
        return{
            studentListClone: [],
        }
    },
    methods:{
        ...mapActions({
            updateMeetScoreStudentCheckList: 'classMeet/updateMeetScoreStudentCheckList',
        }),
        async onUpdateStatus(_item){
            const data = {
                id: _item.id,
                status: _item.class_meet_check
            }
            await this.updateMeetScoreStudentCheckList(data);
        },
        closeModal(){
            this.$emit('closeModal');
        },
    },
    mounted(){
        this.studentListClone = JSON.parse(JSON.stringify(this.studentList));
    }
};
</script>

<style scoped>
.mw-98{
    min-width: 98%;
}
.overflow-table{
    overflow: auto;
    max-width: 100%;
    max-height: 500px;
}
.table-header th{
    position: sticky;
    top: 0;
    background-color: #97dfe8;
}
</style>
