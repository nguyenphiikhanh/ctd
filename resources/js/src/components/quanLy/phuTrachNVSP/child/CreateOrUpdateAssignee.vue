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
                        <input  v-model="assigneeCreateOrUpdate.username" class="form-control" placeholder="Tên đăng nhập">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Họ và tên đệm</label>
                    <div class="form-control-wrap">
                        <input  v-model="assigneeCreateOrUpdate.ho" class="form-control" placeholder="Họ và tên đệm">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Tên</label>
                    <div class="form-control-wrap">
                        <input  v-model="assigneeCreateOrUpdate.ten" class="form-control" placeholder="Tên">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Địa chỉ Email</label>
                    <div class="form-control-wrap">
                        <input type="email" v-model="assigneeCreateOrUpdate.email" class="form-control" placeholder="Địa chỉ email">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2" v-if="createFlg">
                <div class="form-group">
                    <label class="form-label">Mật khẩu đăng nhập</label>
                    <div class="form-control-wrap">
                        <input type="password" v-model="assigneeCreateOrUpdate.password" class="form-control" placeholder="Nhập mật khẩu đăng nhập">
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
        assigneeInfo: {type: Object, default: {}},
    },
    computed:{
        assigneeCreateOrUpdate:{
            get(){
                return this.createFlg ? this.assigneeInfo : JSON.parse(JSON.stringify(this.assigneeInfo));
            },
            set(val){
                this.$emit('changeObject', val);
            }
        },
        modalTitle(){
            return this.createFlg ? 'Thêm phụ trách viên mới' : 'Chỉnh sửa thông tin phụ trách viên';
        },
        isValid(){
            if(this.createFlg){
                return this.assigneeCreateOrUpdate.username && this.assigneeCreateOrUpdate.ho
                    && this.assigneeCreateOrUpdate.ten && this.assigneeCreateOrUpdate.email
                    && this.assigneeCreateOrUpdate.password;
            }
            else{
                return this.assigneeCreateOrUpdate.username && this.assigneeCreateOrUpdate.ho
                    && this.assigneeCreateOrUpdate.ten && this.assigneeCreateOrUpdate.email;
            }
        }
    },
    methods:{
        ...mapActions({
            updateAssignee: 'userModule/updateAssignee'
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
                const data = this.assigneeCreateOrUpdate;
                await this.updateAssignee(data);
                this.$loading(false);
            }
            this.$emit('onSave', this.createFlg);
        }
    }

}
</script>

<style>

</style>
