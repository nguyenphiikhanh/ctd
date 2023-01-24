<template>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="cbSettings">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header"><h5 class="modal-title">{{modalTitle}}</h5></div>
        <div class="modal-body">
            <div class="col-12">
                <label class="h6 col-12">Chọn cán bộ chi Đoàn </label>
                <ul class="custom-control-group">
                    <li v-for="(option, ind) in studentList" :key="ind" class="col-12">
                        <div class="custom-control custom-radio custom-control-pro no-control col-12">
                            <input :disabled="option.id == id_cbl" v-model="id" type="radio" :value="option.id" name="std-cbl" class="custom-control-input" :id="`student-${ind}`">
                            <label class="custom-control-label col-12" :for="`student-${ind}`">{{option.ho + ' ' + option.ten}} - {{ option.username }}</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button :disabled="!isValid" @click="onSave()" class="btn btn-primary">Lưu</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    props:{
        id_cbl: {type: Number, default: null},
        class_id: {type: Number, default: null},
        studentList: {type: Array}
    },
    data(){
        return{
            id: this.id_cbl,
        }
    },
    computed:{
        modalTitle(){
            return 'Thay đổi Cán bộ chi Đoàn'
        },
        isValid(){
            return this.id && this.id != this.id_cbl;
        }
    },
    methods:{
        ...mapActions({
            changeCbSetting: 'student/changeCbSetting',
        }),
        closeModal(){
            this.id = this.id_cbl;
            this.$emit('closeModal');
        },
        async onSave(){
            this.$nextTick(() => {
                $('#cbSettings').modal('hide');
            });
            this.$loading(true);
            const data = {
                cbId: this.id,
                id_class: this.class_id
            }
            await this.changeCbSetting(data);
            this.$loading(false);
            this.$emit('onSave');
        }
    },
}
</script>

<style>

</style>
