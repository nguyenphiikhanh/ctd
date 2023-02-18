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
                    <label class="form-label">Mã Đoàn viên</label>
                    <small class="text-warning">(Mã đoàn viên là tài khoản đăng nhập)</small>
                    <div class="form-control-wrap">
                        <input  v-model="studentCreateOrUpdate.username" class="form-control" placeholder="Mã Đoàn viên">
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
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Mật khẩu đăng nhập</label>
                    <div class="form-control-wrap">
                        <input type="password" v-model="studentCreateOrUpdate.password" class="form-control" placeholder="Nhập mật khẩu đăng nhập">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button :disabled="!isValid" @click="onSave()" class="btn btn-primary">Thêm</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props:{
        createFlg:{type: Boolean, default: false},
        studentInfo: {type: Object, default: {}},
    },
    computed:{
        studentCreateOrUpdate:{
            get(){
                return this.studentInfo;
            },
            set(val){
                this.$emit('changeObject', val);
            }
        },
        modalTitle(){
            return this.createFlg ? 'Thêm Đoàn viên mới' : 'Chỉnh sửa thông tin Đoàn viên';
        },
        isValid(){
            return this.studentCreateOrUpdate.username && this.studentCreateOrUpdate.ho
            && this.studentCreateOrUpdate.ten && this.studentCreateOrUpdate.email
            && this.studentCreateOrUpdate.password;
        }
    },
    methods:{
        closeModal(){
            this.$emit('closeModal');
        },
        onSave(){
            this.$emit('onSave', this.createFlg);
        }
    }

}
</script>

<style>

</style>
