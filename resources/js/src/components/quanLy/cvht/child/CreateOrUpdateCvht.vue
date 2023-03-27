<template>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="createOrUpdateDialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form @submit.prevent="onSave()" >
            <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header"><h5 class="modal-title">{{modalTitle}}</h5></div>
        <div class="modal-body">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Tên đăng nhập</label>
                    <div class="form-control-wrap">
                        <input  v-model="cvhtCreateOrUpdate.username" class="form-control" placeholder="Tên đăng nhập">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Họ và tên đệm</label>
                    <div class="form-control-wrap">
                        <input  v-model="cvhtCreateOrUpdate.ho" class="form-control" placeholder="Họ và tên đệm">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Tên</label>
                    <div class="form-control-wrap">
                        <input  v-model="cvhtCreateOrUpdate.ten" class="form-control" placeholder="Tên">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Địa chỉ Email</label>
                    <div class="form-control-wrap">
                        <input type="email" v-model="cvhtCreateOrUpdate.email" class="form-control" placeholder="Địa chỉ email">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2" v-if="createFlg">
                <div class="form-group">
                    <label class="form-label">Mật khẩu đăng nhập</label>
                    <div class="form-control-wrap">
                        <input type="password" v-model="cvhtCreateOrUpdate.password" class="form-control" placeholder="Nhập mật khẩu đăng nhập">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button :disabled="!isValid" type="submit" class="btn btn-primary">{{createFlg ? 'Thêm' : 'Lưu'}}</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    props:{
        createFlg:{type: Boolean, default: false},
        cvhtInfo: {type: Object, default: {}},
    },
    computed:{
        cvhtCreateOrUpdate:{
            get(){
                return this.createFlg ? this.cvhtInfo : JSON.parse(JSON.stringify(this.cvhtInfo));
            },
            set(val){
                this.$emit('changeObject', val);
            }
        },
        modalTitle(){
            return this.createFlg ? 'Thêm CVHT mới' : 'Chỉnh sửa thông tin CVHT';
        },
        isValid(){
            if(this.createFlg){
                return this.cvhtCreateOrUpdate.username && this.cvhtCreateOrUpdate.ho
                    && this.cvhtCreateOrUpdate.ten && this.cvhtCreateOrUpdate.email
                    && this.cvhtCreateOrUpdate.password;
            }
            else{
                return this.cvhtCreateOrUpdate.username && this.cvhtCreateOrUpdate.ho
                    && this.cvhtCreateOrUpdate.ten && this.cvhtCreateOrUpdate.email;
            }
        }
    },
    methods:{
        ...mapActions({
            updateCvht: 'userModule/updateCvht'
        }),
        closeModal(){
            this.$emit('closeModal');
        },
        async onSave(){
            this.$nextTick(() => {
                $('#createOrUpdateDialog').modal('hide');
            });
            if(!this.createFlg){
                this.$loading(true);
                const data = this.cvhtCreateOrUpdate;
                await this.updateCvht(data);
                this.$loading(false);
            }
            this.$emit('onSave', this.createFlg);
        }
    }

}
</script>

<style>

</style>
