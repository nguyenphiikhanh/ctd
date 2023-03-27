<template>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="cvhtSetting">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header"><h5 class="modal-title">Chọn cố vấn học tập</h5></div>
        <div class="modal-body">
            <div class="col-12">
                <label class="h6 col-12 mb-2">Chọn cố vấn học tập</label>
                <ul class="custom-control-group">
                    <li v-for="(option, ind) in cvhts" :key="ind" class="col-12">
                        <div class="custom-control custom-radio custom-control-pro no-control col-12">
                            <input :disabled="option.id == classChoose.id_user_cvht" v-model="id_user" type="radio" :value="option.id" name="std-cbl" class="custom-control-input" :id="`cvht-${ind}`">
                            <label class="custom-control-label col-12" :for="`cvht-${ind}`">{{option.ho + ' ' + option.ten}} - {{ option.username }}</label>
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
        cvhts: {type: Array},
        classChoose: {type: Object}
    },
    data(){
        return{
            id_user: null,
        }
    },
    computed:{
        id_user_cvht:{
            get(){
                const act = JSON.parse(JSON.stringify(this.classChoose));
                this.id_user = act.id_user_cvht;
                return this.id_user;
            },
            set(val){
                this.id_user = val;
            }
        },
        isValid(){
            return this.id_user;
        }
    },
    methods:{
        ...mapActions({
            changeCvhtSetting: 'classes/changeCvhtSetting',
        }),
        closeModal(){
            this.id_user = null;
            this.$emit('closeModal');
        },
        async onSave(){
            this.$nextTick(() => {
                $('#cvhtSetting').modal('hide');
            });
            this.$loading(true);
            const act = JSON.parse(JSON.stringify(this.classChoose));
            const data = {
                id: act.id,
                id_user_cvht: this.id_user,
            }
            await this.changeCvhtSetting(data);
            this.$loading(false);
            this.id_user = null;
            this.$emit('onSave');
        }
    },
}
</script>

<style>

</style>
