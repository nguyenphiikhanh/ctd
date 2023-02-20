<template>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="assigneeSetting">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header"><h5 class="modal-title">Chọn cán bộ phụ trách</h5></div>
        <div class="modal-body">
            <div class="col-12">
                <label class="h6 col-12 mb-2">Chọn cán bộ trách</label>
                <ul class="custom-control-group">
                    <li v-for="(option, ind) in assignees" :key="ind" class="col-12">
                        <div class="custom-control custom-radio custom-control-pro no-control col-12">
                            <input :disabled="option.id == childAct.id_user_assignee" v-model="id_user" type="radio" :value="option.id" name="std-cbl" class="custom-control-input" :id="`assignee-${ind}`">
                            <label class="custom-control-label col-12" :for="`assignee-${ind}`">{{option.ho + ' ' + option.ten}} - {{ option.username }}</label>
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
        assignees: {type: Array},
        childAct: {type: Object}
    },
    data(){
        return{
            id_user: null,
        }
    },
    computed:{
        id_user_assignee:{
            get(){
                const act = JSON.parse(JSON.stringify(this.childAct));
                this.id_user = act.id_user_assignee;
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
            changeAssigneeSetting: 'activity/changeAssigneeSetting',
        }),
        closeModal(){
            this.id_user = null;
            this.$emit('closeModal');
        },
        async onSave(){
            this.$nextTick(() => {
                $('#assigneeSetting').modal('hide');
            });
            this.$loading(true);
            const act = JSON.parse(JSON.stringify(this.childAct));
            const data = {
                id: act.id,
                id_user_assignee: this.id_user,
            }
            console.log(data);
            await this.changeAssigneeSetting(data);
            this.$loading(false);
            this.id_user = null;
            this.$emit('onSave');
        }
    },
}
</script>

<style>

</style>
