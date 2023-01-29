<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="viewNotification">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Thông tin nhiệm vụ</h5></div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="h5 ml-auto col-10">{{notifyInfo.name}}</label>
                            <label class="form-label">Thời gian bắt đầu:&nbsp;</label><span>{{notifyInfo.start_time}}</span><br>
                            <label class="form-label">Thời gian kết thúc:&nbsp;</label><span>{{notifyInfo.end_time}}</span>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="form-group">
                            <label class="form-label">Ghi chú</label>
                            <div class="form-control-wrap" v-html="notifyInfo.details"></div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="form-group">
                            <label class="form-label">Tệp đính kèm</label>
                            <div class="form-control-wrap d-block">
                                <a class="d-block blue-text" :href="file.file_path" :download="file.file_name" v-for="(file, index) in notifyInfo.files" :key="index">{{file.file_name}}</a>
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
export default {
    props:{
        notifyInfo: {
            type: Object
        },
    },
    methods:{
        closeModal(){
            this.$emit('closeModal');
        },
    }
};
</script>

<style scoped>
.blue-text{
    color: #2828e7;
    text-decoration: underline;
}
</style>
