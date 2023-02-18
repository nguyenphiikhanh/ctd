<template>
    <div class="modal fade" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" id="createOrUpdateDialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <a @click="closeModal()" href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
        <div class="modal-header">
            <h5 class="modal-title">{{modalTitle}}, năm học&nbsp;{{ currentStudyYear?.year_name }}</h5>
        </div>
        <div class="modal-body">
            <div class="col-12 mb-3">
                <div class="form-group">
                    <label class="form-label">Học kỳ</label>
                    <div class="form-control-wrap">
                        <select class="form-control" v-model="studyTimeObj.id_study_term">
                            <option :value="null">---Chọn học kỳ---</option>
                            <option v-for="(option, i) in studyTerm" :value="option.id" :key="i">{{ option.name }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="form-group">
                    <label class="form-label">Thời gian bắt đầu</label>
                    <div class="form-control-wrap">
                        <date-picker v-model="studyTimeCreateOrEdit.start_time" class="w-100"
                                    :show-second="false"
                                    :confirm="true"
                                    format="HH:mm DD-MM-YYYY" type="datetime"
                                    placeholder="Chọn thời gian bắt đầu"
                                    @confirm="timeValidate()"/>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Thời gian kết thúc</label>
                    <div class="form-control-wrap">
                        <date-picker v-model="studyTimeCreateOrEdit.end_time" class="w-100"
                                    :show-second="false"
                                    :confirm="true"
                                    format="HH:mm DD-MM-YYYY" type="datetime"
                                    placeholder="Chọn thời gian kết thúc"
                                    @confirm="timeValidate()"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button :disabled="!isValid || !isTimeValid" @click="onSave()" class="btn btn-primary">{{ createFlg ? 'Thêm' : 'Lưu' }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/locale/vi'
DatePicker.locale('vi');
import dateTimeUtils from '../../../../helpers/utils/datetimeUtils';

export default {
    components:{
        DatePicker,
    },
    props:{
        createFlg:{type: Boolean, default: false},
        studyTime: {type: Object, default: {}},
        studyTerm: {type: Array},
        currentStudyYear: {type: Object}
    },
    data(){
        return{
            studyTimeObj: {
                id: null,
                id_study_year: null,
                id_study_term: null,
                start_time: '',
                end_time: '',
            }
        }
    },
    computed:{
        studyTimeCreateOrEdit:{
            get(){
                this.studyTimeObj = this.studyTime;
                return this.studyTimeObj;
            },
            set(val){
                this.$emit('changeData', val);
            }
        },
        modalTitle(){
            return this.createFlg ? 'Thêm học kì mới' : 'Chỉnh sửa học kì';
        },
        isTimeValid(){
            if(this.studyTimeObj.start_time && this.studyTimeObj.end_time){
                const startTime = new Date(dateTimeUtils.convertTimezoneToDatetime(this.studyTimeObj.start_time));
                const endTime = new Date(dateTimeUtils.convertTimezoneToDatetime(this.studyTimeObj.end_time));
                return (startTime < endTime);
            }
            else return false;
        },
        isValid(){
            return this.studyTimeObj.id_study_term && this.studyTimeObj.id_study_year &&
                    this.studyTimeObj.start_time && this.studyTimeObj.end_time;
        }
    },
    methods:{
        closeModal(){
            this.$emit('closeModal');
        },
        timeValidate(){
            console.log(this.studyTimeCreateOrEdit.start_time);
            if(this.studyTimeCreateOrEdit.start_time && this.studyTimeCreateOrEdit.end_time){
            const startTime = new Date(dateTimeUtils.convertTimezoneToDatetime(this.studyTimeCreateOrEdit.start_time));
            const endTime = new Date(dateTimeUtils.convertTimezoneToDatetime(this.studyTimeCreateOrEdit.end_time));
            if(startTime > endTime){
                this.$swal.fire(
                'Lỗi dữ liệu!',
                'Vui lòng chọn thời gian hợp lệ.',
                'error'
                )
            }
           }
        },
        onSave(){
            this.$emit('onSave', this.createFlg);
        }
    }

}
</script>

<style>

</style>
