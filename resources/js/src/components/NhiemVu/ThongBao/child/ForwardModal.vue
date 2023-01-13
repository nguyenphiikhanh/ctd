<template>
  <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="forwardModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header"><h5 class="modal-title">{{modalTitle}}</h5></div>
        <div class="modal-body">
          <p v-if="userList.length == 0" class="text-center">
            Không có dữ liệu.
          </p>
            <div class="col-12">
                <div class="form-group">
                    <label class="h5 ml-auto col-10">Chọn sinh viên</label>
                    <div class="custom-control custom-checkbox my-2">
                        <input v-model="select_all" type="checkbox" class="custom-control-input" id="check-all-flg">
                        <label class="custom-control-label" for="check-all-flg">Chọn tất cả</label>
                    </div>
                    <ul class="custom-control-group col-10">
                        <li class="col-12" v-for="(option, index) in userList" :key="index">
                            <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                <input v-model="user_selected" type="checkbox" :value="option.id" class="custom-control-input" :id="`user-${index}`">
                                <label class="custom-control-label" :for="`user-${index}`">{{option.ho + ' ' + option.ten}} (Mã sinh viên: {{option.username}})</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label" for="cp1-profile-description">Ghi chú</label>
                    <div class="form-control-wrap">
                        <textarea @input="changeDetails()" v-model="small_role_details" class="form-control form-control-sm quill-basic" placeholder="Thêm ghi chú"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button @click="forward()" class="btn btn-primary">Chuyển tiếp</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props:{
        readonly: {type: Boolean, default: true},
        userList: {type: Array, default: []}
    },
    data(){
        return{
            user_selected: [],
            select_all: false,

            small_role_details: ''
        }
    },
    methods:{
        closeModal(){
            this.user_selected = [];
            this.select_all = false;
            this.small_role_details = '';
            this.$emit('closeModal');
        },
        async forward(){
            await this.$emit('forward');
            this.closeModal();
        },
        changeDetails(){
            this.$emit('changeDetails', this.small_role_details)
        }
    },
    computed:{
        isValid(){
            return this.userList.length > 0;
        },
        modalTitle(){
            return this.readonly ? 'Chuyển tiếp thông báo' :  'Thêm danh sách';
        }
    },
    watch:{
        select_all(val){
            if(val){
                this.user_selected = [];
                this.userList.map(_item => this.user_selected.push(_item.id));
            } else this.user_selected = [];
        },
        user_selected(val){
            this.$emit('changeSelected', val);
        }
    }
};
</script>

<style>
</style>
