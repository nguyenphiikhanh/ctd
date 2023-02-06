<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Quản lý Sinh viên</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <button @click="showPopup(true)" type="button" class="btn btn-primary d-none d-md-inline-flex">
                                                    <em class="icon ni ni-plus"></em>
                                                    <span>Thêm Sinh viên</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <h4>Lớp: <span class="text-danger">{{ classInfo.class_name }}</span></h4>
                        <h4>Khoa: <span class="text-danger">{{ classInfo.faculty_name }}</span></h4>
                        <h4>Khóa: <span class="text-danger">{{ classInfo.term_name }}</span></h4>
                        <h4>Khối đào tạo: <span class="text-danger">{{ classInfo.type_name }}</span></h4>
                        <h4>Bí thư lớp:
                            <span :class="cbStudent ? 'text-danger' : 'text-info'">{{ cbStudent ? cbStudent.ho + ' ' + cbStudent.ten : 'Chưa có' }}</span>
                            <button @click="changeCbPopup()" class="btn btn-sm btn-outline-primary"><em class="icon ni ni-repeat"></em></button>
                        </h4>
                        <h4>Lớp trưởng: <span class="text-info">Chưa có </span>
                        <button class="btn btn-sm btn-outline-primary"><em class="icon ni ni-repeat"></em></button>
                        </h4>
                    </div>
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Danh sách lớp</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Mã Sinh viên</th>
                                        <th scope="col">Tên Sinh  viên</th>
                                        <th scope="col">Địa chỉ Email</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in studentList" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{_item.username}}</td>
                                        <td>{{_item.ho + ' ' + _item.ten}}</td>
                                        <td>{{_item.email}}</td>
                                        <td class="d-flex justify-content-end">
                                            <div>
                                            <button class="btn btn-sm btn-info">Sửa</button>
                                            <button class="btn btn-sm btn-danger mr-2">Xóa</button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="studentList.length == 0" class="text-center col-12 mt-5">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                    <create-or-update-dialog :createFlg="createFlg" :student-info="studentInfo"
                     @onSave="onSave" @closeModal="closeModal()" @changeObject="changeObject"/>
                     <CBSettings @onSave="saveChangeCb()" @closeModal="closeModal()" :student-list="studentList" :id_cbl="cbStudent?.id" :class_id="Number($route.params.id)"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { asyncLoading } from 'vuejs-loading-plugin';
import { mapActions } from 'vuex';
import createOrUpdateDialog from './child/CreateOrUpdateStudent.vue';
import CBSettings from './child/CBSettings.vue';
import constants from '../../../constants';
export default {
    components:{
        createOrUpdateDialog,
        CBSettings,
    },
    data(){
        return{
            studentList: [],
            createFlg: true,
            classInfo: {},
            studentInfo:{
                id: null,
                id_class: null,
                ho: '',
                ten: '',
                username: '',
                password: '',
                email: '',
            },
        }
    },
    computed:{
        cbStudent(){
            const cb = this.studentList.find(_item => _item.role == constants.roles.ROLE_CBL);
            return cb || null;
        }
    },
    methods:{
        ...mapActions({
            getClassInfo: 'classes/getClassInfo',
            getStudentByClass: 'student/getStudentByClass',
            createStudent: 'student/createStudent',
        }),
        async getStudentList(){
            const class_id = this.$route.params.id;
            await this.getStudentByClass(class_id).then(res => this.studentList = [...res.data]);
        },
        showPopup(createFlg = true){
            if(!createFlg){
                this.createFlg = createFlg;
            }

            this.$nextTick(() => {
                $('#createOrUpdateDialog').modal('show');
            });
        },
        changeObject(val){
            this.studentInfo = val;
        },
        async onSave(createFlg){
            this.studentInfo.id_class = this.$route.params.id;
            this.$nextTick(() => {
                $('#createOrUpdateDialog').modal('hide');
            });
            this.$loading(true);
            if(createFlg){
                await this.createStudent(this.studentInfo);
            }
            else{

            }
            this.$loading(false);
            this.closeModal();
            await asyncLoading(this.getStudentList());
        },
        closeModal(){
            this.$nextTick(() => {
                this.createFlg = true;
                this.studentInfo = {
                id: null,
                id_class: '',
                ho: '',
                ten: '',
                username: '',
                email: '',
                };
                $('#createOrUpdateDialog').modal('hide');
                $('#cbSettings').modal('hide');
            });
        },
        changeCbPopup(){
            this.$nextTick(() => {
                $('#cbSettings').modal('show');
            });
        },
        saveChangeCb(){
            this.closeModal();
            asyncLoading(this.getStudentList());
        }
    },
    mounted(){
        asyncLoading(this.getStudentList());
        const id_class = this.$route.params.id;
        asyncLoading(this.getClassInfo(id_class).then(res => this.classInfo = {...res.data}));
    }
}
</script>

<style>

</style>
