<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewNotification">
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
                            <label class="form-label">Ghi chú:</label>
                            <div class="form-control-wrap" v-if="notifyInfo.details" v-html="notifyInfo.details"></div>
                            <div class="form-control-wrap" v-if="!notifyInfo.details">Không có ghi chú.</div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="form-group">
                            <label class="form-label">Tệp đính kèm</label>
                            <div class="form-control-wrap" v-if="notifyInfo.files.length == 0">Không có tệp đính kèm.</div>
                            <div class="form-control-wrap d-block">
                                <a class="d-block blue-text" :href="file.file_path" :download="file.file_name" v-for="(file, index) in notifyInfo.files" :key="index">{{file.file_name}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2" v-if="user.role == role.ROLE_SINH_VIEN">
                        <div class="form-group">
                            <label class="form-label">Ghi chú từ Bí thư chi Đoàn:</label>
                            <div class="form-control-wrap" v-if="notifyInfo.small_role_details" v-html="notifyInfo.small_role_details"></div>
                            <div class="form-control-wrap" v-if="!notifyInfo.small_role_details">Không có ghi chú.</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Trạng thái:&nbsp;</label>
                            <span class="badge bg-success" v-if="notifyInfo.status == status.STATUS_HOAN_THANH">Đã hoàn thành</span>
                            <span class="badge bg-danger" v-if="notifyInfo.status == status.STATUS_CHUA_HOAN_THANH">Chưa hoàn thành</span>
                        </div>
                    </div>
                    <div class="col-12" v-if="canUploadProof">
                        <div class="form-group">
                            <input type="file" ref="proof" class="d-none" @change="uploadProof($event.target.files)" multiple accept=".png, .jpg, .jpeg">
                            <button @click="$refs.proof.click()" class="btn btn-lg btn-info">
                                <em class="icon ni ni-upload"></em>
                                {{ proofContent }}</button>
                            <button v-if="proof.length" @click="sendProof()" class="btn btn-lg btn-primary">Gửi</button>
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
import constants from '../../../../constants';
export default {
    props:{
        notifyInfo: {
            type: Object
        },
    },
    data(){
        return{
            proof: [],
        }
    },
    methods:{
        closeModal(){
            this.proof = [];
            if(this.canUploadProof){
                this.$refs.proof.value = null;
            }
            this.$emit('closeModal');
        },
        uploadProof(proofFiles){
            this.proof = [...proofFiles];
            const validFileExtensions = ['image/png','image/jpeg','image/jpg'];
            for(let i = 0; i < this.proof.length; i++){
                let file = this.proof[i];
                if(!validFileExtensions.includes(file.type)){
                    alert('Vui lòng chỉ chọn tệp ảnh có định dạng .png/.jpeg/.jpg');
                    this.proof = [];
                    this.$refs.proof.value = null;
                    break;
                }
            }
        },
        sendProof(){
            alert('đã gửi minh chứng');
        }
    },
    computed:{
        role(){
            return constants.roles;
        },
        user(){
            return this.$store.getters['auth/user'];
        },
        status(){
            return constants.status;
        },
        action(){
            return constants.HOAT_DONG;
        },
        canUploadProof(){
            return (this.notifyInfo.child_activity_type == this.action.THONG_BAO_C0_PHAN_HOI_THAM_GIA
            || this.notifyInfo.child_activity_type == this.action.THONG_BAO_C0_PHAN_HOI_THAM_DU)
            && this.notifyInfo.status == this.status.STATUS_CHUA_HOAN_THANH;
        },
        proofContent(){
            if(this.proof.length == 0){
                return 'Gửi minh chứng';
            }
            else{
                if(this.proof.length == 1){
                    return this.proof[0].name;
                }
                else return `${this.proof.length} tệp đính kèm`;
            }
        }
    }
};
</script>

<style scoped>
.blue-text{
    color: #2828e7;
    text-decoration: underline;
}
</style>
