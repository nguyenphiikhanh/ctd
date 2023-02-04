<template>
    <div class="card-inner">
        <h5 class="title mb-4">Chọn danh sách dự thi</h5>
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" v-model="searchText" @input="searchStudent()" placeholder="Tìm kiếm">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <small v-if="isSearching">Đang tìm kiếm...</small>
                    <ul v-if="!isSearching" class="custom-control-group d-flex">
                        <li v-for="(option, index) in students" :key="index" class="col-4">
                            <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                <input v-model="student_select" type="checkbox" :value="option.id" class="custom-control-input" :id="`student-${index}`">
                                <label class="custom-control-label col-12" :for="`student-${index}`">{{option.name}}</label>
                            </div>
                        </li>
                    </ul>
                    <div v-if="students.length == 0" class="row text-center d-flex justify-content-center"><small>Không có dữ liệu.</small></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from 'vuex'
import { asyncLoading } from 'vuejs-loading-plugin';
export default {
    data(){
        return{
            auth_user: {},
            students: [],
            student_select: [],
            searchText: '',
            isSearching: false,
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
        async searchStudent(){
            this.isSearching = true;
            const data = {
                id_faculty: this.auth_user.id_khoa,
                params: {
                    searchText: this.searchText
                }
            };
            await this.getStudentByFaculty(data).then(res => this.students = res.data);
            this.isSearching = false;
        }
    },
    async mounted() {
        this.auth_user = this.$store.getters['auth/user'];
        asyncLoading(this.getStudents());
    },
    watch:{
        student_select(val){
            this.$emit('emitChange', val);
        }
    }
}
</script>

<style scoped>

</style>
