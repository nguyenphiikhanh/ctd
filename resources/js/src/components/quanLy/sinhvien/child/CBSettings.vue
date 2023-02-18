<template>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="cbSettings">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header"><h5 class="modal-title">{{modalTitle}}</h5></div>
        <div class="modal-body">
            <div class="col-12">
                <label class="h6 col-12 mb-2">Chọn cán bộ lớp</label>
                <ul class="custom-control-group">
                    <li v-for="(option, ind) in studentList" :key="ind" class="col-12">
                        <div class="custom-control custom-radio custom-control-pro no-control col-12">
                            <input v-if="choose_cbl" :disabled="option.id == btId || option.id == ltId" v-model="id_bt" type="radio" :value="option.id" name="std-cbl" class="custom-control-input" :id="`student-${ind}`">
                            <input v-if="!choose_cbl" :disabled="option.id == btId || option.id == ltId" v-model="id_lt" type="radio" :value="option.id" name="std-cbl" class="custom-control-input" :id="`student-${ind}`">
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
        btId: {type: Number, default: null},
        ltId: {type: Number, default: null},
        class_id: {type: Number, default: null},
        choose_cbl: {type: Boolean},
        studentList: {type: Array}
    },
    data(){
        return{
            id_bt: this.btId,
            id_lt: this.ltId,
        }
    },
    computed:{
        modalTitle(){
            return this.choose_cbl ? 'Thay đổi Bí thư Lớp' : 'Thay đổi lớp trưởng';
        },
        isValid(){
            return this.id_bt && this.id_bt != this.btId
            || this.id_lt && this.id_lt != this.ltId;
        }
    },
    methods:{
        ...mapActions({
            changeCbSetting: 'student/changeCbSetting',
        }),
        closeModal(){
            this.id_bt = this.btId;
            this.id_lt = this.ltId;
            this.$emit('closeModal');
        },
        async onSave(){
            this.$nextTick(() => {
                $('#cbSettings').modal('hide');
            });
            this.$loading(true);
            const data = {
                btId: this.id_bt,
                ltId: this.id_lt,
                btChange: this.choose_cbl,
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
