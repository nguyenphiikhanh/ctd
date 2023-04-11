<template>
    <div class="modal fade modal-lg" tabindex="-1" id="showUserNckh">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <a @click="closeModal()" class="close">
            <em class="icon ni ni-cross"></em>
          </a>
          <div class="modal-header"><h5 class="modal-title">Sửa danh sách dự thi NCKH</h5></div>
          <div class="modal-body">
              <div class="col-12">
                  <div class="form-group">
                      <label class="h5 ml-auto col-10">Chọn sinh viên</label>
                      <input v-model="searchText" type="text" class="form-control w-50 my-2" placeholder="Tìm kiếm">
                      <ul class="custom-control-group col-12">
                          <li class="col-12" v-for="(option, index) in studentRescources" :key="index">
                              <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                  <input :disabled="!option.chooseFlg" v-model="user_selected" type="checkbox" :value="option.id" class="custom-control-input" :id="`user-${index}`">
                                  <label :class="`custom-control-label ${!option.chooseFlg ? 'text-danger' : ''} col-12`"
                                         :for="`user-${index}`">{{ option.name }}</label>
                              </div>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
          <p v-if="studentRescources.length == 0" class="text-center">
              Không có dữ liệu.
            </p>
          <div class="modal-footer d-flex justify-content-center">
              <button v-if="user_selected.length > 0" @click="onSave()" class="btn btn-primary">Cập nhật</button>
              <button @click="closeModal()" class="btn btn-secondary">Đóng</button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
import { mapActions } from 'vuex';
import constants from '../../../../constants';
  export default {
      props:{
          userList: {type: Array, default: []},
          childAct: {type: Object, default: {}},
      },
      data(){
          return{
              user_selected: [],
              searchText: '',
              userListClone: [],
          }
      },
      methods:{
        ...mapActions({
            getListUserNckh: "activity/getListUserNckh",
            updateUserNckh: "activity/updateUserNckh",
        }),
          closeModal(){
            this.user_selected = [];
            this.searchText = '';
            this.$nextTick(() => {
                $('#showUserNckh').modal('hide');
            });
            this.$emit('closeModal');
          },
          async onSave(){
            this.$nextTick(() => {
                $('#showUserNckh').modal('hide');
            });
            this.$loading(true);
            const uniqueUserSelected = this.user_selected.filter((value, index, self) => {
                return self.indexOf(value) === index;
                });
            const data = {
                id_child_activity: this.childAct.id,
                user_ids: uniqueUserSelected,
            }
            await this.updateUserNckh(data);
            this.$loading(false);
            this.closeModal();
          }
      },
      computed:{
        studentRescources(){
            if(this.searchText){
                return this.userListClone.filter((item)=>{
                    return this.searchText.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
                })
            }
            else return this.userListClone;
        },
      },
      async mounted(){
        this.userListClone = JSON.parse(JSON.stringify(this.userList));
        if(this.childAct.id){
            await this.getListUserNckh(this.childAct.id).then(res => this.user_selected = [...res.data]);
            this.user_selected.map(id => {
                let userSelected = this.userListClone.find(user => user.id == id);
                userSelected.chooseFlg = constants.BOOL_VALUE.VALID_VALUE;
            });
        }
      }
  };
  </script>

  <style scoped>
  .modal-dialog-scrollable {
      height: calc(100% - 3.5rem);
  }
  .modal-dialog-scrollable .modal-body {
      overflow-y: auto;
  }
  </style>
