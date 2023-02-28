<template>
    <div class="modal fade modal-lg" tabindex="-1" id="addMemberPopup">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
            <em class="icon ni ni-cross"></em>
          </a>
          <div class="modal-header"><h5 class="modal-title">Chọn sinh viên tham gia nhóm</h5></div>
          <div class="modal-body">
            <p v-if="userList.length == 0" class="text-center">
              Không có dữ liệu.
            </p>
              <div class="col-12">
                  <div class="form-group">
                      <label class="h5 ml-auto col-10">Chọn sinh viên</label>
                      <ul class="custom-control-group col-12">
                          <li class="col-12" v-for="(option, index) in userList" :key="index">
                              <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                  <input :disabled="!option.chooseFlg" v-model="user_selected" type="checkbox" :value="option.id" class="custom-control-input" :id="`user-${index}`">
                                  <label :class="`custom-control-label ${!option.chooseFlg ? 'text-danger' : ''} col-12`"
                                         :for="`user-${index}`">
                                      {{option.ho + ' ' + option.ten}} (Mã sinh viên: {{option.username}})</label>
                              </div>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="modal-footer d-flex justify-content-center">
              <button v-if="user_selected.length > 0" @click="onSave()" class="btn btn-primary">Thêm</button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
      props:{
          userList: {type: Array, default: []}
      },
      data(){
          return{
              user_selected: [],
          }
      },
      methods:{
          closeModal(){
              this.$emit('closeModal');
          },
          onSave(){
            this.$emit("saved", this.user_selected);
          }
      },
      computed:{
          isValid(){
              return this.userList.length > 0;
          },
      },
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
