<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Duyệt minh chứng cá nhân</h3>
                                <h4>Thời gian kết thúc đánh giá:
                                    <span class="text-danger">{{ currentStudyTime.end_time_class_meet ? convertVnTime(currentStudyTime.end_time_class_meet) : 'Chưa mở đánh giá' }}</span>
                                </h4>
                                <h4 class="d-inline">Trạng thái:
                                    <span :class="currentStudyTime.end_time_class_meet && new Date(currentStudyTime.end_time_class_meet) >= new Date() ? 'text-success' : 'text-danger'">
                                        {{ currentStudyTime.end_time_class_meet ? new Date(currentStudyTime.end_time_class_meet) >= new Date() ? 'Đang diễn ra' : 'Đã kết thúc' : 'Chưa mở đánh giá' }}
                                    </span>
                                </h4>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="text-center mt-3" v-if="!currentStudyTime.end_time_class_meet || new Date(currentStudyTime.end_time_class_meet) < new Date()">
                        <span class="text-center">Kỳ đánh giá đã kết thúc hoặc chưa diễn ra.</span>
                    </div>
                    <div class="nk-block nk-block-lg" v-else>
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Danh sách tiêu chí</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Nội dung đánh giá</th>
                                        <th scope="col">Điểm tối đa</th>
                                        <th scope="col">Chờ đánh giá</th>
                                        <th scope="col">Hoạt động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(tc, index) in tcList" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{tc.name}}</td>
                                        <td><div class="text-center">{{tc.max_score}}</div></td>
                                        <td><div class="text-center">{{tc.wait_count}}</div></td>
                                        <td class="d-flex justify-content-center">
                                            <button v-if="tc.wait_count > 0"
                                                    class="btn btn-outline-primary"
                                                    @click="viewUserListConfirm(tc)"><em class="icon ni ni-eye"></em>Xem</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <ListStudentModal :tc-id="tcId" :listUser="listUser" @confirmed="onConfirmed"/>
                    </div><!-- nk-block -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import datetimeUtils from "../../helpers/utils/datetimeUtils";
import constants from '../../constants';
import ListStudentModal from "./child/ListStudentModal";
export default {
    components:{
        ListStudentModal
    },
    data(){
        return {
            tcList: [],
            tcId: null,
            listUser: [],
        }
    },
    computed:{
        currentStudyTime(){
            return this.$store.getters['studyTime/getStudyTimeCurrent'];
        },
    },
    methods:{
        ...mapActions({
            getCurrentStudyTime: 'studyTime/getCurrentStudyTime',
            getTcProoves: 'personalScore/getTcProoves',
            getListUserConfirm: 'personalScore/getListUserConfirm',
        }),
        convertVnTime(time){
            return time ? datetimeUtils.dateTimeVnFormat(time) : null;
        },
        async viewUserListConfirm(tc){
            this.tcId = tc.id;
            this.$loading(true);
            await this.getListUserConfirm(tc.id).then(res => this.listUser = [...res.data]);
            this.$loading(false);
            this.$nextTick(() => {
                $('#userListConfirm').modal('show');
            })
        },
        async onConfirmed(id){
            this.listUser = this.listUser.filter(_item => _item.id != id);
            await this.getTcProoves().then(res => this.tcList = [...res.data]);
            await this.getListUserConfirm(this.tcId).then(res => this.listUser = [...res.data]);
            if(!this.listUser.length){
                this.$nextTick(() => {
                    $('#userListConfirm').modal('hide');
                })
            }
        }
    },
    async mounted(){
        this.$loading(true);
        await this.getTcProoves().then(res => this.tcList = [...res.data]);
        this.$loading(false);
    },
}
</script>

<style scoped>
</style>
