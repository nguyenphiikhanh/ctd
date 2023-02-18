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
                    <label class="form-label">Tên lớp</label>
                    <div class="form-control-wrap">
                        <input  v-model="classCreateOrUpdate.class_name" class="form-control" placeholder="Tên lớp">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <label class="title form-label mb-3 mt-3 mr-3">Khối ngành đào tạo: </label>
                <ul class="custom-control-group">
                    <li v-for="(option, ind) in classTypes" :key="ind">
                        <div class="custom-control custom-radio custom-control-pro no-control">
                            <input v-model="classCreateOrUpdate.id_class_type" type="radio" :value="option.id" name="khoi-nganh" class="custom-control-input" :id="`nganh-${ind}`">
                            <label class="custom-control-label" :for="`nganh-${ind}`">{{option.type_name}}</label>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Khóa đào tạo</label>
                    <div class="form-control-wrap">
                        <select v-model="classCreateOrUpdate.id_term" class="form-control">
                            <option :value="null">--Chọn khóa đào tạo---</option>
                            <option v-for="option, ind in terms" :key="ind" :value="option.id">{{option.term_name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Khoa</label>
                    <div class="form-control-wrap">
                        <select v-model="classCreateOrUpdate.id_faculty" class="form-control">
                            <option :value="null">--Chọn khoa---</option>
                            <option v-for="option, ind in faculties" :key="ind" :value="option.id">{{option.faculty_name}}</option>
                        </select>
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
        classObject: {type: Object, default: {}},
        classTypes: {type: Array, default: []},
        faculties: {type: Array},
        terms:{type: Array}
    },
    computed:{
        classCreateOrUpdate:{
            get(){
                return this.classObject;
            },
            set(val){
                this.$emit('changeObject', val);
            }
        },
        modalTitle(){
            return this.createFlg ? 'Thêm lớp mới' : 'Chỉnh sửa chi Đoàn';
        },
        isValid(){
            return this.classCreateOrUpdate.class_name && this.classCreateOrUpdate.id_faculty
            && this.classCreateOrUpdate.id_class_type && this.classCreateOrUpdate.id_term;
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
