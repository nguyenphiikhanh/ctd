<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Khóa đào tạo</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <button @click="showPopup(true)" type="button" class="btn btn-primary d-none d-md-inline-flex">
                                                    <em class="icon ni ni-plus"></em>
                                                    <span>Thêm khóa đào tạo</span>
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
                                <h5 class="nk-block-title">Danh sách khóa đào tạo</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên khóa đào tạo</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in listKhoaDaoTao" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{_item.term_name}}</td>
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
                        <div v-if="listKhoaDaoTao.length == 0" class="text-center col-12">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                    <create-or-update-dialog :createFlg="createFlg" :tenKhoa="tenKhoa" @onSave="onSave" @closeModal="closeModal()" @changeName="changeName"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { asyncLoading } from 'vuejs-loading-plugin';
import { mapActions } from 'vuex';
import createOrUpdateDialog from './child/CreateOrUpdatePopUp.vue';
export default {
    components:{
        createOrUpdateDialog,
    },
    data(){
        return{
            id: null,
            listKhoaDaoTao: [],
            createFlg: true,
            tenKhoa: ''
        }
    },
    methods:{
        ...mapActions({
            getTermList: 'khoaDaoTao/getTermList',
            createTerm: 'khoaDaoTao/createTerm',
        }),
        async getTermListData(){
            const params = {};
            await this.getTermList(params).then(res => this.listKhoaDaoTao = [...res.data]);
        },
        showPopup(createFlg = true){
            if(!createFlg){
                this.createFlg = createFlg;
            }

            this.$nextTick(() => {
                $('#createOrUpdateDialog').modal('show');
            });
        },
        changeName(val){
            this.tenKhoa = val;
        },
        async onSave(createFlg){
            this.$loading(true);
            let data = {
                term_name: this.tenKhoa,
            };
            if(createFlg){
                await this.createTerm(data);
            }
            else{

            }
            this.$loading(false);
            this.closeModal();
            await asyncLoading(this.getTermListData());
        },
        closeModal(){
            this.$nextTick(() => {
                this.createFlg = true;
                this.tenKhoa = '';
                $('#createOrUpdateDialog').modal('hide');
            });
        }
    },
    mounted(){
        asyncLoading(this.getTermListData());
    }
}
</script>

<style>

</style>
