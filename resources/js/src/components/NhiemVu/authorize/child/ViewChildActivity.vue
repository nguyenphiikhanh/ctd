<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewChildAct">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Thông tin hoạt động</h5></div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="h5 ml-auto col-10">{{childActInfo.name}}</label><br>
                            <label class="form-label">Thời gian</label><br>
                            <label class="form-label">Thời gian bắt đầu:&nbsp;</label><span>{{childActInfo.start_time}}</span><br>
                            <label class="form-label">Thời gian kết thúc:&nbsp;</label><span>{{childActInfo.end_time}}</span>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="form-group">
                            <label class="form-label">Nội dung:</label>
                            <div class="form-control-wrap" v-if="childActInfo.details" v-html="childActInfo.details"></div>
                            <div class="form-control-wrap" v-if="!childActInfo.details">Không có nội dung.</div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="form-group">
                            <label class="form-label">Tệp đính kèm:</label>
                            <div class="form-control-wrap" v-if="childActInfo.files.length == 0">Không có tệp đính kèm.</div>
                            <div class="form-control-wrap d-block">
                                <a class="d-block mb-1" :href="file.file_path" :download="file.file_name" v-for="(file, index) in childActInfo.files" :key="index">
                                    <button class="btn btn-light w-100">
                                        <em class="icon ni ni-file"></em>
                                        {{file.file_name}}
                                    </button>
                                </a>
                            </div>
                        </div>
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
        childActInfo: {
            type: Object
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
    },
};
</script>

<style scoped>
.blue-text{
    color: #2828e7;
    text-decoration: underline;
}
</style>
