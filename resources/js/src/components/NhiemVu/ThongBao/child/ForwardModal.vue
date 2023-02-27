<template>
  <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" id="forwardModal">
    <div class="modal-dialog modal-dialog-top" role="document">
      <div class="modal-content">
        <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header"><h5 class="modal-title">{{modalTitle}}</h5></div>
        <div v-if="act.child_activity_type != action.TB_GUI_DS_THAM_DU || act.join_type == joinType.THI_CA_NHAN" class="modal-body">
          <p v-if="userList.length == 0" class="text-center">
            Không có dữ liệu.
          </p>
            <div class="col-12">
                <div class="form-group">
                    <label class="h5 ml-auto col-10">Chọn sinh viên</label>
                    <div v-if="readonly" class="custom-control custom-checkbox my-2">
                        <input v-model="select_all" type="checkbox" class="custom-control-input" id="check-all-flg">
                        <label class="custom-control-label" for="check-all-flg">Chọn tất cả</label>
                    </div>
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
            <div class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label" for="cp1-profile-description">Ghi chú</label>
                    <div class="form-control-wrap">
                        <textarea @input="changeDetails()" v-model="small_role_details" class="form-control form-control-sm quill-basic" placeholder="Thêm ghi chú"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="modal-body">
            <div class="col-12">
                <div class="form-group">
                    <label class="h5 ml-auto col-10">Danh sách nhóm dự thi
                        <button @click="addTeam()" class="btn btn-sm btn-success">
                            <em class="icon ni ni-plus-round"></em>Thêm nhóm
                        </button>
                    </label>
                </div>
            </div>
            <p v-if="userActTeams.length == 0" class="text-center mt-4">
               Chưa có nhóm dự thi.
            </p>
            <template v-if="userActTeams.length > 0">
                <div v-for="(team, i) in userActTeams" class="card" :key="i">
                    <b>{{ team.team_name }} - {{ `${team.members.length} thành viên` }}
                        <button @click="deleteTeam(i)" class="btn btn-sm btn-danger p-0"><em class="icon ni ni-trash-empty"></em></button>
                    </b>
                    <!-- <div class="col-12 bordered">Khanh</div> -->
                    <ul class="custom-control-group col-12 mb-2">
                          <li class="col-12">
                              <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                  <input type="checkbox" :value="'khanh'" class="custom-control-input">
                                  <label :class="`custom-control-label col-11`">Khanh</label>
                                  <button class="btn btn-sm btn-danger"><em class="icon ni ni-cross-sm"></em></button>
                              </div>
                          </li>
                          <li class="col-12">
                              <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                  <input type="checkbox" :value="'khanh'" class="custom-control-input">
                                  <label :class="`custom-control-label col-11`">Khanh</label>
                                  <button class="btn btn-sm btn-danger"><em class="icon ni ni-cross-sm"></em></button>
                              </div>
                          </li>
                          <li class="col-12">
                              <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                  <input type="checkbox" :value="'khanh'" class="custom-control-input">
                                  <label :class="`custom-control-label col-11`">Khanh</label>
                                  <button class="btn btn-sm btn-danger"><em class="icon ni ni-cross-sm"></em></button>
                              </div>
                          </li>
                      </ul>
                    <button @click="addMember(i)" class="btn btn-sm btn-outline-warning d-inline w-40" style="margin:auto;">
                        <em class="ni ni-plus"></em>Thêm thành viên
                    </button>
                </div>
            </template>
            <div v-if="user_selected.length > 0" class="col-12 mt-2">
                <div class="form-group">
                    <label class="form-label" for="cp1-profile-description">Ghi chú</label>
                    <div class="form-control-wrap">
                        <textarea @input="changeDetails()" v-model="small_role_details" class="form-control form-control-sm quill-basic" placeholder="Thêm ghi chú"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button v-if="user_selected.length > 0" @click="forward()" class="btn btn-primary">Chuyển tiếp</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import constants from '../../../../constants';
export default {
    props:{
        readonly: {type: Boolean, default: true},
        userList: {type: Array, default: []},
        act: {type: Object}
    },
    data(){
        return{
            user_selected: [],
            select_all: false,
            small_role_details: '',
            userActTeams: [],
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
        },
        addTeam(){
            let data = {
                team_name: `Nhóm ${this.userActTeams.length + 1}`,
                members: [],
            }
            this.userActTeams.push(Object.assign({...data}));
        },
        addMember(index){

        },
        deleteTeam(index){
            this.userActTeams.splice(index, 1);
            this.userActTeams.map((_item, i) => _item.team_name = `Nhóm ${i + 1}`);
        }
    },
    computed:{
        isValid(){
            return this.userList.length > 0;
        },
        modalTitle(){
            return this.readonly ? 'Chuyển tiếp thông báo' :  'Thêm danh sách';
        },
        action(){
            return constants.HOAT_DONG;
        },
        joinType(){
            return constants.HINH_THUC_THI;
        }
    },
    watch:{
        select_all(val){
            if(val){
                this.user_selected = [];
                this.userList.map(_item => {
                    if(_item.chooseFlg){
                        this.user_selected.push(_item.id)
                    }
                });
            } else this.user_selected = [];
        },
        user_selected(val){
            this.$emit('changeSelected', val);
        }
    },
    async mounted(){
        if(this.act.child_activity_type == this.action.TB_GUI_DS_THAM_DU){

        }
    }
};
</script>

<style>
</style>
