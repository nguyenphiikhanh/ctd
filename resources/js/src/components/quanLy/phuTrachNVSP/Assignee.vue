<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Quản lý phụ trách viên</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <button @click="showPopup(true)" type="button" class="btn btn-primary d-none d-md-inline-flex">
                                                    <em class="icon ni ni-plus"></em>
                                                    <span>Thêm phụ trách viên</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Danh sách phụ trách viên</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên đăng nhập</th>
                                        <th scope="col">Họ tên</th>
                                        <th scope="col">Địa chỉ Email</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in assigneeList" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{_item.username}}</td>
                                        <td>{{_item.ho + ' ' + _item.ten}}</td>
                                        <td>{{_item.email}}</td>
                                        <td class="d-flex justify-content-end">
                                            <div>
                                                <button class="btn btn-sm btn-info" @click="showPopup(false, _item)">Sửa</button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="assigneeList.length == 0" class="text-center col-12 mt-5">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                    <create-or-update-dialog :createFlg="createFlg" :assignee-info="asigneeInfo"
                     @onSave="onSave" @closeModal="closeModal()"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { asyncLoading } from 'vuejs-loading-plugin';
import { mapActions } from 'vuex';
import createOrUpdateDialog from './child/CreateOrUpdateAssignee.vue';
import constants from '../../../constants';
export default {
    components:{
        createOrUpdateDialog,
    },
    data(){
        return{
            assigneeList: [],
            createFlg: true,
            asigneeInfo:{
                id: null,
                ho: '',
                ten: '',
                username: '',
                password: '',
                email: '',
            },
        }
    },
    computed:{
    },
    methods:{
        ...mapActions({
            getAssignee: 'userModule/getAssignees',
            createAssignee: 'userModule/createAssignee',
        }),
        async getassigneeList(){
            await this.getAssignee().then(res => this.assigneeList = [...res.data]);
        },
        showPopup(createFlg = true, asigneeInfo = {}){
            if(!createFlg){
                this.createFlg = createFlg;
                this.asigneeInfo = asigneeInfo;
            }

            this.$nextTick(() => {
                $('#createOrUpdateDialog').modal('show');
            });
        },
        changeObject(val){
            this.asigneeInfo = val;
        },
        async onSave(createFlg){
            this.$loading(true);
            if(createFlg){
                await this.createAssignee(this.asigneeInfo);
            }
            else{

            }
            this.$loading(false);
            this.closeModal();
            await asyncLoading(this.getassigneeList());
        },
        closeModal(){
            this.$nextTick(() => {
                this.createFlg = true;
                this.asigneeInfo = {
                id: null,
                id_class: '',
                ho: '',
                ten: '',
                username: '',
                email: '',
                };
                $('#createOrUpdateDialog').modal('hide');
            });
        },
    },
    async mounted(){
        await asyncLoading(this.getassigneeList());
    }
}
</script>

<style>

</style>
