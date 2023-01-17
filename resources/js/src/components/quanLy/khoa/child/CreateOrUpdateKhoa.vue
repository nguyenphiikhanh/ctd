<template>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="createOrUpdateDialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header"><h5 class="modal-title">{{modalTitle}}</h5></div>
        <div class="modal-body">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Tên Liên chi Đoàn</label>
                    <div class="form-control-wrap">
                        <input  v-model="ten_khoa_dao_tao" class="form-control" placeholder="Tên Liên chi Đoàn">
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
        tenKhoa: {type: String, default: {}},
    },
    data(){
        return{
        }
    },
    computed:{
        ten_khoa_dao_tao:{
            get(){
                return this.tenKhoa;
            },
            set(val){
                this.$emit('changeName', val);
            }
        },
        modalTitle(){
            return this.createFlg ? 'Thêm Liên chi Đoàn mới' : 'Chỉnh sửa Liên chi Đoàn';
        },
        isValid(){
            return this.tenKhoa;
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
