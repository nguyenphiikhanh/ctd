<template>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="createOrUpdateDialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header"><h5 class="modal-title">{{modalTitle}}</h5></div>
        <div class="modal-body">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Mã sinh viên</label>
                    <small class="text-warning">(Mã sinh viên là tài khoản đăng nhập)</small>
                    <div class="form-control-wrap">
                        <input  v-model="studentCreateOrUpdate.username" class="form-control" placeholder="Mã Sinh viên">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Họ và tên đệm</label>
                    <div class="form-control-wrap">
                        <input  v-model="studentCreateOrUpdate.ho" class="form-control" placeholder="Họ và tên đệm">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Tên</label>
                    <div class="form-control-wrap">
                        <input  v-model="studentCreateOrUpdate.ten" class="form-control" placeholder="Tên">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Địa chỉ Email</label>
                    <div class="form-control-wrap">
                        <input type="email" v-model="studentCreateOrUpdate.email" class="form-control" placeholder="Địa chỉ email">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2" v-if="createFlg">
                <div class="form-group">
                    <label class="form-label">Mật khẩu đăng nhập</label>
                    <div class="form-control-wrap">
                        <input type="password" v-model="studentCreateOrUpdate.password" class="form-control" placeholder="Nhập mật khẩu đăng nhập">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button :disabled="!isValid" @click="onSave()" class="btn btn-primary">{{createFlg ? 'Thêm' : 'Lưu'}}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    props:{
        createFlg:{type: Boolean, default: false},
        studentInfo: {type: Object, default: {}},
    },
    computed:{
        studentCreateOrUpdate:{
            get(){
                return this.createFlg ? this.studentInfo : JSON.parse(JSON.stringify(this.studentInfo));
            },
            set(val){
                this.$emit('changeObject', val);
            }
        },
        modalTitle(){
            return this.createFlg ? 'Thêm sinh viên mới' : 'Chỉnh sửa thông tin sinh viên';
        },
        isValid(){
            if(this.createFlg){
                return this.studentCreateOrUpdate.username && this.studentCreateOrUpdate.ho
                    && this.studentCreateOrUpdate.ten && this.studentCreateOrUpdate.email
                    && this.studentCreateOrUpdate.password;
            }
            else{
                return this.studentCreateOrUpdate.username && this.studentCreateOrUpdate.ho
                    && this.studentCreateOrUpdate.ten && this.studentCreateOrUpdate.email;
            }
        }
    },
    methods:{
        ...mapActions({
            updateStudent: 'student/updateStudent'
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
                const data = this.studentCreateOrUpdate;
                await this.updateStudent(data);
                this.$loading(false);
            }
            this.$emit('onSave', this.createFlg);
        }
    }

}
</script>

<style>

</style>
