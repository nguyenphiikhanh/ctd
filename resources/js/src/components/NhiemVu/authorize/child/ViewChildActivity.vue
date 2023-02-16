<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewChildAct">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Thông tin hoạt động</h5></div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="h5 ml-auto col-10">{{actInfo.name}}</label><br>
                            <label class="form-label">Thời gian</label>
                            <div v-if="actInfo.child_activity_type == childActType.PHAN_THI_OR_TIEU_BAN" class="d-inline">
                                <span v-if="!editFlg" @click="onEdit()" class="btn btn-sm-success text-success"><em class="ni ni-edit"></em>Thay đổi</span>
                                <span v-if="editFlg" @click="onUpdate()" class="btn btn-sm-success text-success"><em class="ni ni-check"></em>Lưu</span>
                                <span v-if="editFlg" @click="onCancel()" class="btn btn-sm-secondary text-secondary">Hủy</span>
                            </div><br>
                            <label class="form-label">Thời gian bắt đầu:&nbsp;</label>
                            <span v-if="!editFlg">{{actInfo.start_time}}</span>
                            <date-picker v-else v-model="act_info.start_time"
                                                    :show-second="false"
                                                    :confirm="true"
                                                     format="HH:mm DD-MM-YYYY" type="datetime"
                                                     placeholder="Chọn thời gian kết thúc">
                                                    </date-picker>
                            <br>
                            <label class="form-label">Thời gian kết thúc:&nbsp;</label>
                            <span v-if="!editFlg">{{actInfo.end_time}}</span>
                            <date-picker v-else v-model="act_info.end_time"
                                                    :show-second="false"
                                                    :confirm="true"
                                                     format="HH:mm DD-MM-YYYY" type="datetime"
                                                     placeholder="Chọn thời gian kết thúc">
                                                    </date-picker>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="form-group">
                            <label class="form-label">Nội dung:</label>
                            <div class="form-control-wrap" v-if="actInfo.details" v-html="actInfo.details"></div>
                            <div class="form-control-wrap" v-if="!actInfo.details">Không có nội dung.</div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="form-group">
                            <label class="form-label">Tệp đính kèm:</label>
                            <div class="form-control-wrap" v-if="actInfo.files.length == 0">Không có tệp đính kèm.</div>
                            <div class="form-control-wrap d-block">
                                <a class="d-block mb-1" :href="file.file_path" :download="file.file_name" v-for="(file, index) in actInfo.files" :key="index">
                                    <button class="btn btn-light w-100">
                                        <em class="icon ni ni-file"></em>
                                        {{file.file_name}}
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button @click="closeModal()" class="btn btn-primary">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/locale/vi'
DatePicker.locale('vi');
import constants from '../../../../constants';
import dateTimeUtils from '../../../../helpers/utils/datetimeUtils';
export default {
    props:{
        childActInfo: {
            type: Object
        },
    },
    components:{DatePicker},
    data(){
        return{
            editFlg: false,
            act_info: {},
        }
    },
    computed:{
        childActType(){
            return constants.HOAT_DONG;
        },
        actInfo(){
            this.act_info = JSON.parse(JSON.stringify(this.childActInfo));
            this.act_info.start_time = this.act_info.start_time ? dateTimeUtils.dateTimeVnFormat(this.act_info.start_time) : '';
            this.act_info.end_time = this.act_info.end_time ? dateTimeUtils.dateTimeVnFormat(this.act_info.end_time) : '';
            return this.act_info;
        }
    },
    methods:{
        ...mapActions({

        }),
        onEdit(){
            this.editFlg = true
            this.act_info.start_time = '';
            console.log('st time editing: ', this.act_info.start_time);
            this.act_info.end_time = '';
            console.log('st time editing: ', this.act_info.end_time);
        },
        onUpdate(){
            console.log(this.act_info.start_time);
            console.log(this.act_info.end_time);
        },
        onCancel(){
            this.editFlg = false;
            this.act_info = JSON.parse(JSON.stringify(this.childActInfo));
        },
        closeModal(){
            this.editFlg = false;
            this.$emit('closeModal');
        },
    },
};
</script>

<style scoped>
.blue-text{
    color: #2828e7;
    text-decoration: underline;
}
</style>
