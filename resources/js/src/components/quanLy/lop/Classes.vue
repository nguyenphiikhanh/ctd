<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Quản lý lớp</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <button @click="showPopup(true)" type="button" class="btn btn-primary d-none d-md-inline-flex">
                                                    <em class="icon ni ni-plus"></em>
                                                    <span>Thêm lớp</span>
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
                                <h5 class="nk-block-title">Danh sách lớp</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên lớp</th>
                                        <th scope="col">Khối</th>
                                        <th scope="col">Khóa đào tạo</th>
                                        <th scope="col">Số lượng sinh viên</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in classList" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{_item.class_name}}</td>
                                        <td>{{_item.type_name}}</td>
                                        <td>{{_item.term_name}}</td>
                                        <td>{{_item.student_count}}</td>
                                        <td class="d-flex justify-content-end">
                                            <div>
                                            <router-link :to="`lop-${_item.id}/danh-sach-sinh-vien`" target="_blank">
                                                <button class="btn btn-sm btn-primary">Danh sách Sinh viên</button>
                                            </router-link>
                                            <button class="btn btn-sm btn-info">Sửa</button>
                                            <button class="btn btn-sm btn-danger mr-2">Xóa</button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="classList.length == 0" class="text-center col-12 mt-5">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                    <create-or-update-dialog :createFlg="createFlg" :terms="terms" :classTypes="classTypes" :classObject="classObject"
                     @onSave="onSave" @closeModal="closeModal()" @changeObject="changeObject"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { asyncLoading } from 'vuejs-loading-plugin';
import { mapActions } from 'vuex';
import createOrUpdateDialog from './child/CreateOrUpdateClass.vue';
export default {
    components:{
        createOrUpdateDialog,
    },
    data(){
        return{
            classList: [],
            createFlg: true,
            classTypes: [],
            classObject:{
                id: null,
                class_name: '',
                id_class_type: null,
                id_faculty: null,
                id_term: null,
                id_user_cvht: null,
            },
            terms: [],
        }
    },
    methods:{
        ...mapActions({
            getClasses: 'classes/getClasses',
            getClassTypes: 'classes/getClassTypes',
            getTermList: 'khoaDaoTao/getTermList',
            createClass: 'classes/createClass'
        }),
        async getClassListData(){
            const params = {};
            await this.getClasses(params).then(res => this.classList = [...res.data]);
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
            this.classObject = val;
        },
        async onSave(createFlg){
            this.$nextTick(() => {
                $('#createOrUpdateDialog').modal('hide');
            });
            this.$loading(true);
            if(createFlg){
                await this.createClass(this.classObject);
            }
            else{

            }
            this.$loading(false);
            this.closeModal();
            await asyncLoading(this.getClassListData());
        },
        closeModal(){
            this.$nextTick(() => {
                this.createFlg = true;
                this.tenKhoa = '';
                $('#createOrUpdateDialog').modal('hide');
            });
        },
    },
    mounted(){
        asyncLoading(this.getClassTypes().then(res => this.classTypes = [...res.data]));
        asyncLoading(this.getClassListData());
        const data = {
            getAllFlg: true
        }
        asyncLoading(this.getTermList(data).then(res => this.terms = [...res.data]));
    }
}
</script>

<style>

</style>
