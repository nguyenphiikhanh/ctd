<template>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="updateForwardModal">
      <div class="modal-dialog modal-dialog-top modal-dialog-scrollable" role="document">
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
                      <ul class="custom-control-group col-12">
                          <li class="col-12" v-for="(option, index) in memberList" :key="index">
                              <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                  <input :disabled="!option.chooseFlg" v-model="user_selected" type="checkbox" :value="option.id" class="custom-control-input" :id="`user-personal-${index}`">
                                  <label :class="`custom-control-label ${!option.chooseFlg ? 'text-danger' : ''} col-12`"
                                         :for="`user-personal-${index}`">
                                      {{option.ho + ' ' + option.ten}} (Mã sinh viên: {{option.username}})</label>
                              </div>
                          </li>
                      </ul>
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
                      <ul class="custom-control-group col-12 mb-2">
                            <li v-for="(member,ind) in team.members" :key="ind" class="col-12">
                                <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                    <input type="checkbox" :value="member.id" class="custom-control-input">
                                    <label :class="`custom-control-label col-11`">{{`${member.ho + ' ' + member.ten} - ${member.username}`}}</label>
                                    <button @click="removeMember(i,ind)" class="btn btn-sm btn-danger"><em class="icon ni ni-cross-sm"></em></button>
                                </div>
                            </li>
                        </ul>
                      <button @click="addMember(i)" class="btn btn-sm btn-outline-warning d-inline w-40" style="margin:auto;">
                          <em class="ni ni-plus"></em>Thêm thành viên
                      </button>
                  </div>
              </template>
          </div>
          <div class="modal-footer d-flex justify-content-center">
              <button v-if="user_selected.length > 0 && validTeam" @click="forward()" class="btn btn-primary">Chuyển tiếp</button>
          </div>
        </div>
        <EditMemberPopup :user-list="memberList" :key="viewKey"
                        @closeModal="closeAddMemberModal()"
                        @saved="onAddMembers"/>
      </div>
    </div>
  </template>

  <script>
import { mapActions } from 'vuex';
  import constants from '../../../../constants';
  import EditMemberPopup from "./userSelect/EditMemberPopup.vue";
  export default {
      components: {EditMemberPopup},

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
              memberList: [],
              index: 0,
              viewKey: 0,
          }
      },
      methods:{
        ...mapActions({
            fetchUserForwarded: 'activity/fetchUserForwarded',
        }),
          closeModal(){
              this.user_selected = [];
              this.select_all = false;
              this.small_role_details = '';
              this.$emit('closeModal');
          },
          closeAddMemberModal(){
              this.$nextTick(() => {
                  $('#editMemberPopup').modal('hide');
              });
          },
          async forward(){
              await this.$emit('forward', this.act.id,
               this.act.child_activity_type == this.action.TB_GUI_DS_THAM_DU && this.act.join_type == this.joinType.THI_NHOM,
                this.userActTeams);
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
              this.index = index;
              this.viewKey++;
              this.$nextTick(() => {
                  $('#editMemberPopup').modal('show');
              });
          },
          onAddMembers(members){
              members.map(id => {
                  const memberAdd = this.memberList.find(member => member.id == id);
                  this.userActTeams[this.index].members.push(Object.assign({...memberAdd}));
                  this.memberList.map(member => {
                      if(member.id == id){
                          member.chooseFlg = false;
                      }
                  });
                  this.user_selected.push(id);
              })
              this.$nextTick(() => {
                $('#editMemberPopup').modal('hide');
            });
          },
          removeMember(teamIndex, memberIndex){
              const member = this.userActTeams[teamIndex].members[memberIndex];
              this.user_selected = this.user_selected.filter(id => id != member.id);
              this.memberList.map(_item => {
                  if(_item.id == member.id){
                      _item.chooseFlg = true;
                  }
              });
              this.userActTeams[teamIndex].members.splice(memberIndex, 1);
          },
          deleteTeam(index){
              const delMembers = this.userActTeams[index].members;
              delMembers.map(member => {
                  this.user_selected = this.user_selected.filter(id => id != member.id);
                  this.memberList.map(_item => {
                      if(_item.id == member.id){
                          _item.chooseFlg = true;
                      }
                  });
              });
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
          },
          validTeam(){
            return this.userActTeams.length > 0 ? !this.userActTeams.some(team => !team.members.length > 0) : true;
        }
      },
      watch:{
          user_selected(val){
              this.$emit('changeSelected', val);
          }
      },
      async mounted(){
        this.memberList = JSON.parse(JSON.stringify(this.userList));
        if(this.act.id){
          const data = {
            id: this.act.id_activities_details_assign,
            child_activity_type: this.act.child_activity_type,
            team_flg: this.act.child_activity_type == this.action.TB_GUI_DS_THAM_DU && this.act.join_type == this.joinType.THI_NHOM ? true : null,
          }
          await this.fetchUserForwarded(data).then(res => {
            if(this.act.child_activity_type != this.action.TB_GUI_DS_THAM_DU || this.act.join_type == this.joinType.THI_CA_NHAN){
                [...res.data].map(user => { // thi ca nhan
                    this.user_selected.push(user.id);
                    this.memberList.map(_item => {
                      if(_item.id == user.id){
                          _item.chooseFlg = true;
                      }
                  });
                })
            }
            else{
                this.userActTeams = [...res.data];
                [...this.userActTeams].map(team => { // thi nhom\
                    team.members.map(user => {
                    this.user_selected.push(user.id);
                    this.memberList.map(_item => {
                      if(_item.id == user.id){
                          _item.chooseFlg = false;
                      }
                    });
                    })
                })
            }
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
