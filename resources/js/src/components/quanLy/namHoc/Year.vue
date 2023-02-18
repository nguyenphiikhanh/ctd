<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Quản lý Năm học</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <button @click="showPopup()" type="button" class="btn btn-primary d-none d-md-inline-flex">
                                                    <em class="icon ni ni-plus"></em>
                                                    <span>Thêm năm học mới</span>
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
                                <h5 class="nk-block-title">Danh sách năm học</h5>
                            </div>
                        </div>
                        <div class="card card-preview">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên năm học</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(_item, index) in yearList" :key="index">
                                        <th scope="row">{{index + 1}}</th>
                                        <td>{{_item.year_name}}</td>
                                        <td class="d-flex justify-content-end">
                                            <div>
                                                <button @click="showPopup(false, _item)" class="btn btn-sm btn-info">Sửa</button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                        <div v-if="yearList.length == 0" class="text-center col-12">Không có dữ liệu.</div>
                    </div><!-- nk-block -->
                    <create-or-update-dialog :createFlg="createFlg" :year-name="yearName" :id="id" @onSave="onSave" @closeModal="closeModal()" @changeName="changeName"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { asyncLoading } from 'vuejs-loading-plugin';
import { mapActions } from 'vuex';
import createOrUpdateDialog from './child/CreateOrUpdateYear.vue';
export default {
    components:{
        createOrUpdateDialog,
    },
    data(){
        return{
            id: null,
            yearList: [],
            createFlg: true,
            yearName: '',
        }
    },
    methods:{
        ...mapActions({
            getStudyYear: 'studyYear/getStudyYear',
            createStudyYear: 'studyYear/createStudyYear',
            updateStudyYear: 'studyYear/updateStudyYear',
        }),
        async getYearList(){
            await this.getStudyYear().then(res => this.yearList = [...res.data]);
        },
        showPopup(createFlg = true, year = null){
            if(!createFlg){
                this.createFlg = createFlg;
                this.id = year.id;
                this.yearName = year.year_name;
            }
            console.log(year);
            this.$nextTick(() => {
                $('#createOrUpdateDialog').modal('show');
            });
        },
        changeName(val){
            this.yearName = val;
        },
        async onSave(createFlg){
            this.$loading(true);
            let data = {
                year_name: this.yearName,
            };
            this.$nextTick(() => {
                    $('#createOrUpdateDialog').modal('hide');
                });
            if(createFlg){
                await this.createStudyYear(data);
                await this.getYearList();
            }
            else{
                data.id = this.id;
                console.log('data',data);
                await this.updateStudyYear(data);
            }
            this.$loading(false);
            this.closeModal();
            await asyncLoading(this.getYearList());
        },
        closeModal(){
            this.$nextTick(() => {
                this.createFlg = true;
                this.yearName = '';
                $('#createOrUpdateDialog').modal('hide');
            });
        }
    },
    async mounted(){
        await asyncLoading(this.getYearList());
    }
}
</script>

<style>

</style>
