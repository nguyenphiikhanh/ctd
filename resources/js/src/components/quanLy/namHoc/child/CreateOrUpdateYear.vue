<template>
    <div class="modal fade" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" id="createOrUpdateDialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header"><h5 class="modal-title">{{modalTitle}}</h5></div>
        <div class="modal-body">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Tên năm học</label>
                    <div class="form-control-wrap">
                        <input v-model="tenNamHoc" class="form-control" placeholder="Tên năm học">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button :disabled="!isValid" @click="onSave()" class="btn btn-primary">{{ createFlg ? 'Thêm' : 'Lưu' }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props:{
        createFlg:{type: Boolean, default: false},
        id: {type: Number},
        yearName: {type: String, default: {}},
    },
    data(){
        return{
        }
    },
    computed:{
        tenNamHoc:{
            get(){
                return this.yearName;
            },
            set(val){
                this.$emit('changeName', val);
            }
        },
        modalTitle(){
            return this.createFlg ? 'Thêm năm học mới' : 'Chỉnh sửa năm học';
        },
        isValid(){
            return this.yearName;
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
