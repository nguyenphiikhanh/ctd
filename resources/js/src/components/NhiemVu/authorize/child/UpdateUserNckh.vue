<template>
    <div class="modal fade modal-lg" tabindex="-1" id="showUserNckh">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
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
              searchText: ''
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
        studentRescources(){
            if(this.searchText){
                return this.userList.filter((item)=>{
                    return this.searchText.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
                })
            }
            else return this.userList;
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
