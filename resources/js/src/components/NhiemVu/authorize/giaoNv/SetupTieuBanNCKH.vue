<template>
    <div class="card-inner">
        <h5 class="title mb-4">Chọn danh sách dự thi</h5>
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" v-model="searchText" placeholder="Tìm kiếm">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <ul class="custom-control-group d-flex">
                        <li v-for="(option, index) in studentRescources" :key="index" class="col-4">
                            <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                <input :disabled="option.chooseFlg == chooseFlg.INVALID_VALUE" v-model="student_select" type="checkbox" :value="option.id" class="custom-control-input" :id="`student-${index}`">
                                <label :class="`custom-control-label ${option.chooseFlg == chooseFlg.INVALID_VALUE ? 'text-danger' : ''} col-12`" :for="`student-${index}`">{{option.name}}</label>
                            </div>
                        </li>
                    </ul>
                    <div v-if="studentRescources.length == 0" class="row text-center d-flex justify-content-center"><small>Không có dữ liệu.</small></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from 'vuex'
import { asyncLoading } from 'vuejs-loading-plugin';
import datetimeUtils from '../../../../helpers/utils/datetimeUtils';
import constants from '../../../../constants';
export default {
    props:["start_time", "end_time"],
    data(){
        return{
            auth_user: {},
            students: [],
            student_select: [],
            searchText: '',
        }
    },
    methods:{
        ...mapActions({
            getStudentByFaculty: 'student/getStudentByFaculty',
        }),
        async getStudents(){
            const data = {
                id_faculty: this.auth_user.id_khoa,
            };
            await this.getStudentByFaculty(data).then(res => this.students = res.data);
        },
    },
    computed:{
        studentRescources(){
            if(this.searchText){
                return this.students.filter((item)=>{
                    return this.searchText.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
                })
            }
            else return this.students;
        },
        chooseFlg(){
            return constants.BOOL_VALUE;
        }
    },
    async mounted() {
        this.auth_user = this.$store.getters['auth/user'];
        asyncLoading(this.getStudents());
    },
    watch:{
        student_select(val){
            this.$emit('emitChange', val);
        },
        async start_time(val){
            if(this.end_time){
                const data = {
                    id_faculty: this.auth_user.id_khoa,
                    params:{
                        start_time: datetimeUtils.convertTimezoneToDatetime(this.start_time),
                        end_time: datetimeUtils.convertTimezoneToDatetime(this.end_time)
                    }
                };
                this.student_select = [];
                this.searchText = '';
                await this.getStudentByFaculty(data).then(res => this.students = res.data);
            }
        },
        async end_time(val){
            if(this.start_time){
                const data = {
                    id_faculty: this.auth_user.id_khoa,
                    params:{
                        start_time: datetimeUtils.convertTimezoneToDatetime(this.start_time),
                        end_time: datetimeUtils.convertTimezoneToDatetime(this.end_time)
                    }
                };
                this.student_select = [];
                this.searchText = '';
                await this.getStudentByFaculty(data).then(res => this.students = res.data);
            }
        }
    }
}
</script>

<style scoped>

</style>
