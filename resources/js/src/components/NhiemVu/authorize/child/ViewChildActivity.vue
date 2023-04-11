<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="viewChildAct">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a @click="closeModal()" class="close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Thông tin hoạt động</h5></div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="h5 ml-auto col-10">{{actInfo.name}}</label><br>
                            <label class="form-label">Thời gian</label>
                            <div v-if="canEdit" class="d-inline">
                                <span v-if="!editFlg" @click="onEdit()" class="btn btn-sm text-success"><em class="ni ni-edit"></em>Thay đổi</span>
                                <span v-if="editFlg" @click="onUpdate()" class="btn btn-sm text-success"><em class="ni ni-check"></em>Lưu</span>
                                <span v-if="editFlg" @click="onCancel()" class="btn btn-sm text-danger">Hủy</span>
                            </div><br>
                            <label class="form-label">Thời gian bắt đầu:&nbsp;</label>
                            <span v-if="!editFlg">{{actInfo.start_time}}</span>
                            <date-picker v-if="editFlg" v-model="act_info.start_time"
                                                    :show-second="false"
                                                    :confirm="true"
                                                     format="HH:mm DD-MM-YYYY" type="datetime"
                                                     placeholder="Chọn thời gian bắt đầu">
                                                    </date-picker>
                            <br>
                            <label class="form-label">Thời gian kết thúc:&nbsp;</label>
                            <span v-if="!editFlg">{{actInfo.end_time}}</span>
                            <date-picker v-if="editFlg" v-model="act_info.end_time"
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
            act_info: {
                start_time: '',
                end_time: '',
            },
        }
    },
    computed:{
        childActType(){
            return constants.HOAT_DONG;
        },
        actInfo(){
            let info = JSON.parse(JSON.stringify(this.childActInfo));
            info.start_time = info.start_time ? dateTimeUtils.dateTimeVnFormat(info.start_time) : '';
            info.end_time = info.end_time ? dateTimeUtils.dateTimeVnFormat(info.end_time) : '';
            return info;
        },
        canEdit(){
            const now = new Date();
            const endTime = new Date(this.childActInfo.end_time);
            return this.actInfo.child_activity_type == this.childActType.PHAN_THI_OR_TIEU_BAN
                && now < endTime; // quá thời gian hiện tại thì không được cập nhật
        }
    },
    methods:{
        ...mapActions({
            updateChildActivity: "activity/updateChildActivity",
        }),
        onEdit(){
            this.editFlg = true
            this.act_info.start_time = '';
            this.act_info.end_time = '';
        },
        onUpdate(){
            if(!this.act_info.start_time || !this.act_info.end_time){
                this.$swal.fire(
                'Lỗi dữ liệu!',
                'Vui lòng chọn thời gian hợp lệ.',
                'error'
                )
            }
            else {
                if(this.act_info.start_time > this.act_info.end_time){
                    this.$swal.fire(
                    'Lỗi dữ liệu!',
                    'Vui lòng chọn thời gian hợp lệ.',
                    'error'
                    )
                }
                else {
                    this.$swal.fire({
                    title: 'Chú ý!',
                    text: 'Thay đổi thời gian sẽ làm thay đổi thông báo đến các lớp. Để tránh trùng lặp về thời gian, các lớp sẽ phải chọn lại danh sách dự thi và danh sách người tham gia cho hoạt động này.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Tiếp tục',
                    confirmButtonColor: '#98c379',
                    cancelButtonText: 'Hủy'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            this.$nextTick(() => {
                                $('#viewChildAct').modal('hide');
                            });
                            const start_time = dateTimeUtils.convertTimezoneToDatetime(this.act_info.start_time);
                            const end_time = dateTimeUtils.convertTimezoneToDatetime(this.act_info.end_time);
                            const data = {
                                id: this.childActInfo.id,
                                start_time: start_time,
                                end_time: end_time,
                            }
                            this.$loading(true);
                            await this.updateChildActivity(data);
                            this.$loading(false);
                            this.onCancel();
                            this.$emit('onUpdate');
                        }
                    })
                }
            }
        },
        onCancel(){
            this.editFlg = false;
            this.act_info.start_time = '';
            this.act_info.end_time = '';
        },
        closeModal(){
            this.onCancel();
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
