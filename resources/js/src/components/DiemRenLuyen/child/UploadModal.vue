<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" id="uploadModal">
        <div class="modal-dialog modal-dialog-top" role="document">
            <div class="modal-content mh-90">
                <a @click="closeModal()" class="close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Gửi minh chứng</h5></div>
                <div class="modal-body">
                    <p class="mt-3 text-info">Chọn minh chứng gửi lên và chờ xét duyệt, vui lòng chỉ chọn file ảnh có định dạng .jpg/.jpeg./png</p>
                    <div class="col-12 d-flex justify-content-center" >
                        <input type="file" ref="proof" class="d-none" @change="uploadProof($event.target.files)" multiple accept=".png, .jpg, .jpeg">
                        <button class="btn btn-lg btn-outline-success mr-2"
                                @click="$refs.proof.click()">
                            <em class="icon ni ni-upload"></em>{{ proofContent }}
                        </button>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <button v-if="prooves.length" @click="sendProof()"
                                class="btn btn-lg btn-primary">Gửi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {mapActions} from "vuex";

export default {
    props:{
        tcInfo: {type: Object, default: {}},
    },
    data(){
        return {
            prooves: [],
        }
    },
    methods:{
        ...mapActions({
            uploadProoves: 'personalScore/sendProof',
        }),
        uploadProof(proofFiles){
            this.prooves = [...proofFiles];
            const validFileExtensions = ['image/png','image/jpeg','image/jpg'];
            for(let i = 0; i < this.prooves.length; i++){
                let file = this.prooves[i];
                if(!validFileExtensions.includes(file.type)){
                    this.$swal.fire(
                        'Vui lòng chỉ chọn tệp ảnh có định dạng .png/.jpeg/.jpg!',
                        '',
                        'error'
                        )
                    this.prooves = [];
                    this.$refs.proof.value = null;
                    break;
                }
            }
        },
        async sendProof(){
            this.$nextTick(() => {
                $('#uploadModal').modal('hide');
            })
            this.$loading(true);
            const formData = new FormData();
            formData.append('id', this.tcInfo.id);
            for(let i = 0; i < this.prooves.length; i++){
                let file = this.prooves[i];
                formData.append('files[' + i + ']', file);
            }
            await this.uploadProoves(formData);
            this.closeModal();
            this.$loading(false);
            this.$emit('proofUploaded');
        },
        closeModal(){
            this.prooves = [];
            this.$refs.proof.value = null;
            this.$nextTick(() => {
                $('#uploadModal').modal('hide');
            });
        }
    },
    computed:{
        proofContent(){
            if(this.prooves.length == 0){
                return 'Gửi minh chứng';
            }
            else{
                if(this.prooves.length == 1){
                    return this.prooves[0].name;
                }
                else return `${this.prooves.length} tệp đính kèm`;
            }
        }
    }
}
</script>

<style scoped>
.mw-80{
    min-width: 80%;
}
</style>
